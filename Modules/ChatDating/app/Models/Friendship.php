<?php
namespace Modules\ChatDating\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\ChatDating\Database\Factories\FriendshipFactory;

class Friendship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    public function user()
    {
        return $this->belongsTo(UserChat::class);
    }

    public function friend()
    {
        return $this->belongsTo(UserChat::class, 'friend_id');
    }

    // protected static function newFactory(): FriendshipFactory
    // {
    //     // return FriendshipFactory::new();
    // }
}
