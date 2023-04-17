<?php

namespace App\Controller;


use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Utils\Coroutine;
use Hyperf\Utils\Parallel;
use Hyperf\Utils\WaitGroup;
use function Sodium\add;


# 路由注解
#[AutoController]
class HomeController extends AbstractController
{

    // Hyperf 会自动为此方法生成一个 /home/index 的路由，允许通过 GET 或 POST 方式请求
    public function index()
    {

        $this->waitgroup();
        $this->parallel();
        echo "over";
    }

    private function waitgroup()
    {
        // 使得主协程一直阻塞等待直到所有相关的子协程都已经完成了任务后再继续运行，
        // 这里说到的阻塞等待是仅对于主协程（即当前协程）来说的，并不会阻塞当前进程。
        $wg = new WaitGroup();
        $wg->add(2);

        go(function () use ($wg) {
            $wg->done();
        });

        go(function () use ($wg) {
            $wg->done();
        });
        $b = $wg->wait();

        return $b;
    }

    // Parallel 特性
    private function parallel()
    {

        $parallel = new Parallel();
        $parallel->add(function () {
            sleep(1);
            return Coroutine::id();
        });

        $parallel->add(function () {
            sleep(1);
            return Coroutine::id();
        });

        try {
            // $results 结果为 [1, 2]
            $results = $parallel->wait();
        } catch (ParallelExecutionException $e) {
            // $e->getResults() 获取协程中的返回值。
            // $e->getThrowables() 获取协程中出现的异常。
        }
        echo "222";
        // parallel 同时最大运行数
        $p = new Parallel(5);
        for ($i =0; $i < 200; $i ++) {
            echo $i . date("Y-m-d H:i:s"). "\n";
            $p->add(function (){
                sleep(1);
                return Coroutine::id();
            });
        }


        try{
            $results = $p->wait();
        } catch(ParallelExecutionException $e){
            // $e->getResults() 获取协程中的返回值。
            // $e->getThrowables() 获取协程中出现的异常。
        }

        return $results;
    }

    // Concurrent 协程运行控制
    private function concurrent() {

    }
}