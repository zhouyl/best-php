<?php

// 所有的 error/warning/notice 都会被捕获
error_reporting(E_ALL);

// 捕获到的错误，都会被转换为 ErrorException
set_error_handler(function ($code, $error, $file, $line) {
    echo sprintf(
        "Called error handler: %s\n",
        json_encode(compact('code', 'error', 'line'))
    );

    // 当错误被 error_reporting 屏蔽时，不转换为 ErrorException
    if (!(error_reporting() & $code)) {
        return false;
    }

    throw new ErrorException($error, $code, 0, $file, $line);
});

// php7+: [Throwable] ErrorException: Use of undefined constant foo - assumed 'foo'
// php5: [Exception] ErrorException: Use of undefined constant foo - assumed 'foo'
try {
    foo;
} catch (Throwable $e) {
    echo sprintf("[Throwable] %s: %s\n", get_class($e), $e->getMessage());
} catch (Exception $e) {
    echo sprintf("[Exception] %s: %s\n", get_class($e), $e->getMessage());
}

echo "\n----------------------------\分隔一下----------------------------\n";

// php7+: [Throwable] Error: Call to undefined function test()
// php5: 无法捕获，抛出 PHP Fatal error 中断
try {
    test();
} catch (Throwable $e) {
    echo sprintf("[Throwable] %s: %s\n", get_class($e), $e->getMessage());
} catch (Exception $e) {
    echo sprintf("[Exception] %s: %s\n", get_class($e), $e->getMessage());
}
