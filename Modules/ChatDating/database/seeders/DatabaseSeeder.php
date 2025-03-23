<?php
namespace Modules\ChatDating\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserChatSeeder::class,
            FriendshipSeeder::class,
            MessageSeeder::class,
        ]);

    }
}
