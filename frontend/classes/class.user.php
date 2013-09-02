<?php

class User {

    private $userID;
    private $username;
    private $level;
    private $rank;
    private $profilePicture;
    private $positiveKarma = 0;
    private $negativeKarma = 0;
    private $totalKarma = 0;
    private $influencingKarma = 0;
    private $experience = 0;
    private $channels = array();

    public function __construct($userID, $channel="") {
        // Get User Base Data
        $this->userID = mysql_real_escape_string($userID);
        $res = mysql_query("SELECT * FROM users WHERE id='".$this->userID."'");
        $row = mysql_fetch_assoc($res);
        $this->username = $row['username'];
        $this->profilePicture = $row['profilePicture'];
        
        // Get User Karma Data
		$where = '';
		if($channel!="") $where = " AND channel='".$channel."'";
        $res = mysql_query("SELECT * FROM karma WHERE source='".$this->userID."' OR destination='".$this->userID."' ".$where);
        while($row = mysql_fetch_assoc($res)) {
			if($row['destination']==$this->userID) {
	            if($row['karma']>0) {
	                $this->positiveKarma += $row['karma'];
	            } else {
	                $this->negativeKarma += $row['karma'];
	            }
	            $this->channels[$row['channel']] += $row['karma'];
			} else {
	            if($row['karma']>0) {
	                $this->positiveKarmaGiven += $row['karma'];
	            } else {
	                $this->negativeKarmaGiven += $row['karma'];
	            }
			}
        }
        $this->totalKarma = $this->positiveKarma + $this->negativeKarma;
        $this->experience = $this->positiveKarma;
        $this->influencingKarma = 1+($this->totalKarma/100);
        
        $res = mysql_query("SELECT level FROM levels WHERE experience<".$this->positiveKarma." ORDER BY level DESC LIMIT 1");
        $level = mysql_fetch_assoc($res);
        $this->level = $level['level'];
                       
        $res = mysql_query("SELECT destination, SUM(karma) FROM `karma` GROUP BY destination HAVING SUM(ROUND(karma, 2))>'".$this->positiveKarma."'");
        $this->rank = mysql_num_rows($res)+1;
    }
    
    public function getUserID()             { return $this->userID; }
    public function getUsername()           { return $this->username; }
    public function getLevel()              { return $this->level; }
    public function getRank()               { return $this->rank; }
    public function getProfilePicture()     { return $this->profilePicture; }
    public function getPositiveKarma()      { return $this->positiveKarma; }
    public function getNegativeKarma()      { return $this->negativeKarma; }
	public function getPositiveKarmaGiven() { return $this->positiveKarmaGiven; }
	public function getNegativeKarmaGiven() { return $this->negativeKarmaGiven; }
    public function getTotalKarma()         { return $this->totalKarma; }
    public function getInfluencingKarma()   { return $this->influencingKarma; }
    public function getExperience()         { return $this->experience; }
    public function getChannels()           { return $this->channels; }
}

?>