<?php

/*
 * rah_ip_range - Memcached templates for Textpattern CMS
 * https://github.com/gocom/rah_ip_range
 *
 * Copyright (C) 2019 Jukka Svahn
 *
 * This file is part of rah_ip_range.
 *
 * rah_ip_range is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 2.
 *
 * rah_ip_range is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with rah_ip_range. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Compare visitor's IP address to the specified range.
 *
 * @param  array       $atts  Attributes
 * @param  string|null $thing Contents
 * @return string      Parsed contents
 */
function rah_ip_range($atts, $thing = null)
{
    extract(lAtts([
        'message' => gTxt('403_forbidden'),
        'status' => '403',
        'fromip' => '',
        'toip' => '',
        'method' => 'allow',
    ], $atts));

    $from = ip2long($fromip);
    $to = ip2long($toip);
    $user_ip = ip2long(remote_addr());
    $check = $user_ip >= $from && $user_ip <= $to;
    $allow = $method === 'allow';

    if ((!$allow && $check) || ($allow && !$check)) {
        if ($thing === null) {
            txp_die($message, $status);
        }

        return parse(EvalElse($thing, false));
    }

    if ($thing === null) {
        return '';
    }

    return parse(EvalElse($thing, true));
}
