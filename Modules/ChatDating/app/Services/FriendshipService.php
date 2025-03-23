<?php
// namespace App\Services;
namespace Modules\ChatDating\app\Services;


use Modules\ChatDating\app\Models\Friendship;

class FriendshipService
{
    public function getAllFriendships()
    {
        return Friendship::all();
    }

    public function createFriendship(array $data)
    {
        return Friendship::create($data);
    }

    public function updateFriendship(Friendship $friendship, array $data)
    {
        $friendship->update($data);
        return $friendship;
    }

    public function deleteFriendship(Friendship $friendship)
    {
        $friendship->delete();
    }
}
