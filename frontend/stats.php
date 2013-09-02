<?php

require_once('config.php');

function getLevel($posKarma) {
    $res = mysql_query("SELECT level FROM levels WHERE experience<".$posKarma." ORDER BY level DESC LIMIT 1");
    $level = mysql_fetch_assoc($res);

	return $level['level'];
}

// Get User
$levels = mysql_query("SELECT * FROM levels ORDER BY level ASC");
$levelcount = mysql_num_rows($levels);

$smarty->assign('levelcount', $levelcount);

$levelArray = array();
$prevLevel = 0;
while($level = mysql_fetch_assoc($levels)) {
	$level['needed'] = number_format($level['experience']-$prevLevel, 0, ',', '.');
	$prevLevel = $level['experience'];
	$level['experience'] = number_format($level['experience'] , 0, ',', '.');
	$levelArray[] = $level;
}

$res = mysql_query('SELECT SUM(karma) as totalAmount FROM karma WHERE karma>0');
$row = mysql_fetch_assoc($res);
$smarty->assign('karmaamount', number_format($row['totalAmount'],2));
$smarty->assign('communityLevel', getLevel($row['totalAmount']));

$smarty->assign('levels', $levelArray);
$smarty->display('levels.tpl');

?>