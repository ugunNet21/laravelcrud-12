<?php
// namespace App\Repositories;
namespace Modules\ChatDating\app\Repositories;

// use App\Models\User;
use Modules\ChatDating\app\Models\UserChat;


class UserChatRepository
{
    public function getAll()
    {
        return UserChat::all();
    }

    public function getById($id)
    {
        return UserChat::findOrFail($id);
    }

    public function create(array $data)
    {
        return UserChat::create($data);
    }

    public function update(UserChat $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(UserChat $user)
    {
        $user->delete();
    }
}
