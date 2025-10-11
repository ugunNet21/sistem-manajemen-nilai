<!-- resources/js/Pages/Admin/Search/Index.vue -->
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    results: Object,
    query: String
});

const gradeBadgeClass = (grade) => ({
    'bg-green-100 text-green-800': grade === 'A',
    'bg-blue-100 text-blue-800': grade === 'B',
    'bg-yellow-100 text-yellow-800': grade === 'C',
    'bg-red-100 text-red-800': grade === 'D',
});
</script>

<template>
    <div>

        <Head :title="`Hasil Pencarian: ${query}`" />

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                Hasil Pencarian: "{{ query }}"
            </h1>
            <p class="text-gray-600">
                Ditemukan {{ results.students.length }} siswa dan {{ results.grades.length }} nilai
            </p>
        </div>

        <!-- Search Suggestions -->
        <div v-if="results.suggestions && results.suggestions.length > 0"
            class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                <i class="fas fa-lightbulb mr-2"></i>
                Suggestions:
            </h3>
            <div class="flex flex-wrap gap-2">
                <Link v-for="suggestion in results.suggestions" :key="suggestion"
                    :href="route('admin.search', { q: suggestion })"
                    class="px-3 py-1 bg-white text-blue-700 rounded-full text-sm border border-blue-200 hover:bg-blue-100 transition">
                {{ suggestion }}
                </Link>
            </div>
        </div>

        <!-- Students Results -->
        <div v-if="results.students.length > 0" class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-users text-blue-500 mr-2"></i>
                Siswa ({{ results.students.length }})
            </h2>
            <div class="space-y-3">
                <div v-for="student in results.students" :key="student.id"
                    class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div>
                        <h3 class="font-medium text-gray-800">{{ student.nama }}</h3>
                        <p class="text-sm text-gray-600">Kelas: {{ student.kelas }}</p>
                        <p class="text-sm text-gray-600">
                            Rata-rata: {{ parseFloat(student.rata_rata).toFixed(2) }}
                            <span class="px-2 py-1 rounded-full text-xs font-bold ml-2"
                                :class="gradeBadgeClass(student.grade)">
                                {{ student.grade }}
                            </span>
                        </p>
                    </div>
                    <Link :href="student.url"
                        class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-external-link-alt mr-1 text-xs"></i>
                    Detail
                    </Link>
                </div>
            </div>
        </div>

        <!-- Grades Results -->
        <div v-if="results.grades.length > 0" class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-green-500 mr-2"></i>
                Nilai ({{ results.grades.length }})
            </h2>
            <div class="space-y-3">
                <div v-for="grade in results.grades" :key="grade.id"
                    class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div>
                        <h3 class="font-medium text-gray-800">{{ grade.siswa_nama }} - {{ grade.mapel }}</h3>
                        <p class="text-sm text-gray-600">Kelas: {{ grade.kelas }}</p>
                        <p class="text-sm text-gray-600">
                            Nilai: {{ grade.nilai }}
                            <span class="px-2 py-1 rounded-full text-xs font-bold ml-2"
                                :class="gradeBadgeClass(grade.grade)">
                                {{ grade.grade }}
                            </span>
                        </p>
                    </div>
                    <Link :href="grade.url"
                        class="px-3 py-1 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition flex items-center">
                    <i class="fas fa-external-link-alt mr-1 text-xs"></i>
                    Lihat
                    </Link>
                </div>
            </div>
        </div>

        <!-- No Results dengan suggestions -->
        <div v-if="results.students.length === 0 && results.grades.length === 0"
            class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="fas fa-search fa-3x text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-800 mb-2">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-600 mb-4">Coba dengan kata kunci yang berbeda atau lebih spesifik</p>

            <div class="flex justify-center gap-3 flex-wrap">
                <Link :href="route('admin.students.index')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                <i class="fas fa-users mr-2"></i>Lihat Semua Siswa
                </Link>
                <Link :href="route('admin.grades.index')"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                <i class="fas fa-chart-bar mr-2"></i>Lihat Semua Nilai
                </Link>
            </div>
        </div>
    </div>
</template>