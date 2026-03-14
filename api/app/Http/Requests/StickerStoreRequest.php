<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StickerStoreRequest extends FormRequest
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
      'imageId' => ['required', 'exists:images,id'],
    ];
  }

  public function messages(): array
  {
    return [
      'imageId.required' => '画像は必須です。',
      'imageId.exists' => '指定された画像は存在しません。',
    ];
  }
}
