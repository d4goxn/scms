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

	$uri = $_SERVER['REQUEST_URI'];

	$handlerPath = join(DIRECTORY_SEPARATOR, array(
		__DIR__, strtolower($method), substr($uri, 1)
	));

	$defaultHandlerPath = join(DIRECTORY_SEPARATOR, array(
		__DIR__, strtolower($method), 'router.php'
	));

	if(file_exists($handlerPath))
		require $handlerPath;

	elseif(file_exists($defaultHandlerPath))
		require $defaultHandlerPath;

	else
		http_response_code(405); // Method Not Allowed.
}
