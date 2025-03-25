<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $temp = session('temp_reservation');

        return [
            'date' => ['required', 'after_or_equal:today'],
            'time' => ['required'],
            'guest_count' => ['required'],
        ];
    }

    public function validationData()
    {
        return session('temp_reservation') ?? [];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.after_or_equal' => '過去の日付は選択できません',
            'time.required' => '時間を選択してください',
            'guest_count.required' => '人数を選択してください',
        ];
    }
}
