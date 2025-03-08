<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:255'],
            'programming_languages' => ['nullable', 'array'],
            'programming_languages.*' => ['nullable', 'string', 'max:255'],
            'projects' => ['nullable', 'array'],
            'projects.*' => ['nullable', 'string', 'max:255'],
            'certifications' => ['nullable', 'array'],
            'certifications.*' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'industry' => ['nullable', 'string', 'max:255'],
            'banner' => ['nullable', 'image', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
