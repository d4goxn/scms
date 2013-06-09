<?php

/**
 * Create a new entity.
 */

require_once __DIR__ . '/../../controllers/createEntity.php';

if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false
|| strpos($_SERVER['HTTP_ACCEPT'], '*/*') !== false) {

	try {
		createEntity($_POST);
		header('Content-Type: application/json');
		http_response_code(201);
?>{
	"message": "POST accepted."
}<?php
	} catch(UserError $e) {
		error_log("User error: $e->message");
?>{
	"error": "<?php print $e->message; ?>"
}<?php
	} catch(Exception $e) {
		error_log("/POST/<entity>: $e->message");
		http_response_code(500);
		die;
	}

} else {
	http_response_code(415); // Unsupported Media Type
	header('Content-Type: text/plain');

?>To POST an entity, you must accept an application/json response. This request accepts <?php print($_SERVER['HTTP_ACCEPT']); ?>.<?php

}
