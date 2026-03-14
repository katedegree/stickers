<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MeUpdateRequest extends FormRequest
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
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['sometimes', 'string', 'max:50'],
      'email' => ['sometimes', 'email', 'max:191', 'unique:users,email,' . $this->user()->id],
      'password' => ['sometimes', 'string'],
      'iconImageId' => ['sometimes', 'integer', 'exists:images,id'],
    ];
  }

  public function messages(): array
  {
    return [
      'name.string' => '名前は文字列で入力してください。',
      'name.max' => '名前は50文字以内で入力してください。',

      'email.email' => '有効なメールアドレスを入力してください。',
      'email.max' => 'メールアドレスは191文字以内で入力してください。',
      'email.unique' => 'このメールアドレスは既に登録されています。',

      'password.string' => 'パスワードは文字列で入力してください。',

      'iconImageId.integer' => 'アイコン画像IDは整数で入力してください。',
      'iconImageId.exists' => '指定された画像は存在しません。',
    ];
  }
}
