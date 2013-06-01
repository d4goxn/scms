<?php
/**
 * Test tests: Make sure that PHPUnit runs.
 *
 * @author  Dan Ross <ross9885@gmail.com>
 * @license GPLv3 gnu.org/licenses/gpl.html
 */

require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/../lib/parseHTTPHeaders.php';

class HTTPInterfaceTest extends PHPUnit_Framework_TestCase {

	/**
	 * Send a HEAD request to '/' and check the header fields.
	 *
	 * @return NULL
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
}
