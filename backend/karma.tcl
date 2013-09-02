package require Tcl
package require mysqltcl

set userActionQueue("dummy") [list]
set authedUsers [list]
set sqlhandle [mysql::connect -host localhost -user karmalicious -password karmalicious -db karmalicious]
mysql::use $sqlhandle karmalicious

proc msgm:DoKarma {nick host handle text} {
	if [
		regexp {^([A-Za-z0-9^]*)\+\+$} $text hita hitb
	] then {
		putserv "PRIVMSG $nick :$hitb"
		return 1;
	} else {
		return 0;
	}
}

proc pubm:IncreaseKarma {nick host handle chan text} {
	global userActionQueue
	global authedUsers
	set sqlhandle [GetSQLHandle]
	if [regexp {^([A-Za-z0-9]*)\+\+$} $text hita hitb] then {
		if [onchan $hitb $chan] then {
			if {$hitb==$nick} then {
				putserv "PRIVMSG $nick :You can't grant Karma to yourself!"
			} else {
				if [AlreadyGaveKarma $sqlhandle [GetUserID $sqlhandle $nick] [GetUserID $sqlhandle $hitb] ] then {
					putserv "PRIVMSG $nick :Already gave Karma to $hitb within the last minute."
				} else {
					if {[info exists userActionQueue($nick)] == 0} then {
						set userActionQueue($nick) [list]
					}

					set action [list $hitb $chan [GetKarmaForUser $sqlhandle [GetUserID $sqlhandle $nick]]]
					lappend userActionQueue($nick) $action

					if {[lsearch $authedUsers $nick] > -1} then {
						processUserQueue $nick
					} else {
						putserv "PRIVMSG NickServ :ACC $nick"
					}
				}
			}
		} else {
			putserv "PRIVMSG $nick :$hitb is not in this Channel, you can't grant Karma!"
		}
		return 1;
	} else {
		return 0;
	}
}
proc pubm:DecreaseKarma {nick host handle chan text} {
	global userActionQueue
	global authedUsers
	set sqlhandle [GetSQLHandle]
	if [regexp {^([A-Za-z0-9]*)\-\-$} $text hita hitb] then {
		if [onchan $hitb $chan] then {
			if {$hitb==$nick} then {
				putserv "PRIVMSG $nick :You can't ruin Karma from yourself! Idiot.."
			} else {
				if [AlreadyRuinedKarma $sqlhandle [GetUserID $sqlhandle $nick] [GetUserID $sqlhandle $hitb] ] then {
					putserv "PRIVMSG $nick :Already ruined Karma of $hitb within the last minute."
				} else {
					if {[info exists userActionQueue($nick)] == 0} then {
						set userActionQueue($nick) [list]
					}

					set action [list $hitb $chan [expr [GetKarmaForUser $sqlhandle [GetUserID $sqlhandle $nick]] * -1]]
					lappend userActionQueue($nick) $action

					if {[lsearch $authedUsers $nick] > -1} then {
						processUserQueue $nick
					} else {
						putserv "PRIVMSG NickServ :ACC $nick"
					}
				}
			}
		} else {
			putserv "PRIVMSG $nick :$hitb is not in this Channel, you can't grant Karma!"
		}
		return 1;
	} else {
		return 0;
	}
}

proc pub:GetKarma {nick host handle chan text} {

	if [string length $text] then {
		set nick $text
	}

	set sqlhandle [GetSQLHandle]

	mysql::use $sqlhandle karmalicious
	set id [GetUserID $sqlhandle $nick]
	set res [mysql::sel $sqlhandle "SELECT sum(karma.karma) as karmasum FROM karma, users WHERE karma.destination=users.id AND users.id='$id' GROUP BY users.id" -flatlist]
	set karmasum [lindex $res 0]

	if {[string length $karmasum]==0} then {
		putserv "PRIVMSG $chan :$nick has never received any Karma..."
		return 0
	}
    set karmasum [expr $karmasum + 1]
	set inflKarma [expr $karmasum/100+1]
	set userLevelString [GetUserLevelString $id]
	putserv "PRIVMSG $chan :$nick currently has a total Karma of [format "%.2f" $karmasum] (IK:[format "%.2f" $inflKarma] +[getPositiveKarma $sqlhandle $id]/-[getNegativeKarma $sqlhandle $id]) $userLevelString"
}

### Karma features ###
proc getPositiveKarma {sqlhandle id} {
	set res [mysql::sel $sqlhandle "SELECT * FROM karma WHERE karma.destination='$id' AND karma.karma>0"]
	return $res
}
proc getNegativeKarma {sqlhandle id} {
	set res [mysql::sel $sqlhandle "SELECT * FROM karma WHERE karma.destination='$id' AND karma.karma<0"]
	return $res
}
proc GetKarmaForUser {sqlhandle user} {
	set res [mysql::sel $sqlhandle "SELECT sum(karma.karma) as karmasum FROM karma, users WHERE karma.destination=users.id AND users.id='$user' GROUP BY users.id" -list]
	if {[llength $res]==0} {
		set amount 1
	} else {
		set amount [lindex $res 0]
	}
	return [format "%.2f" [expr $amount / 100 + 1]]
}

### Karma Validation ###
proc AlreadyGaveKarma {sqlhandle source destination} {
	set res [mysql::sel $sqlhandle "SELECT * FROM karma WHERE destination=$destination AND source=$source AND timestamp>UNIX_TIMESTAMP()-60"]
	return $res;
}
proc AlreadyRuinedKarma {sqlhandle source destination} {
	set res [mysql::sel $sqlhandle "SELECT * FROM karma WHERE destination=$destination AND source=$source AND karma<0 AND timestamp>UNIX_TIMESTAMP()-60"]
	return $res;
}
proc GetUserID {sqlhandle user} {
	set res [mysql::sel $sqlhandle "SELECT id FROM users WHERE username='[mysql::escape $sqlhandle $user]'" -flatlist];
	set id [lindex $res 0]
	if {[string length $id]==0} then {
		return [CreateUser $sqlhandle $user];
	} else {
		return $id;
	}
}
proc CreateUser {sqlhandle user} {
	set res [mysql::query $sqlhandle "INSERT INTO users SET username='$user'"]
	return [mysql::insertid $sqlhandle];
}

### User Queue Handling ###
proc processUserQueue {nick} {
	global userActionQueue
	set sqlhandle [GetSQLHandle]
	foreach process $userActionQueue($nick) {
		processUserAction $sqlhandle $process $nick
	}
	set userActionQueue($nick) [list]
}
proc processUserAction {sqlhandle action nick} {
	set source [GetUserID $sqlhandle $nick]
	set destination [GetUserID $sqlhandle [lindex $action 0]]
	set channel [lindex $action 1]
	set amount [lindex $action 2]
	if {[expr [getKarmaCount $sqlhandle] % 100]==0 && $amount > 0} {
		set amount [expr [lindex $action 2] * 2]
		putserv "PRIVMSG $channel :$nick triggered a karma bomb for [lindex $action 0]. [lindex $action 0] receives double karma!"
	}
    set prevLevel [GetUserLevel $destination]
	set res [mysql::query $sqlhandle "INSERT INTO karma SET timestamp=UNIX_TIMESTAMP(), source='$source', destination='$destination', karma='$amount', channel='$channel'"]
    set currentLevel [GetUserLevel $destination]
    if {$currentLevel>$prevLevel} {
        set newFeature [GetNewFeature $currentLevel]
        putserv "PRIVMSG [lindex $action 0] :$nick just got you a level! You're now on level $currentLevel. $newFeature"
    }
}
proc getKarmaCount {sqlhandle} {
	set res [mysql::sel $sqlhandle "SELECT * FROM karma WHERE karma>0"]
	return $res
}

### NickServ Handler ###
proc notc:NickServListener {nick uhost hand text {dest ""}} {
	global authedUsers
	global userActionQueue
	set message [split $text]
	if {$nick == "NickServ"} then {
		if {[lindex $message 1] == "ACC" } then {
			set username [lindex $message 0]
			if {[lindex $message 2] == "3"} then {
				lappend authedUsers $username
				if [llength $userActionQueue($username)] then {
					processUserQueue $username
				}
			} else {
				if {[llength userActionQueue($username)] > 0} then {
                    set userActionQueue($username) [list]
					putserv "PRIVMSG $username :Hey, nice that you want to share some Karma. Unfortunately you need to be registered with NickServ to do that. Type /msg NickServ REGISTER to get some help :)"
                }
			}
		}
	}
}

### RPG ELEMENTS ###
proc GetUserLevelString {userID} {
	set sqlhandle [GetSQLHandle]
    set res [mysql::sel $sqlhandle "SELECT SUM(karma) as sumPosKarma, COUNT(*) as numPosKarma FROM karma WHERE destination='$userID' AND karma>0" -flatlist]
    set posKarma [list [lindex $res 0] [lindex $res 1]];
    set res [mysql::sel $sqlhandle "SELECT SUM(karma) as sumNegKarma, COUNT(*) as numNegKarma FROM karma WHERE destination='$userID' AND karma<0" -flatlist]
    set negKarma [list [lindex $res 0] [lindex $res 1]];

    set res [mysql::sel $sqlhandle "SELECT (SELECT level FROM levels WHERE experience<'[lindex $posKarma 0]' ORDER BY level DESC LIMIT 1) as curLevel,
                            (SELECT experience FROM levels WHERE experience<'[lindex $posKarma 0]' ORDER BY level DESC LIMIT 1) as lowerExperience,
                            (SELECT experience FROM levels WHERE experience>'[lindex $posKarma 0]' ORDER BY level ASC LIMIT 1) as nextLevel" -flatlist]
    set level [list [lindex $res 0] [lindex $res 1] [lindex $res 2]];

    set currentXP [lindex $posKarma 0];
    set nextXP [lindex $level 2];
    set karmaLevel [lindex $level 0];

    return "( LV: $karmaLevel  - EXP: [format "%.2f" $currentXP]/$nextXP )";
}
proc GetUserLevel {userID} {
    set sqlhandle [GetSQLHandle]
    set res [mysql::sel $sqlhandle "SELECT SUM(karma) as sumPosKarma FROM karma WHERE destination='$userID' AND karma>0" -flatlist]
    set res [mysql::sel $sqlhandle "SELECT (SELECT level FROM levels WHERE experience<'[lindex $res 0]' ORDER BY level DESC LIMIT 1) as curLevel" -flatlist]
    return [lindex $res 0]
}
proc GetNewFeature {level} {
    set sqlhandle [GetSQLHandle]
    set res [mysql::sel $sqlhandle "SELECT feature FROM features WHERE level='$level'" -flatlist]
    if {[string length [lindex $res 0]]!=0} {
        return "Additionally you unlocked the following feature: [lindex $res 0]"
    }
    return " "
}

### SQL HANDLE ###
proc GetSQLHandle {} {
	global sqlhandle
	if {[mysql::ping $sqlhandle] == 0} then {
		set sqlhandle [mysql::connect -host localhost -user karmalicious -password karmalicious -db karmalicious]
		mysql::use $sqlhandle karmalicious
	}
	return $sqlhandle
}
proc DestroySQLHandle {handle} {

}

### HANDLER FUNCTIONS
proc msg:JoinHandler {nick user handle text} {
	set textmsg [split $text]
	set chan [lindex $textmsg 0]

	channel add $chan
	return 0
}
proc msg:HelpHandler {nick user handle text} {
	putlog $text
}
proc msg:SetHandler {nick user handle text} {
	set sqlhandle [GetSQLHandle]
	set currentLevel [GetUserLevel [GetUserID $sqlhandle $nick]]
	putserv "PRIVMSG $nick :You're currently on level $currentLevel"
	putlog "$text"
}


bind notc - * notc:NickServListener
bind msg - "/join" msg:JoinHandler
bind msg - "/help" msg:HelpHandler
bind msg - "/set" msg:SetHandler
bind pubm - * pubm:IncreaseKarma
bind pubm - * pubm:DecreaseKarma
bind pub - "!karma" pub:GetKarma