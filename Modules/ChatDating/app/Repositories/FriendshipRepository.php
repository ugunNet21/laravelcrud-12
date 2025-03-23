<?php
// namespace App\Repositories;
namespace Modules\ChatDating\app\Repositories;

// use App\Models\Friendship;
use Modules\ChatDating\app\Models\Friendship;

class FriendshipRepository
{
    public function getAll()
    {
        return Friendship::all();
    }

    public function getById($id)
    {
        return Friendship::findOrFail($id);
    }

    public function create(array $data)
    {
        return Friendship::create($data);
    }

    public function update(Friendship $friendship, array $data)
    {
        $friendship->update($data);
        return $friendship;
    }

    public function delete(Friendship $friendship)
    {
        $friendship->delete();
    }
}
