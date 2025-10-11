<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $studentId = $this->route('id');

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('siswa', 'nama')->ignore($studentId),
            ],
            'kelas' => ['required', 'string', 'max:50'],
        ];
    }
}
