<?php

class errorLog {

	function __construct() {

	}

	public static function newEntry( $msg, $level, $filename, $classname, $functionname ) {
		global $dbConn;

		$query = "INSERT INTO error_log (message, level, filename, classname, functionname, time) VALUES (?, ?, ?, ?, ?, ?)";
		$query_stmt = $dbConn->prepare( $query );

		$now = time();

		$query_stmt->bind_param( 'sisssi', $msg, $level, $filename, $classname, $functionname, $now );
		$query_stmt->execute();

		if( $dbConn->affected_rows > 0 ) {

			return array( 'id' => $dbConn->insert_id );
		}
		else {

			return array( 'id' => 0 );
		}

	}
}


?>