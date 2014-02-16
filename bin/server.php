<?php

// options
$appDir = isset($argv[$argc - 1]) ? $argv[$argc - 1] : error();
$appDir = adjustAppDir($appDir);
$opt = getopt('', [ "context::", "port::", "php::" ]);
$port = isset($opt['port']) ? $opt['port'] : '8080';
$context = isset($opt['context']) ? $opt['context'] : 'dev';
$php = isset($opt['php']) ? $opt['php'] : 'php';
$router = "{$appDir}/bootstrap/contexts/{$context}.php";
if (! file_exists($router)) {
    $router = "{$appDir}/var/www/index.php";
}

if (! file_exists("{$appDir}/var/www")) {
    error();
}

if (! file_exists($router)) {
    error("invalid context:{$context}");
}

$root =  "{$appDir}/var/www/";
$cmd = "{$php} -S 0.0.0.0:{$port} -t {$root} {$router}";
$spec = [0 => STDIN, 1 => STDOUT, 2 => STDERR];

echo "Starting the BEAR.Sunday development server:{$router}"  . PHP_EOL;
// run the command as a process
$process = proc_open($cmd, $spec, $pipes, $root);
proc_close($process);

/**
 * @param string $msg
 */
function error($msg = 'Usage: php bin/server.php [--port=<port>] [--context=<context>] [--php=<php_bin_path>] <app-dir>')
{
    error_log($msg);
    exit(1);
}

/**
 * 引数のappDirからフルパスのappDirを作成して返す
 *
 * @param $appDir
 * @return string
 */
function adjustAppDir($appDir) {
    // 絶対パスを指定
    if (strpos($appDir, '/') === 0 || preg_match('/^[C-Z]:\w+$/',$appDir) === 1) {
        return $appDir;
    // appsから指定
    } elseif (strpos($appDir, 'apps' . DIRECTORY_SEPARATOR) === 0) {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . $appDir;
    // appDirのみを指定
    } elseif (strpos($appDir, DIRECTORY_SEPARATOR) === false) {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . "apps" .DIRECTORY_SEPARATOR . $appDir;
    } else {
        error();
    }
}
