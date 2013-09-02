<?php

require_once('class.user.php');
require_once('class.channel.php');

class API {

	private $xw;

	public function __construct() {
		$this->xw = new XMLWriter();
		$this->xw->openUri('php://output');
		$this->xw->setIndent(true);
		
		$this->xw->startDocument('1.0','UTF-8');
		$this->xw->startElement('data');
	}
	
	public function WriteNode($node, $content) {
		$this->xw->startElement($node);
		$this->xw->text($content);
		$this->xw->endElement();
	}
	
	public function WriteArrayNode($node, $subnode, $arr) {
		$this->xw->startElement($node);
		foreach($arr as $key=>$val) {
			$this->xw->startElement($subnode);
			$this->xw->text($key);
			$this->xw->endElement();
		}
		$this->xw->endElement();
	}
	
	public function Error($content) {
		$this->WriteNode('error', $content);	
		$this->Close();
	}
	
	public function Close() {
		$this->xw->endElement();
		$this->xw->endDocument();
		exit();
	}


	/**
	 * METHODS FOR RETRIEVING
	 */	 	
	public function displayChannelOverview($id, $channel) {
		$user = new User($id, $channel);
		$this->WriteNode('user_id', $user->getUserID());
		$this->WriteNode('username', $user->getUsername());
		$this->WriteNode('level', $user->getLevel());
		$this->WriteNode('total_karma', $user->getTotalKarma());
		$this->WriteNode('influencing_karma', $user->getInfluencingKarma());
		$this->WriteNode('experience', $user->getExperience());
		$this->WriteNode('positive_karma_received', $user->getPositiveKarma());
		$this->WriteNode('negative_karma_received', $user->getNegativeKarma());
		$this->WriteNode('positive_karma_given', $user->getPositiveKarmaGiven());
		$this->WriteNode('negative_karma_given', $user->getNegativeKarmaGiven());
	}
	
	public function displayUser($id) {
		$user = new User($id);
		$this->WriteNode('user_id', $user->getUserID());
		$this->WriteNode('username', $user->getUsername());
		$this->WriteNode('level', $user->getLevel());
		$this->WriteNode('total_karma', $user->getTotalKarma());
		$this->WriteNode('influencing_karma', $user->getInfluencingKarma());
		$this->WriteNode('experience', $user->getExperience());
		$this->WriteNode('positive_karma_received', $user->getPositiveKarma());
		$this->WriteNode('negative_karma_received', $user->getNegativeKarma());
		$this->WriteNode('positive_karma_given', $user->getPositiveKarmaGiven());
		$this->WriteNode('negative_karma_given', $user->getNegativeKarmaGiven());
		$this->WriteArrayNode('channels', 'channel', $user->getChannels());
	}
	
	public function displayUserInChannel() {
	}
	
	public function resolveUsernameToID($user) {
		$res = mysql_query("SELECT id FROM users WHERE username='".mysql_real_escape_string($user)."' LIMIT 1");
		if(!mysql_num_rows($res)) return false;
		$res = mysql_fetch_assoc($res);
		return $res['id'];
	}

}

?>