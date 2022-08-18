<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tweet;
use App\Models\UserFollows;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
        ]);

        Tweet::factory(20)->create([
            'user_id' => $user->id
        ]);

        for ($i = 0; $i < 20; $i++) {
            $user1 = \App\Models\User::factory()->create();

            // create a few tweets for each user
            Tweet::factory(3)->create([
                'user_id' => $user1->id
            ]);

            // follow every 3 users
            if ($i % 3 == 0) {
                UserFollows::factory()->create([
                    'user_id' => $user->id,
                    'followed_user_id' => $user1->id
                ]);
            }
        }

        $this->call(AwardsSeeder::class);
    }
}
