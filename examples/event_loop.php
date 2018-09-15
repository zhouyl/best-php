<?php

class Task
{
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function run()
    {
        $this->generator->next();
    }

    public function finished()
    {
        return !$this->generator->valid();
    }
}

class Scheduler
{
    protected $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    public function enqueue(Task $task)
    {
        $this->queue->enqueue($task);
    }

    public function run()
    {
        while (!$this->queue->isEmpty()) {
            $task = $this->queue->dequeue();
            $task->run();

            if (!$task->finished()) {
                $this->queue->enqueue($task);
            }
        }
    }
}

function new_task($id)
{
    return new Task(call_user_func(function () use ($id) {
        $start = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            echo sprintf(
                "[%s] task-%s: %d\n",
                date_create()->format('Y-m-d H:i:s.u'),
                $id,
                $i
            );
            usleep(mt_rand(10, 100));
            yield;
        }
        echo sprintf("task-%s cost time: %f\n", $id, microtime(true) - $start);
    }));
}

$start = microtime(true);
$scheduler = new Scheduler();
$scheduler->enqueue(new_task(1));
$scheduler->enqueue(new_task(2));
$scheduler->enqueue(new_task(3));
$scheduler->enqueue(new_task(4));
$scheduler->enqueue(new_task(5));
$scheduler->run();
echo sprintf("total cost time: %f\n", microtime(true) - $start);
