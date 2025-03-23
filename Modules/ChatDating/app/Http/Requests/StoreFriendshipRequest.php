<?php
namespace Modules\ChatDating\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFriendshipRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id'   => 'required|exists:users,id',
            'friend_id' => 'required|exists:users,id',
            'status'    => 'required|in:pending,accepted,blocked',
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
