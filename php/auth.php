<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/clases/autoload.php';

use Firebase\JWT\JWT;
use AlejoASotelo\Usuario;

$request_body = file_get_contents('php://input');
$request = json_decode($request_body);

$ret = array();
if (Usuario::existe($request->username, $request->password) && 
	(($usuario = Usuario::traerPorUsername($request->username)) != false)) {

	// Create a JSON Web Token and send it back to the client.
	$key = "1234";
	$token["iat"] = time() ;
	$token["exp"] = time() + 3600;
	$token["username"] = $usuario->username;
	$token["nombre"] = $usuario->nombre;
	$token["apellido"] = $usuario->apellido;
	$token["tipo"] = $usuario->tipo;
	
	$ret["token_lab4"] = JWT::encode($token, $key);

} else {

	$ret['token_lab4'] = false;

}

echo json_encode($ret);