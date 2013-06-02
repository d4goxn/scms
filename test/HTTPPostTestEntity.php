<?php

/**
 * Send a POST request to create the test entity.
 */

require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

function HTTPPostTestEntity(&$testCase) {
	global $siteInfo;

	$entity = Yaml::parse(file_get_contents(__DIR__ . '/data/testEntity.yml'));

	// curl POST /<entity-name>
	$url = 'http://' . $siteInfo['fqdn'] . '/' . $entity['name'];
	$request = curl_init($url);
	curl_setopt_array($request, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => http_build_query($entity)
	));
	$response = curl_exec($request);

	$testCase->assertEquals(200, curl_getinfo($request, CURLINFO_HTTP_CODE));

	curl_close($request);
}

