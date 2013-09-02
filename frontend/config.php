<?php

mysql_connect('localhost', 'karmalicious', 'karmalicious');
mysql_select_db('karmalicious');

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = '/srv/sargodarya.de/www/karmalicious/smarty/templates';
$smarty->compile_dir = '/srv/sargodarya.de/www/karmalicious/smarty/templates_c';
$smarty->cache_dir = '/srv/sargodarya.de/www/karmalicious/smarty/cache';
$smarty->config_dir = '/srv/sargodarya.de/www/karmalicious/smarty/configs';

error_reporting('');

?>
