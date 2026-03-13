<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:50'],
      'email' => ['required', 'email', 'max:191', 'unique:users,email'],
      'password' => ['required', 'string']
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => '名前は必須です。',
      'name.string' => '名前は文字列で入力してください。',
      'name.max' => '名前は50文字以内で入力してください。',

      'email.required' => 'メールアドレスは必須です。',
      'email.email' => '有効なメールアドレスを入力してください。',
      'email.max' => 'メールアドレスは191文字以内で入力してください。',
      'email.unique' => 'このメールアドレスは既に登録されています。',

      'password.required' => 'パスワードは必須です。',
      'password.string' => 'パスワードは文字列で入力してください。'
    ];
  }
}
