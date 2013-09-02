<?php

require_once('classes/class.user.php');

class Channel {

    private $channelName = false;
    private $users = array();
    private $userCount = 0;
    private $positiveKarma = 0;
    private $negativeKarma = 0;
    private $totalKarma = 0;

    public function __construct($channelName) {
        $this->channelName = mysql_real_escape_string($channelName);
        $res = mysql_query('SELECT users.id FROM users, karma WHERE karma.channel="'.$this->channelName.'" AND karma.destination=users.id GROUP BY users.username');
        if(!mysql_num_rows($res)) return false;
        while($user = mysql_fetch_assoc($res)) $this->users[] = new User($user['id'], $this->channelName);
        $this->userCount = count($this->users);

		$res = mysql_query("SELECT 
								(SELECT SUM(karma) FROM karma WHERE channel='".$this->channelName."' AND karma>0) as good,
								(SELECT SUM(karma) FROM karma WHERE channel='".$this->channelName."' AND karma<0) as bad");
		$karma = mysql_fetch_assoc($res);
		$this->positiveKarma = $karma['good'];
		$this->negativeKarma = $karma['bad'];
    }

    public function getUsers() {
        return $this->users;
    }
    
    public function getUserCount() {
        return $this->userCount;
    }
    
    public function getChannelName() {
        return $this->channelName;
    }

    public function getPositiveKarma() {
        return $this->positiveKarma;
    }

    public function getNegativeKarma() {
        return $this->negativeKarma;
    }
}

?>