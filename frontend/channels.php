<?php

require_once('config.php');
require_once('classes/class.channel.php');

function cmp($a, $b)
{
    if ($a['good'] == $b['good']) {
        return 0;
    }
    return ($a['good'] < $b['good']) ? 1 : -1;
}

// Get Channels
$channels = array();
$res = mysql_query("SELECT DISTINCT(channel) as channel FROM karma");
while($chan = mysql_fetch_assoc($res)) $channels[] = new Channel($chan['channel']);

$goodTotal = 0;
$badTotal = 0;
$channelArray[] = array();
foreach($channels as $channel) {
    $channelName = $channel->getChannelName();
    $channelLink = urlencode($channelName);
    $userCount = $channel->getUserCount();
	$goodKarma = number_format($channel->getPositiveKarma(), 2);
	$badKarma = number_format($channel->getNegativeKarma(), 2);
	$goodTotal += $goodKarma;
	$badTotal += $badKarma;
    $channelArray[] = array('name'=>$channelName, 'link'=>$channelLink, 'users'=>$userCount, 'good'=>$goodKarma, 'bad'=>$badKarma);
}
usort($channelArray, "cmp");
$channelArray[] = array('good'=>$goodTotal, 'bad'=>$badTotal);

$smarty->assign('channelCount', count($channelArray));
$smarty->assign('channels', $channelArray);
$smarty->display('channels.tpl');

?>