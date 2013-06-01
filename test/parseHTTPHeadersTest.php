<?php

/**
 * parseHTTPHeaders() should return a associative array from an HTTP header string, parsed according to rfc2616 section 4.2.
 *
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec4.html#sec4.2
 */

require_once __DIR__ . '/../lib/parseHTTPHeaders.php';

class ParseHTTPHeadersTest extends PHPUnit_Framework_TestCase {

	public function testParseHTTPHeaders() {
		$response = join("\r\n", array(
			'Date: Sat, 01 Jun 2013 19:03:12 GMT',
			'Content-Encoding: gzip',
			'Last-Modified: Sat, 01 Jun 2013 22:41:09 GMT',
			'Server: Apache/2.2.21 (FreeBSD) mod_ssl/2.2.21 OpenSSL/0.9.8q PHP/5.4.16-dev',
			'X-Powered-By: PHP/5.4.16-dev',
			'Vary: Cookie,User-Agent,Accept-Encoding',
			'Content-language: en',
			'Connection: close',
			'Content-Type: text/html;charset=utf-8',
			'Link: <http://php.net/http-parse-headers>; rel=shorturl',
			'Content-Length: 6930',
			'',
			'... Body text ...'
		));

		$expectation = array(
			'Date' => 'Sat, 01 Jun 2013 19:03:12 GMT',
			'Content-Encoding' => 'gzip',
			'Last-Modified' => 'Sat, 01 Jun 2013 22:41:09 GMT',
			'Server' => 'Apache/2.2.21 (FreeBSD) mod_ssl/2.2.21 OpenSSL/0.9.8q PHP/5.4.16-dev',
			'X-Powered-By' => 'PHP/5.4.16-dev',
			'Vary' => 'Cookie,User-Agent,Accept-Encoding',
			'Content-language' => 'en',
			'Connection' => 'close',
			'Content-Type' => 'text/html;charset=utf-8',
			'Link' => '<http://php.net/http-parse-headers>; rel=shorturl',
			'Content-Length' => '6930'
		);

		$header = explode("\r\n\r\n", $response, 2)[0];

		$result = parseHTTPHeaders($header);

		$this->assertEquals($expectation, $result);
	}
}
