<?php
// namespace App\Repositories;
namespace Modules\ChatDating\app\Repositories;

// use App\Models\Message;
use Modules\ChatDating\app\Models\Message;

class MessageRepository
{
    public function getAll()
    {
        return Message::all();
    }

    public function getById($id)
    {
        return Message::findOrFail($id);
    }

    public function create(array $data)
    {
        return Message::create($data);
    }

    public function update(Message $message, array $data)
    {
        $message->update($data);
        return $message;
    }

    public function delete(Message $message)
    {
        $message->delete();
    }
}
