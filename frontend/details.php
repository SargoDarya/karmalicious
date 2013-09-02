<?php

if(!isset($_GET['id']) || $_GET['id']=='') die(header('Location: index.php'));

require_once('config.php');

function getUsernameByID($userID) {
    $res = mysql_query('SELECT username FROM users WHERE id='.$userID.' LIMIT 1');
    $row = mysql_fetch_assoc($res);
    return $row['username'];
}

function ago($tm,$rcs = 0) {
   $cur_tm = time(); $dif = $cur_tm-$tm;
   $pds = array('second','minute','hour','day','week','month','year','decade');
   $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
   for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

   $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
   return $x;
}

// Get User
$userID = mysql_real_escape_string($_GET['id']);
$res = mysql_query("SELECT * FROM users WHERE id='".$userID."'");
$user = mysql_fetch_assoc($res);

$smarty->assign('user', $user['username']);

// Get Karma
$res = mysql_query("SELECT SUM(karma) as sumPosKarma, COUNT(*) as numPosKarma FROM karma WHERE destination='$userID' AND karma>0");
$posKarma = mysql_fetch_assoc($res);
$res = mysql_query("SELECT SUM(karma) as sumNegKarma, COUNT(*) as numNegKarma FROM karma WHERE destination='$userID' AND karma<0");
$negKarma = mysql_fetch_assoc($res);
if($posKarma['sumPosKarma'] == '') $posKarma['sumPosKarma'] = 0.01;
$res = mysql_query("SELECT 
                        (SELECT level FROM levels WHERE experience<".$posKarma['sumPosKarma']." ORDER BY level DESC LIMIT 1) as curLevel, 
                        (SELECT experience FROM levels WHERE experience<".$posKarma['sumPosKarma']." ORDER BY level DESC LIMIT 1) as lowerExperience,
                        (SELECT experience FROM levels WHERE experience>".$posKarma['sumPosKarma']." ORDER BY level ASC LIMIT 1) as nextLevel");
$level = mysql_fetch_assoc($res);

$smarty->assign('currentXP', number_format(round($posKarma['sumPosKarma'], 0), 0, '.', ','));
$smarty->assign('nextXP', number_format($level['nextLevel'], 0, '.', ','));
$smarty->assign('karmaLevel', $level['curLevel']);
$smarty->assign('karma', round($posKarma['sumPosKarma']+$posKarma['sumNegKarma'], 2));
$smarty->assign('karmaPower', 1+round(($posKarma['sumPosKarma']+$posKarma['sumNegKarma'])/100, 2));
$smarty->assign('progress', 100/($level['nextLevel']-$level['lowerExperience'])*round($posKarma['sumPosKarma']-$level['lowerExperience'], 0));

// Get actions
$res = mysql_query("SELECT * FROM karma WHERE destination='$userID' or source='$userID' ORDER BY timestamp DESC LIMIT 10");
$actions = array();
while($action = mysql_fetch_assoc($res)) {
    if($action['destination'] == $userID) {
        $prefix = 'Received';
        $suffix = 'from';
    } else {
        $prefix = 'Gave';
        $suffix = 'to';
    }
    $username = ($action['source']==$userID) ? $action['destination'] : $action['source'];
    $actions[] =  "$prefix ".round($action['karma'],2)." Karma $suffix <a href=\"details.php?id=$username\">".getUsernameByID($username)."</a> <span class=\"timeago\"> ".ago($action['timestamp'])." ago in ".$action['channel']."</span>";
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
$smarty->assign('actions', implode('<br />', $actions));

// setup channels
$res = mysql_query('SELECT DISTINCT channel FROM karma');
$channels = array();
while($row = mysql_fetch_assoc($res)) {
    $channels[] = '<a href="irc://irc.freenode.net'.$row['channel'].'">'.$row['channel'].'</a>';
}
$smarty->assign('channels', join(', ', $channels));

$smarty->assign('name', 'Ned');
$smarty->display('details.tpl');

?>