<?php

namespace App\Http\Requests\Reviews;

use App\Enums\ReviewStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReviewRequest extends FormRequest
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
            'product_id' => ['prohibited'],
            'content' => ['sometimes', 'string'],
            'rating' => ['sometimes', 'integer', 'between:1,5'],
            'status' => ['sometimes', Rule::enum(ReviewStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id' => 'Changing product_id is not allowed.',
        ];
    }
}
