<?php

namespace App\Broadcasting;

use App\User;

class MessagesChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param int $taskId
     * @return bool
     */
    public function join(User $user, int $taskId)
    {
        return $user ? true : false;
    }
}
