<?php

namespace Tests\Feature;

use App\Awards\FollowedOneHundredAccounts;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Tweet;
use App\Models\User;
use App\Models\UserFollows;
use Tests\TestCase;

class TwitterTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tweets');

        $response->assertStatus(200);
    }

    public function test_you_cant_create_tweets_when_logged_out()
    {
        $user = User::factory()->create();

        $response = $this->post('/tweets', [
            'tweet' => 'This is a tweet'
        ]);

        $response->assertStatus(302);
        $response->assertRedirectContains('/login');

        $this->assertCount(0, Tweet::all());
    }

    public function test_you_can_create_tweets_when_logged_in()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tweets', [
            'tweet' => 'This is a tweet'
        ]);

        $response->assertStatus(302);
        $response->assertRedirectContains('/tweets');

        $this->assertCount(1, Tweet::all());
    }

    public function test_you_can_follow_a_user_when_logged_in()
    {
        $users = User::factory(2)->create();

        $response = $this->actingAs($users[0])->get('/follow/' . $users[1]->id);

        $response->assertStatus(302);
        $response->assertRedirectContains('/tweets');

        $this->assertDatabaseHas('user_follows', [
            'user_id' => $users[0]->id,
            'followed_user_id' => $users[1]->id
        ]);
    }

    public function test_following_a_user_twice_doesnt_insert_twice()
    {
        $users = User::factory(2)->create();
        UserFollows::factory()->create([
            'user_id' => $users[0]->id,
            'followed_user_id' => $users[1]->id
        ]);

        $response = $this->actingAs($users[0])->get('/follow/' . $users[1]->id);

        $response->assertStatus(302);
        $response->assertRedirectContains('/tweets');

        $this->assertCount(1, UserFollows::all());
    }

    public function test_award_is_given_after_100_follows_met()
    {
        $users = User::factory(100)->create();

        // follow 99 users..
        foreach ($users as $key => $user) {
            if ($key === 0) {
                continue;
            }

            UserFollows::create([
                'user_id' => $users[0]->id,
                'followed_user_id' => $user->id
            ]);
        }

        $this->assertDatabaseMissing('user_awards', [
            'user_id' => $users[0]->id,
            'award_id' => (new FollowedOneHundredAccounts)->getId()
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($users[0])->get('/follow/' . $user->id);

        $response->assertStatus(302);
        $response->assertRedirectContains('/tweets');

        $this->assertDatabaseHas('user_awards', [
            'user_id' => $users[0]->id,
            'award_id' => (new FollowedOneHundredAccounts)->getId()
        ]);
    }

}