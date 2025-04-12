<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'required', 
                'numeric',
                'digits_between:10,11',
                Rule::unique(User::class)->ignore($this->user()->id)
            ],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // Add publisher-specific validation if user is a publisher
        if (auth()->user()->role === 'Publisher') {
            $rules['job_title'] = ['required', 'string', 'max:255'];
            $rules['identity'] = ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:2048'];
            $rules['publishing_house_id'] = ['nullable', 'exists:publishing_houses,id'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.numeric' => 'The phone number must contain only numbers.',
            'phone.digits_between' => 'The phone number must be between 10 and 11 digits.',
            'image.max' => 'The profile picture must not be larger than 2MB.',
            'identity.max' => 'The identity document must not be larger than 2MB.',
        ];
    }
}