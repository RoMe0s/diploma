<?php

use App\Models\User;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('Author.Task.{task}', function (User $user, Task $task) {
    return $user->id === $task->user_id;
});