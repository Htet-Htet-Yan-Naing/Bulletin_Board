<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
class UserRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   

        return [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'pw' => 'required|min:4|confirmed',   
            'profile' => 'required',     ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'pw.required' => 'The password field is required.',
            'pw.min' => 'The password must be at least 4 characters long.',
            'pw.confirmed' => 'The password confirmation does not match.',
            'profile.required' => 'Profile image is required.',
        ];
    }

}
