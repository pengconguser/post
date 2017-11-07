<?php

namespace App\Policies;

use App\User;
use App\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        // return $topic->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        return true;
    }
}
