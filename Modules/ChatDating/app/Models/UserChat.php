<?php
namespace Modules\ChatDating\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

// use Modules\ChatDating\Database\Factories\UserChatFactory;

class UserChat extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'email', 'password', 'latitude', 'longitude',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function friends()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // protected static function newFactory(): UserChatFactory
    // {
    //     // return UserChatFactory::new();
    // }
}
