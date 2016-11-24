<?php
require_once __DIR__.'/clases/autoload.php';

use AlejoASotelo\Usuario;

$request_body = file_get_contents('php://input');
$request = json_decode($request_body);

switch ($request->datos->task) {
	
	case 'listarUsuarios':
		
		$usuarios = Usuario::traerTodos();

		echo json_encode($usuarios);

		break;

	case 'agregarUsuario':

		$ret = array('success' => false);

		$usuario = Usuario::traerPorUsername($request->datos->usuario->username);

		if ($usuario != false) {
			$ret['success'] = false;
			$ret['msg'] = 'El nombre de usuario ya existe.';

		} else {
			$r = Usuario::insertar($request->datos->usuario);
			$ret['success'] = $r > 0;
		}
		

		echo json_encode($ret);

		break;

	case 'borrarUsuario':
		
		$r = Usuario::borrar($request->datos->id);

		echo json_encode(array('success' => $r > 0));

		break;

	case 'guardarUsuario':
		
		$r = Usuario::modificar($request->datos->usuario);

		echo json_encode(array('success' => $r > 0));

		break;

	case 'traerUsuario':
		
		$usuario = Usuario::traerUno($request->datos->id);

		echo json_encode(array('usuario' => $usuario));

		break;
	
	default:
		# code...
		break;
}