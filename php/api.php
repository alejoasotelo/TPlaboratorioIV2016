<?php
require_once __DIR__.'/clases/autoload.php';

use AlejoASotelo\Usuario;
use AlejoASotelo\Local;
use AlejoASotelo\Imagen;
use AlejoASotelo\LocalHasImagen;

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
				$row = new Local($request->datos->id);
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode($row);

		break;

	case 'insert':

		$id = 0;
		$ret = array('success' => 0, 'msg' => '');

		switch ($request->datos->endpoint) {
			case 'usuarios':
				$id = Usuario::insertar($request->datos->object);
				break;
				
			case 'locales':
				$id = Local::insertar($request->datos->object);
				break;
			
			default:
				# code...
				break;
		}

		$ret['success'] = $id > 0;

		if ($id > 0) {
			$ret['id'] = $id;
		} else {
			$ret['msg'] = 'No se pudo actualizar.';
		}

		echo json_encode($ret);

		break;

	case 'update':

		$id = 0;
		$ret = array('success' => 0, 'msg' => '');

		switch ($request->datos->endpoint) {
			case 'usuarios':
				Usuario::modificar($request->datos->object);
				$id = $request->datos->object->id_usuario;

				break;
			case 'locales':
				Local::modificar($request->datos->object);
				$id = $request->datos->object->id_local;
				break;
			
			default:
				# code...
				break;
		}

		$ret['success'] = $id > 0;

		if ($id > 0) {
			$ret['id'] = $id;
		} else {
			$ret['msg'] = 'No se pudo actualizar.';
		}

		echo json_encode($ret);

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

			case 'imagenes':
				Imagen::borrar($request->datos->id);
				LocalHasImagen::borrarPorIdImagen($request->datos->id);
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