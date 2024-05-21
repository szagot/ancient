<?php

use Ancient\Service\Control;
use Sz\Config\Uri;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

Control::run(new Uri(ROOT));