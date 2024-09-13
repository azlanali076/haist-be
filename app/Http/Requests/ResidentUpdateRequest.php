<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResidentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user()->role->name === config('constants.roles.manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Others',
            'room_number' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'avatar' => 'nullable|file|image'
        ];
        return $rules;
    }
}
