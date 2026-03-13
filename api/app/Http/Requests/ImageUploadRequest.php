<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
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
      'file' => ['required', 'image', 'mimes:png', 'max:2048'],
      'directory' => ['required', 'string']
    ];
  }

  public function messages(): array
  {
    return [
      'file.required' => '画像ファイルは必須です。',
      'file.image' => '画像ファイルを選択してください。',
      'file.mimes' => 'png形式の画像ファイルを選択してください。',
      'file.max' => '画像ファイルは2MB以内で選択してください。',

      'directory.required' => '画像保存先は必須です。',
      'directory.string' => '画像保存先は文字列で入力してください。'
    ];
  }
}
