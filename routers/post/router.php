<?php

/**
 * Create a new entity.
 */

if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false
	|| strpos($_SERVER['HTTP_ACCEPT'], '*/*') !== false) {

	$data = json_encode($_POST);
	header('Content-Type: application/json');
	header('Content-MD5: ' . base64_encode(md5($data, true)));

?>{
	"message": "POST accepted. This is a placeholder."
}<?php

} else {
	http_response_code(415); // Unsupported Media Type
	header('Content-Type: text/plain');

?>To POST an entity, you must accept an application/json response. This request accepts <?php print($_SERVER['HTTP_ACCEPT']); ?>.<?php

}
