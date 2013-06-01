<?php

/**
 * Parses an HTTP header string into an associative array.
 *
 * @param $rawHeaders String
 * @return array
 */

function parseHTTPHeaders($rawHeaders)
{
	$headers = [];

	foreach(explode("\n", $rawHeaders) as $i => $header) {
		$header = trim($header);
		list($key, $value) = explode(':', $header, 2);

		if(isset($value)) {
			$headers[$key] = $value;
		}

		return $headers;
	}
}
