<?php

require_once('config.php');
require_once('classes/class.api.php');

$API = new API();

$funcSelect = 0;

if(isset($_GET['channel']) && trim($_GET['channel'])!='') $funcSelect += 1;
if(isset($_GET['user']) && trim($_GET['user'])!='') $funcSelect += 2;

if(isset($_GET['user']) && !is_numeric($_GET['user'])) {
	$userID = $API->resolveUsernameToID($_GET['user']);
	if($userID === false) $API->Error('no user named '.$_GET['user'].' was found');
} elseif(isset($_GET['user']) && is_numeric($_GET['user'])) {
	$userID = $_GET['user'];
}

switch($funcSelect) {
	case 0:
		$API->Error('no user or channel parameter given for output');
		exit();
		
	case 1:
		$API->displayChannelOverview();
		break;
		
	case 2:
		$API->displayUser($userID);
		break;
		
	case 3:
		$API->displayUserInChannel();
		break;
}

$API->Close();

?>