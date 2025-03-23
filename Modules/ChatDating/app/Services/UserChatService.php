<?php
namespace Modules\ChatDating\app\Services;

// use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\ChatDating\app\Models\UserChat;

class UserChatService
{
    public function getAllUsers()
    {
        return UserChat::all();
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return UserChat::create($data);
    }

    public function updateUser(UserChat $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function deleteUser(UserChat $user)
    {
        $user->delete();
    }
}
