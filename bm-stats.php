#!/usr/bin/php
<?php
	define('SESSION_TYPE_PRIVATE_VOICE',	5);
	define('SESSION_TYPE_GROUP_VOICE',		7);

	ini_set('display_errors','On');
	error_reporting(E_ALL);

	chdir(dirname(__FILE__));

	include('config.inc.php');
	include('functions.inc.php');
	include(PHPMQTT_PATH);

	$mqtt = new phpMQTT('localhost', 1883, __FILE__);
	if (!$mqtt->connect()) {
		echo "error: can't connect to mqtt\n";
		return 1;
	}

	$topics['Master/' . NETWORK_ID . '/Session/#'] = array('qos' => 0, 'function' => 'mqtt_procmsg');
	$mqtt->subscribe($topics, 0);

	echo "starting main loop\n";
	while ($mqtt->proc())
		;

	$mqtt->close();
?>
