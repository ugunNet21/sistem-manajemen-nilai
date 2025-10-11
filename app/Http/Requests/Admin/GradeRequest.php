<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeRequest extends FormRequest
{
    public function authorize(): bool
    {

        return true;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => 'required|exists:siswa,id',
            'mapel' => [
                'required',
                'string',
                'max:100',
                Rule::unique('nilai')->where(function ($query) {
                    return $query->where('siswa_id', $this->input('siswa_id'));
                })->ignore($this->grade),
            ],
            'nilai' => 'required|integer|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'mapel.unique' => 'Siswa ini sudah memiliki nilai untuk mata pelajaran tersebut.',
        ];
    }
}
