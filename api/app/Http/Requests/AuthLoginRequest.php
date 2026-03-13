<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
    return [
      'email' => ['required', 'email'],
      'password' => ['required', 'string']
    ];
  }

  public function messages(): array
  {
    return [
      'email.required' => 'メールアドレスを入力してください。',
      'email.email' => '有効なメールアドレスを入力してください。',

      'password.required' => 'パスワードを入力してください。',
      'password.string' => 'パスワードは文字列で入力してください。'
    ];
  }
}
