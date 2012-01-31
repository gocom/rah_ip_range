<?php 	################
	#
	#	rah_ip_range-plugin for Textpattern
	#	version 0.1
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	################

	function rah_ip_range($atts) {
		extract(lAtts(array(
			'message' => 'Access denied',
			'status' => '503',
			'fromip' => '',
			'toip' => '',
			'method' => 'allow',
		),$atts));
		
		$from = ip2long($fromip);
		$to = ip2long($toip);
		$user_ip = ip2long($_SERVER['REMOTE_ADDR']);
		if($user_ip >= $from && $user_ip <= $to) {
			$check = true;
		} else $check = false;
		switch($method) {
			case 'deny' : 
				if($check == true) txp_die(array('msg' => $message,'status' => $status));
			break;
			case 'allow' :
				if($check == false) txp_die(array('msg' => $message,'status' => $status));
			break;
			default : 
				if($check == true) txp_die(array('msg' => $message,'status' => $status));
			break;
		}
		return '';
	}
?>