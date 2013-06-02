<?php

/**
 * HTTP interface tests. Requires mod_curl.
 *
 * @author  Dan Ross <ross9885@gmail.com>
 * @license GPLv3 gnu.org/licenses/gpl.html
 */

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/../lib/parseHTTPHeaders.php';
require_once __DIR__ . '/HTTPPostTestEntity.php';

class HTTPInterfaceTest extends PHPUnit_Framework_TestCase {

	/**
	 * Send a HEAD request to '/' and check the header fields.
	 */

	public function testHEADIndex() {
		global $siteInfo;

		// curl HEAD /
		$url = 'http://' . $siteInfo['fqdn'];
		$request = curl_init($url);
		curl_setopt_array($request, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HEADER => 1
		));
		$response = curl_exec($request);
		curl_close($request);

		// Isolate header parameters.
		$headerString = explode("\r\n\r\n", $response, 2)[0];
		$headers = parseHTTPHeaders($headerString);

		$this->assertEquals('text/html', $headers['Content-Type']);
	}

	/**
	 * POST an entity and verify it's existence in the database.
	 */

	public function testPostEntity() {
		global $siteInfo;

		HTTPPostTestEntity($this);
	}
}
