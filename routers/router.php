<?php

/**
 * Route incoming requests to the appropriate handlers, based on their method and URI.
 * If a router exists in the relevant method directory, with the same name as the URI (without the `.php` extension), then that router will handle the request.
 * If the URI doesn't match a router, then `<method>/router.php` will handle the request.
 *
 * e.g.
 *	`GET /search?page=0&page-length=20` maps to `./get/search.php`
 *	`DELETE /__test-entity__` maps to `./delete/router.php`
 */

function routeRequest() {
	$method = $_SERVER['REQUEST_METHOD'];

	// Route a HEAD request just like a GET request. Apache will stop execution and send a response as soon as we try to create some body content
	if($method == "HEAD")
		$method == "GET";

	$uri = $_SERVER['REQUEST_URI'];

	$route = join(DIRECTORY_SEPARATOR, array(
		__DIR__, strtolower($method), substr($uri, 1)
	));

	$indexRoute = join(DIRECTORY_SEPARATOR, array(
		__DIR__, strtolower($method), 'index.php'
	));

	$defaultRoute = join(DIRECTORY_SEPARATOR, array(
		__DIR__, strtolower($method), 'router.php'
	));

	if(file_exists($route))
		require $route;

	elseif($uri == '/' && file_exists($indexRoute))
		require $indexRoute;

	elseif(file_exists($defaultRoute))
		require $defaultRoute;

	else
		http_response_code(405); // Method Not Allowed.
}
