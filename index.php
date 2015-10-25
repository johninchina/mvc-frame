<?php
set_time_limit(0);

date_default_timezone_set("PRC");

// 切换到当前目录
chdir(__DIR__);

// 自动加载
include './vendor/Frame/Mvc/Autoloader.php';
$autoload = new Frame\Mvc\Autoloader(array('./vendor', './src'));
$autoload->register();

// 创建应用
$config = include './app/config/config.php';
$application = new Frame\Mvc\Application($config);
$application->run();