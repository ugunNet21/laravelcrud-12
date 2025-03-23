<?php
namespace Modules\ChatDating\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\ChatDating\Database\Factories\MessageFactory;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'read_at'];

    public function sender()
    {
        return $this->belongsTo(UserChat::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(UserChat::class, 'receiver_id');
    }

    // protected static function newFactory(): MessageFactory
    // {
    //     // return MessageFactory::new();
    // }
}
