<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q'));
        
        if (!$query) {
            return redirect()->route('dashboard');
        }

        $searchTerms = $this->parseSearchQuery($query);

        $results = [
            'students' => [],
            'grades' => [],
            'query' => $query,
            'suggestions' => []
        ];

        $results['students'] = Siswa::where(function ($q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->orWhere('nama', 'ilike', "%{$term}%")
                  ->orWhere('kelas', 'ilike', "%{$term}%");
            }
        })
        ->withCount('nilai')
        ->withAvg('nilai', 'nilai')
        ->take(10)
        ->get()
        ->map(function ($siswa) {
            return [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'nilai_count' => $siswa->nilai_count,
                'rata_rata' => $siswa->nilai_avg_nilai,
                'grade' => $siswa->grade,
                'url' => route('admin.students.show', $siswa->id)
            ];
        });

        $results['grades'] = Nilai::with('siswa')
            ->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('mapel', 'ilike', "%{$term}%")
                      ->orWhere('kelas', 'ilike', "%{$term}%")
                      ->orWhere('nilai', 'like', "%{$term}%")
                      ->orWhereHas('siswa', function ($q) use ($term) {
                          $q->where('nama', 'ilike', "%{$term}%");
                      });
                }
            })
            ->take(10)
            ->get()
            ->map(function ($nilai) {
                return [
                    'id' => $nilai->id,
                    'siswa_nama' => $nilai->siswa->nama,
                    'kelas' => $nilai->kelas,
                    'mapel' => $nilai->mapel,
                    'nilai' => $nilai->nilai,
                    'grade' => $nilai->grade,
                    'url' => route('admin.grades.index', ['mapel' => $nilai->mapel])
                ];
            });

        // Generate suggestions jika hasil sedikit
        $results['suggestions'] = $this->generateSuggestions($query, $results);

        return Inertia::render('Admin/Search/Index', [
            'results' => $results,
            'query' => $query
        ]);
    }

    /**
     * Parse search query untuk handle multiple terms dan special cases
     */
    private function parseSearchQuery(string $query): array
    {
        // Remove extra spaces
        $query = preg_replace('/\s+/', ' ', $query);
        
        // Split into terms
        $terms = explode(' ', $query);
        
        return array_filter(array_map(function ($term) {
            $term = trim($term);
            if (empty($term)) return null;
            
            return Str::lower($term);
        }, $terms));
    }

    /**
     * Generate search suggestions
     */
    private function generateSuggestions(string $originalQuery, array $results): array
    {
        $suggestions = [];
        
        // Jika hasil sedikit, cari kemungkinan typo atau suggestions
        $totalResults = count($results['students']) + count($results['grades']);
        
        if ($totalResults < 3) {
            // Suggestion 1: Cari dengan kata yang mirip
            $similarStudents = Siswa::where('nama', 'ilike', substr($originalQuery, 0, 3) . '%')
                ->orWhere('nama', 'ilike', '%' . substr($originalQuery, -3))
                ->take(3)
                ->pluck('nama')
                ->toArray();
            
            $similarSubjects = Nilai::where('mapel', 'ilike', substr($originalQuery, 0, 3) . '%')
                ->distinct()
                ->take(3)
                ->pluck('mapel')
                ->toArray();
            
            $suggestions = array_merge($similarStudents, $similarSubjects);
        }

        // Suggestion 2: Popular searches berdasarkan data yang ada
        if (empty($suggestions)) {
            $suggestions = [
                'Cari semua siswa',
                'Lihat nilai matematika',
                'Data kelas 10'
            ];
        }

        return array_slice($suggestions, 0, 3);
    }

    /**
     * Autocomplete endpoint untuk search suggestions
     */
    public function autocomplete(Request $request)
    {
        $query = Str::lower(trim($request->get('q')));
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = [];

        // Student suggestions
        $studentSuggestions = Siswa::where('nama', 'ilike', "{$query}%")
            ->orWhere('kelas', 'ilike', "{$query}%")
            ->take(5)
            ->get()
            ->map(function ($siswa) {
                return [
                    'type' => 'student',
                    'text' => $siswa->nama,
                    'subtext' => 'Siswa - ' . $siswa->kelas,
                    'url' => route('admin.students.show', $siswa->id)
                ];
            });

        // Subject suggestions
        $subjectSuggestions = Nilai::where('mapel', 'ilike', "{$query}%")
            ->distinct()
            ->take(5)
            ->get(['mapel'])
            ->map(function ($nilai) {
                return [
                    'type' => 'subject',
                    'text' => $nilai->mapel,
                    'subtext' => 'Mata Pelajaran',
                    'url' => route('admin.grades.index', ['mapel' => $nilai->mapel])
                ];
            });

        // Grade suggestions
        $gradeSuggestions = [];
        if (in_array($query, ['a', 'b', 'c', 'd', 'nilai', 'grade'])) {
            $gradeSuggestions = [
                [
                    'type' => 'grade',
                    'text' => 'Grade A (85-100)',
                    'subtext' => 'Filter nilai',
                    'url' => route('admin.grades.index', ['grade' => 'A'])
                ],
                [
                    'type' => 'grade', 
                    'text' => 'Grade B (70-84)',
                    'subtext' => 'Filter nilai',
                    'url' => route('admin.grades.index', ['grade' => 'B'])
                ]
            ];
        }

        $suggestions = array_merge(
            $studentSuggestions->toArray(),
            $subjectSuggestions->toArray(),
            $gradeSuggestions
        );

        return response()->json(array_slice($suggestions, 0, 8));
    }
}