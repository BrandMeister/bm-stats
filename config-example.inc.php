<?php
	define('PHPMQTT_PATH',					'phpMQTT/phpMQTT.php');

	// Network ID from BrandMeister.conf
	define('NETWORK_ID',					2162);

	// MySQL user, password, host, Registry database name and table names.
	define('DMR_DB_USER',					'ham-dmr.hu');
	define('DMR_DB_PASSWORD',				'');
	define('DMR_DB_HOST',					'localhost');
	define('DMR_DB_NAME',					'ham-dmr.hu');
	define('DMR_DB_TABLE',					'dmr-stats');

	// Only DMR IDs matching this regex are counted.
	define('SRC_ID_REGEX',					'/^216/');
?>
