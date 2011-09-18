<?php
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}

		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		switch ($theType) {
			case "text" :
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long" :
			case "int" :
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double" :
				$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				break;
			case "date" :
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined" :
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}

}
function array_to_json($array) {

	if (!is_array($array)) {
		return false;
	}

	$associative = count(array_diff(array_keys($array), array_keys(array_keys($array))));
	if ($associative) {

		$construct = array();
		foreach ($array as $key => $value) {

			// We first copy each key/value pair into a staging array,
			// formatting each key and value properly as we go.

			// Format the key:
			if (is_numeric($key)) {
				$key = "key_$key";
			}
			$key = "\"" . addslashes($key) . "\"";

			// Format the value:
			if (is_array($value)) {
				$value = array_to_json($value);
			} else if (!is_numeric($value) || is_string($value)) {
				$value = "\"" . addslashes($value) . "\"";
			}

			// Add to staging array:
			$construct[] = "$key: $value";
		}

		// Then we collapse the staging array into the JSON form:
		$result = "{ " . implode(", ", $construct) . " }";

	} else {// If the array is a vector (not associative):

		$construct = array();
		foreach ($array as $value) {

			// Format the value:
			if (is_array($value)) {
				$value = array_to_json($value);
			} else if (!is_numeric($value) || is_string($value)) {
				$value = "'" . addslashes($value) . "'";
			}

			// Add to staging array:
			$construct[] = $value;
		}

		// Then we collapse the staging array into the JSON form:
		$result = "[ " . implode(", ", $construct) . " ]";
	}

	return $result;
}

?>