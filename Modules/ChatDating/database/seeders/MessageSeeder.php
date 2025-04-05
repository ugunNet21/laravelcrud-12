<?php
namespace Modules\ChatDating\database\seeders;

use Illuminate\Database\Seeder;
use Modules\ChatDating\app\Models\Message;
use Modules\ChatDating\app\Models\UserChat;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        $users = UserChat::all();

        // Create messages
        Message::create([
            'sender_id'   => $users[1]->id, // User One
            'receiver_id' => $users[2]->id, // User Two
            'message'     => 'Hello, how are you?',
        ]);

        Message::create([
            'sender_id'   => $users[2]->id, // User Two
            'receiver_id' => $users[1]->id, // User One
            'message'     => 'I am fine, thank you!',
        ]);

        Message::create([
            'sender_id'   => $users[1]->id, // User One
            'receiver_id' => $users[3]->id, // User Three
            'message'     => 'Can we be friends?',
        ]);
    }
}
