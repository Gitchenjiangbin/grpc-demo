<?php

namespace App\Controller;

use Grpc\HiClient;
use Grpc\HiUser;
class GrpcController extends AbstractController
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    function __construct()
    {
        if (method_exists(parent::class, '__construct')) {
            parent::__construct(...func_get_args());
        }
        $this->__handlePropertyHandler(__CLASS__);
    }
    public function hello()
    {
        // 这个client是协程安全的，可以复用
        $client = new HiClient('127.0.0.1:9503', ['credentials' => null]);
        $request = new HiUser();
        $request->setName('hyperf');
        $request->setSex(1);
        /**
         * @var \Grpc\HiReply $reply
         */
        list($reply, $status) = $client->sayHello($request);
        $message = $reply->getMessage();
        $user = $reply->getUser();
        var_dump(memory_get_usage(true));
        return $message;
    }
}