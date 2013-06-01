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

	foreach(explode("\n", $rawHeaders) as $i => $line) {
		$header = explode(':', $line, 2);
		$i = $header[0];

		if(isset($header[1])) {
			$headers[$i] = trim($header[1]);
		}
	}

	return $headers;
}
