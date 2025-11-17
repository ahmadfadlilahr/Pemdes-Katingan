<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'status' => 'in:draft,scheduled,ongoing,completed,cancelled',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul agenda wajib diisi',
            'description.required' => 'Deskripsi agenda wajib diisi',
            'start_date.required' => 'Tanggal mulai wajib diisi',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
        ];
    }
}
