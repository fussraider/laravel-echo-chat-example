<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageEvent;
use App\Http\Requests\MessageStoreRequest;

class TaskController extends Controller
{
    public function message(MessageStoreRequest $request)
    {
        $message = $request->user()->messages()->create($request->all());

        if($message->save()) {
            //event(new ChatMessage($message)); // для всех подключенных клиентов
            broadcast(new ChatMessageEvent($message))->toOthers(); // для всех подключенных клиентов, кроме пользователя, оправившего текущее сообщение
        }
    }
}
