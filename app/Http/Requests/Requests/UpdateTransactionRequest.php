<?php

namespace App\Http\Requests\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
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
            'transaction_date' => 'required|date',
            'detail' => 'nullable|string|max:250',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                ->where('user_id', $this->user()->id)
            ],
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',
        ];
    }
}
