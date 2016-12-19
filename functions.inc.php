<?php
	function sql_connect() {
		$sql = mysqli_connect(DMR_DB_HOST, DMR_DB_USER, DMR_DB_PASSWORD, DMR_DB_NAME);
		if (!$sql) {
			echo "error: can't connect to mysql database!\n";
			return false;
		}

		$sql->query("set names 'utf8'");
		$sql->query("set charset 'utf8'");

		return $sql;
	}

	function is_srcid_valid($id) {
		return preg_match(SRC_ID_REGEX, "$id");
	}

	function mqtt_procmsg($topic, $msg) {
		$msg = json_decode($msg);

		switch ($msg->Event) {
			case 'Session-Stop':
				if (!is_srcid_valid($msg->SourceID))
					return;
				if ($msg->SessionType != SESSION_TYPE_GROUP_VOICE &&
						$msg->SessionType != SESSION_TYPE_PRIVATE_VOICE)
					return;

				$call_length_sec = round(($msg->DataCount*60)/1000);
				echo "call from $msg->SourceID, length: $call_length_sec seconds\n";
				if (!$call_length_sec) {
					echo "  empty call, ignoring\n";
					return;
				}

				$sql = sql_connect();
				if ($sql === false)
					return;

				// Querying stored talktime for the current day.
				$query_response = $sql->query('select `talktime` from `' . DMR_DB_TABLE . '` ' .
					'where `date`="' . date('Y-m-d') . '" and `id`="' .
					$sql->escape_string($msg->SourceID) . '"');
				if (!$query_response) {
					echo "mysql query error: $sql->error\n";
					return;
				}
				$row = $query_response->fetch_row();
				if ($row)
					$current_talk_time_sec = $row[0];
				else
					$current_talk_time_sec = 0;
				echo "  current talk time for this day: $current_talk_time_sec seconds\n";

				$result = $sql->query('replace into `' . DMR_DB_TABLE . '` ' .
					'(`id`, `date`, `talktime`) values (' .
					'"' . $sql->escape_string($msg->SourceID) . '", now(), "' .
					($current_talk_time_sec + $call_length_sec) . '")');
				if (!$result) {
					echo 'mysql query error: ' . mysqli_error();
					return;
				}

				$sql->close();

				echo "  added to database\n";
				break;
		}
	}
?>
