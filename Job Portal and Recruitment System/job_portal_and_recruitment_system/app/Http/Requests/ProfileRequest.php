<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'website' => 'nullable|url',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'resume' => 'nullable|file|mimes:pdf,doc,docx', // 5MB
        ];
    }
}
