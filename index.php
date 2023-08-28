<?php
use Temant\ServerProbe\ServerProbe;

include_once __DIR__ . "/vendor/autoload.php";

echo '<pre>';
print_r(new ServerProbe);
echo '</pre>';