<?php
require_once __DIR__.'/clases/autoload.php';

use AlejoASotelo\Local;
use AlejoASotelo\Imagen;
use AlejoASotelo\LocalHasImagen;
use AlejoASotelo\PropiedadHasImagen;

if ( !empty( $_FILES ) ) {

	foreach($_FILES as $module_id => $file) {

		$parts = explode('_', $module_id);
		$module = $parts[0];
		$id = $parts[1];

		$tempPath = $file[ 'tmp_name' ];

		$base_path = '..' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $id;

		if (!file_exists($base_path)) {
			mkdir($base_path, 0755, true);
		}

		$uploadPath = $base_path . DIRECTORY_SEPARATOR . md5(uniqid() . $file['name']).substr($file['name'], -4);

		move_uploaded_file( $tempPath, $uploadPath );

		// Normalizo el path.
		$path = str_replace('..' . DIRECTORY_SEPARATOR, '', $uploadPath);
		$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);

		$imagen = new Imagen();
		$imagen->imagen = $path;
		$id_imagen = Imagen::insertar($imagen);

		if ($module == 'locales') {
			$local_has_imagen = new LocalHasImagen();
			$local_has_imagen->id_local = $id;
			$local_has_imagen->id_imagen = $id_imagen;
			$id_local_has_imagen = LocalHasImagen::insertar($local_has_imagen);
		} elseif ($module == 'propiedades') {
			$propiedad_has_imagen = new PropiedadHasImagen();
			$propiedad_has_imagen->id_propiedad = $id;
			$propiedad_has_imagen->id_imagen = $id_imagen;
			$id_propiedad_has_imagen = PropiedadHasImagen::insertar($propiedad_has_imagen);
		}

		$answer = array('success' => 1, 'msg' => 'Transferencia completada.', 'image' => $path);

	}
	$json = json_encode( $answer );

	echo $json;

} else {

	echo json_encode(array('success' => 0, 'msg' => 'Mo hay imagenes.'));

}

?>