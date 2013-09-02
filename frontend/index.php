<?php

require_once('config.php');

function getUserLevel($userID) {
    $res = mysql_query("SELECT SUM(karma) as sumPosKarma, COUNT(*) as numPosKarma FROM karma WHERE destination='$userID' AND karma>0");
    $posKarma = mysql_fetch_assoc($res);
    $posKarma['sumPosKarma'] = $posKarma['sumPosKarma']+1-1;

    $res = mysql_query("SELECT level FROM levels WHERE experience<".$posKarma['sumPosKarma']." ORDER BY level DESC LIMIT 1");
    if($res) {
    	$level = mysql_fetch_assoc($res);
	} else {
		return 1;
	}

	return $level['level'];
}

// Get user Count
$res = mysql_query('SELECT COUNT(*) as count FROM users');
$usercount = mysql_fetch_assoc($res);

$res = mysql_query('SELECT (SELECT COUNT(*) FROM karma WHERE karma>0) as positivekarma, (SELECT COUNT(*) FROM karma WHERE karma<0) as negativekarma') or die(mysql_error());
$karmacount = mysql_fetch_assoc($res);

$smarty->assign('usercount', $usercount['count']);
$smarty->assign('karmacount', ($karmacount['positivekarma']+$karmacount['negativekarma']));
$smarty->assign('positivekarma', $karmacount['positivekarma']);
$smarty->assign('negativekarma', $karmacount['negativekarma']);

// Get user top hundred
$res = mysql_query('SELECT users.*, sum(karma.karma)+1 as karmasum FROM karma, (SELECT COUNT(karma.channel) FROM karma, users WHERE destination=users.id) as numchannels, users WHERE karma.destination=users.id GROUP BY users.id ORDER BY karmasum DESC LIMIT 1000') or die(mysql_error());
$i = 1;
$topusers = array();
while($row = mysql_fetch_assoc($res)) {
	$level = getUserLevel($row['id']);

    $topusers[] = array('id'=>$row['id'], 'rank'=>$i++, 'username'=>$row['username'], 'karmasum'=>round($row['karmasum'], 2), 'karmapower'=>round(($row['karmasum']/100+1), 2), 'level'=>$level['curLevel']);
}
$smarty->assign('topusers', $topusers);

// setup channels
$res = mysql_query('SELECT DISTINCT channel FROM karma');
$channels = array();
while($row = mysql_fetch_assoc($res)) {
    $channels[] = '<a href="irc:irc.freenode.net'.$row['channel'].'">'.$row['channel'].'</a>';
}
$smarty->assign('channels', join(', ', $channels));

$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');

?>
