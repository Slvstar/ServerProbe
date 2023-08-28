<?php
use Temant\ServerProbe\Platform\LinuxPlatform;
use Temant\ServerProbe\ServerProbe;

include_once __DIR__ . "/vendor/autoload.php";

$server = new ServerProbe(new LinuxPlatform);

echo '<pre>';
print_r($server->getRandomAccessMemoryUsage()->getUsedPhysicalMemory(true));
echo '</pre>';