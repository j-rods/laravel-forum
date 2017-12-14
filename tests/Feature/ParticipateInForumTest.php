<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** test */
    function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        // be = user sign in
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();

        // make post request and then send through whatever is relevant
        $this->post('Threads/' . $thread->id . '/replies', $reply->toArray());

        $this->get($thread->path())
             ->assertSee($reply->body);
    }
}
