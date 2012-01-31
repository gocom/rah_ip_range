<?php	##################
	#
	#	rah_ip_range-plugin for Textpattern
	#	version 0.3
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	#	Copyright (C) 2011 Jukka Svahn <http://rahforum.biz>
	#	Licensed under GNU Genral Public License version 2
	#	http://www.gnu.org/licenses/gpl-2.0.html
	#
	##################

	function rah_ip_range($atts, $thing=NULL) {

		extract(lAtts(array(
			'message' => 'Access denied',
			'status' => '503',
			'fromip' => '',
			'toip' => '',
			'method' => 'allow'
		),$atts));

		$from = ip2long($fromip);
		$to = ip2long($toip);
		$user_ip = ip2long(remote_addr());
		$check = ($user_ip >= $from && $user_ip <= $to);

		if(
			($method != 'allow' && $check) ||
			($method == 'allow' && !$check)
		) {
			if($thing === NULL)
				txp_die($message, $status);
						
			return $message;
		}

		return $thing !== NULL ? parse($thing) : '';
	}
?>