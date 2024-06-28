<?php

namespace Modules\Kinerja\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IkuUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tahun' => ['required', 'max:4'],
            'nomor' => ['required', 'max:5'],
            'sasaran' => ['required', 'max:100'],
        ];
    }
}
