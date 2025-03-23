<?php namespace Modules\ChatDating\database\seeders;

use Illuminate\Database\Seeder;
use Modules\ChatDating\app\Models\Friendship;
use Modules\ChatDating\app\Models\UserChat;

class FriendshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch users by ID to ensure we have the correct references
        $user1 = UserChat::find(1); // Admin
        $user2 = UserChat::find(2); // User One
        $user3 = UserChat::find(3); // API Admin
        $user4 = UserChat::find(4); // API User One

        // Create friendships with explicit quoting of status values
        Friendship::create([
            'user_id'   => $user2->id, // User One
            'friend_id' => $user3->id, // API Admin
            'status'    => 'accepted',
        ]);

        Friendship::create([
            'user_id'   => $user2->id, // User One
            'friend_id' => $user4->id, // API User One
            'status'    => 'pending',
        ]);

        Friendship::create([
            'user_id'   => $user3->id, // API Admin
            'friend_id' => $user4->id, // API User One
            'status'    => 'blocked',
        ]);
    }
}