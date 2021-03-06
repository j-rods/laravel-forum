<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_a_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();
        
        $this->post('threads/1/replies', []);
    }


    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        // be = user sign in
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        // make post request and then send through whatever is relevant
        $this->post($thread->path(). '/replies', $reply->toArray());

        $this->get($thread->path())
             ->assertSee($reply->body);
    }
}
 