<?php

namespace App\Controller;

use Grpc\HiReply;
use Grpc\HiUser;

class HiController extends AbstractController
{
    public function sayHello(HiUser $user)
    {
        $message = new HiReply();
        $message->setMessage("Hello World");
        $message->setUser($user);
        return $message;
    }

}