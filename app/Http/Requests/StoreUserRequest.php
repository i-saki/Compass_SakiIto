<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // 🔹 ここでは birth_day を事前に作るために prepareForValidation() を使う
        return [
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'under_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'mail_address' => ['required', 'email', 'unique:users,mail_address', 'max:100'],
            'sex' => ['required', 'in:1,2,3'],
            'old_year' => ['required', 'numeric'],
            'old_month' => ['required', 'numeric'],
            'old_day' => ['required', 'numeric'],
            'birth_day' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'role' => ['required', 'in:1,2,3,4'],
            'password' => ['required', 'max:30', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '姓を入力してください。',
            'under_name.required' => '名を入力してください。',
            'mail_address.unique' => 'このメールアドレスはすでに登録されています。',
            'birth_day.after_or_equal' => '生年月日は2000年以降の日付を入力してください。',
        ];
    }

    /**
     * birth_day を生成する
     */
    protected function prepareForValidation()
    {
        $y = $this->input('old_year');
        $m = $this->input('old_month');
        $d = $this->input('old_day');

        if ($y && $m && $d) {
            $this->merge([
                'birth_day' => sprintf('%04d-%02d-%02d', $y, $m, $d)
            ]);
        }
    }

}
