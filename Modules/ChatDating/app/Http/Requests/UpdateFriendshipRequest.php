<?php
namespace Modules\ChatDating\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFriendshipRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => 'sometimes|in:pending,accepted,blocked',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
