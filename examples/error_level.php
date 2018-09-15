<?php

require __DIR__.'/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('test');
$log->pushHandler(new StreamHandler(STDOUT, Logger::DEBUG));

/*
Monolog 的消息级别：

- DEBUG, 100, 调试信息
- INFO, 200, 常规信息
- NOTICE, 250, 提示信息
- WARNING, 300, 警告信息，例如一些特殊的事件
- ERROR, 400, 可以不被重视的一些错误信息
- CRITICAL, 500, 一些严重的错误信息，例如 Exception
- ALTER, 550, 需要立即关注的错误信息，通过该类型的信息应该立即邮件、短信通知
- EMERGENCY, 600, 基本上遇到这类信息，你的年终奖已经打水漂了
*/

// 错误分级，但这些错误是无法捕获的
//      E_ERROR, E_PARSE, E_CORE_ERROR
//      E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING
$levels = [
    // notice
    E_STRICT => Logger::NOTICE,
    E_NOTICE => Logger::NOTICE,
    E_USER_NOTICE => Logger::NOTICE,
    // warning
    E_WARNING => Logger::WARNING,
    E_USER_WARNING => Logger::WARNING,
    // error
    E_USER_ERROR => Logger::ERROR,
    E_RECOVERABLE_ERROR => Logger::ERROR,
];

$names = [
    E_ERROR => 'E_ERROR',
    E_WARNING => 'E_WARNING',
    E_PARSE => 'E_PARSE',
    E_NOTICE => 'E_NOTICE',
    E_CORE_ERROR => 'E_CORE_ERROR',
    E_CORE_WARNING => 'E_CORE_WARNING',
    E_COMPILE_ERROR => 'E_COMPILE_ERROR',
    E_COMPILE_WARNING => 'E_COMPILE_WARNING',
    E_USER_ERROR => 'E_USER_ERROR',
    E_USER_WARNING => 'E_USER_WARNING',
    E_USER_NOTICE => 'E_USER_NOTICE',
    E_STRICT => 'E_STRICT',
    E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
    E_DEPRECATED => 'E_DEPRECATED',
    E_USER_DEPRECATED => 'E_USER_DEPRECATED',
    E_ALL => 'E_ALL',
];

// 所有的 error/warning/notice 都会被捕获
error_reporting(E_ALL);

// 捕获到的错误，都会被转换为 ErrorException
set_error_handler(function ($code, $error, $file, $line) use ($log, $levels, $names) {
    $log->log(
        isset($levels[$code]) ? $levels[$code] : Logger::INFO,
        'handle error ['.$names[$code].']',
        compact('code', 'error', 'line')
    );

    // 当错误被 error_reporting 屏蔽时，不转换为 ErrorException
    if (!(error_reporting() & $code)) {
        return false;
    }

    // throw new ErrorException($error, $code, 0, $file, $line);
});

// 接下来是各种错误
$x['xx'];
array_push();
trigger_error("user error", E_USER_ERROR);
trigger_error("user warning", E_USER_WARNING);
trigger_error("user notice", E_USER_NOTICE);
mktime();
