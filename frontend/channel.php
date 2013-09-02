<?php

if(!isset($_GET['name']) || $_GET['name']=='') die(header('Location: channels.php'));

require_once('config.php');
require_once('classes/class.channel.php');

// Get User
$channel = new Channel(urldecode($_GET['name']));
if(!$channel->getUserCount()) die(header('Location: channels.php'));

$smarty->assign('channelName', $channel->getChannelName());

$users = $channel->getUsers();
$smarty->assign('userCount', count($users));

$userArray = array();
foreach($users as $user) {
    $userArray[] = array('name'=>$user->getUsername(),
						 'userID'=>$user->getUserID(),
						 'positiveKarmaReceived'=>($user->getPositiveKarma()) ? $user->getPositiveKarma() : '/',
						 'negativeKarmaReceived'=>($user->getNegativeKarma()) ? $user->getNegativeKarma() : '/',
						 'positiveKarmaGiven'=> ($user->getPositiveKarmaGiven()) ? $user->getPositiveKarmaGiven() : '/',
						 'negativeKarmaGiven'=> ($user->getNegativeKarmaGiven()) ? $user->getNegativeKarmaGiven() : '/');
}
$smarty->assign('users', $userArray);

$smarty->display('channel.tpl');

?>