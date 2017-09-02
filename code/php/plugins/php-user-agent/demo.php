<?php
require './UserAgentParser.php';
$ua_info = parse_user_agent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36');
var_dump($ua_info);

/*
array(3) {
  ["platform"] => string(7) "Windows"
  ["browser"]  => string(6) "Chrome"
  ["version"]  => string(12) "60.0.3112.90"
}
 */
