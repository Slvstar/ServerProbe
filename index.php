<?php
use Temant\ServerProbe\ServerProbe;

include_once __DIR__ . '/vendor/autoload.php';

$server = new ServerProbe;

echo '<pre>';
print_r($server->getRandomAccessMemoryUsage()->listProcesses());
echo '</pre>';