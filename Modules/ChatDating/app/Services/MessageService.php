<?php
// namespace App\Services;
namespace Modules\ChatDating\app\Services;


use Modules\ChatDating\app\Models\Message;

class MessageService
{
    public function getAllMessages()
    {
        return Message::all();
    }

    public function createMessage(array $data)
    {
        return Message::create($data);
    }

    public function updateMessage(Message $message, array $data)
    {
        $message->update($data);
        return $message;
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();
    }
}
