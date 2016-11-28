<?php
require_once __DIR__.'/clases/autoload.php';

use AlejoASotelo\Usuario;
use AlejoASotelo\Empleado;
use AlejoASotelo\Encargado;
use AlejoASotelo\Local;
use AlejoASotelo\LocalHasImagen;
use AlejoASotelo\Oferta;
use AlejoASotelo\Imagen;
use AlejoASotelo\Propiedad;

$request_body = file_get_contents('php://input');
$request = json_decode($request_body);

switch ($request->datos->task) {
	
	case 'listar':

		$rows = array();

		switch ($request->datos->endpoint) {

			case 'usuarios':
				$rows = Usuario::traerTodos();
				break;

			case 'encargados':
				$rows = Encargado::traerTodos();
				break;

			case 'empleados':
				$rows = Empleado::traerTodos();
				break;

			case 'locales':
				$rows = Local::traerTodos();
				break;

			case 'ofertas':
				$rows = Oferta::traerTodos();
				break;

			case 'propiedades':
				$rows = Propiedad::traerTodos();
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

			case 'encargados':
				$row = Encargado::traerPorId($request->datos->id);

				// Oculto el hash del password.
				$row->password = '';
				break;

			case 'empleados':
				$row = Empleado::traerPorId($request->datos->id);

				// Oculto el hash del password.
				$row->password = '';
				break;

			case 'locales':
				$row = new Local($request->datos->id);
				break;

			case 'ofertas':
				$row = new Oferta($request->datos->id);
				break;

			case 'propiedades':
				$row = Propiedad::traerPorId($request->datos->id);
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
				
			case 'ofertas':
				$id = Oferta::insertar($request->datos->object);
				break;
				
			case 'propiedades':
				$id = Propiedad::insertar($request->datos->object);
				break;
			
			default:
				# code...
				break;
		}

		$ret['success'] = $id > 0;

		if ($id > 0) {
			$ret['id'] = $id;
		} else {
			$ret['msg'] = 'No se pudo insertar.';
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

			case 'ofertas':
				Oferta::modificar($request->datos->object);
				$id = $request->datos->object->id_oferta;
				break;

			case 'propiedades':
				Propiedad::modificar($request->datos->object);
				$id = $request->datos->object->id_propiedad;
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

			case 'ofertas':
				$rows = Oferta::borrar($request->datos->id);
				break;

			case 'propiedades':
				$rows = Propiedad::borrar($request->datos->id);
				break;
			
			default:
				# code...
				break;
		}		

		echo json_encode(array('success' => true));
		break;
	
	default:
		# code...
		break;
}