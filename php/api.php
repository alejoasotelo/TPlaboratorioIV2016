<?php
require_once __DIR__.'/clases/autoload.php';

use AlejoASotelo\Usuario;
use AlejoASotelo\Local;

$request_body = file_get_contents('php://input');
$request = json_decode($request_body);

switch ($request->datos->task) {
	
	case 'listar':

		$rows = array();

		switch ($request->datos->endpoint) {
			case 'usuarios':
				$rows = Usuario::traerTodos();
				break;
			case 'locales':
				$rows = Local::traerTodos();
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode($rows);

		break;

	case 'get':

		$row = array();

		switch ($request->datos->endpoint) {
			case 'usuarios':
				$row = Usuario::traerPorId($request->datos->id);

				// Oculto el hash del password.
				$row->password = '';
				break;
			case 'locales':
				$row = Local::traerPorId($request->datos->id);
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode($row);

		break;

	case 'insert':

		$success = false;
		$msg = '';

		switch ($request->datos->endpoint) {
			case 'usuarios':
				$id = Usuario::insertar($request->datos->object);

				$success = $id > 0;
				$msg = $success ? '' : 'No se pudo actualizar.';

				break;
			case 'locales':
				$id = Local::insertar($request->datos->object);

				$success = $id > 0;
				$msg = $success ? '' : 'No se pudo actualizar.';
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode(array('success' => $success != false, 'msg' => $msg));

		break;

	case 'update':

		$success = false;
		$msg = '';

		switch ($request->datos->endpoint) {
			case 'usuarios':
				$row = Usuario::modificar($request->datos->object);

				$success = $row != false;
				$msg = $success ? '' : 'No se pudo actualizar.';

				break;
			case 'locales':
				$row = Local::modificar($request->datos->object);

				$success = $row != false;
				$msg = $success ? '' : 'No se pudo actualizar.';
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode(array('success' => $success != false, 'msg' => $msg));

		break;

	case 'delete':

		$rows = array();

		switch ($request->datos->endpoint) {
			case 'usuarios':
				$rows = Usuario::borrar($request->datos->id);
				break;
			case 'locales':
				$rows = Local::borrar($request->datos->id);
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode(array('success' => true));
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