<?php 
require("conexion.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // INSERT
	$texto_json = file_get_contents('php://input'); // Recibimos texto JSON.
	
	if (strlen($texto_json)==0) {
		die_por_fallo_en_sintaxis_peticion();
	}
	
	$datos_recibidos = json_decode($texto_json); // Convertimos en objetos
	
	// Datos obligatorios
	if (!isset($datos_recibidos->num_departamento) || $datos_recibidos->num_departamento==null || !isset($datos_recibidos->nombre) || $datos_recibidos->nombre==null) {
			die_por_fallo_en_sintaxis_peticion();
	}
	
	// Datos opcionales y valores por defecto.
	$value_localidad = isset($datos_recibidos->localidad) ? "'$datos_recibidos->localidad'" : "NULL";
	
	$consulta_insert = "INSERT INTO `departamentos` (`NUM_DEPARTAMENTO`, `NOMBRE`, `LOCALIDAD`) 
				VALUES ('$datos_recibidos->num_departamento', '$datos_recibidos->nombre', $value_localidad);";
	 

	$resultado_consulta = mysqli_query($conexion,$consulta_insert);
	 
	if (!$resultado_consulta) {
		 die_por_fallo_en_consulta($consulta_insert,$conexion);
	}
	
    // TODO HA IDO BIEN
	$respuesta[STATUS]=SUCCESS;
	$id_generado = mysqli_insert_id($conexion); // Para el caso de columnas AUTO_INCREMENT
	if ($id_generado>0) {
		$respuesta[DATA]=array("autoincrement" => $id_generado);
	}
	else {
		$respuesta[DATA]=array("num_filas" => mysqli_affected_rows($conexion)); 
	}
	header("Content-type: application/json");
	echo json_encode($respuesta);
	
}
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT'){  // UPDATE
	$texto_json = file_get_contents('php://input'); // Recibimos texto JSON.
	
	if (strlen($texto_json)==0) {
		die_por_fallo_en_sintaxis_peticion();
	}
	
	$datos_recibidos = json_decode($texto_json); // Convertimos en objetos
	
	if (isset($datos_recibidos->num_departamento) &&  $datos_recibidos->num_departamento!=null && isset($datos_recibidos->nombre) &&  $datos_recibidos->nombre!=null && isset($datos_recibidos->localidad) && $datos_recibidos->localidad!=null) {
		$consulta_update ="UPDATE `departamentos` SET `NOMBRE` = '$datos_recibidos->nombre', `LOCALIDAD` = '$datos_recibidos->localidad' WHERE `NUM_DEPARTAMENTO` = '$datos_recibidos->num_departamento'";
	}
	else {
		die_por_fallo_en_sintaxis_peticion();
	}
	
	$resultado_consulta = mysqli_query($conexion,$consulta_update);
	 
	if (!$resultado_consulta) {
		 die_por_fallo_en_consulta($consulta_update,$conexion);
	}
	
    // TODO HA IDO BIEN
	$respuesta[STATUS]=SUCCESS;
	$respuesta[DATA]=array("num_filas" => mysqli_affected_rows($conexion)); 

	header("Content-type: application/json");
	echo json_encode($respuesta);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE'){  // DELETE
	$texto_json = file_get_contents('php://input'); // Recibimos texto JSON.
	
	if (strlen($texto_json)==0) {
		die_por_fallo_en_sintaxis_peticion();
	}
	
	$datos_recibidos = json_decode($texto_json); // Convertimos en objetos
	
	if (isset($datos_recibidos->num_departamento) &&  $datos_recibidos->num_departamento!=null ) {
		$consulta_delete ="DELETE FROM `departamentos` WHERE `NUM_DEPARTAMENTO` = '$datos_recibidos->num_departamento'";
	}
	else {
		die_por_fallo_en_sintaxis_peticion();
	}
	
	$resultado_consulta = mysqli_query($conexion,$consulta_delete);
	 
	if (!$resultado_consulta) {
		 die_por_fallo_en_consulta($consulta_delete,$conexion);
	}
	
    // TODO HA IDO BIEN
	$respuesta[STATUS]=SUCCESS;
	$respuesta[DATA]= array("num_filas" => mysqli_affected_rows($conexion)); 

	header("Content-type: application/json");
	echo json_encode($respuesta);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){ // SELECT
	extract($_GET);
	if (count($_GET)==0) {
		$where=''; // Condición inicial inexistente, para devolver todos los departamentos en caso de no recibir ningún dato por GET
	}
			// Búsqueda por número de departamento. Dato enviado en el URL (método GET).
	elseif (count($_GET)==1 && isset($id) && $id!=null) {
	 $where= " WHERE NUM_DEPARTAMENTO ='$id' ";
	}
			// Búsqueda por nombre y localidad. Dato enviados en el URL.
	elseif (count($_GET)==2 && isset($nom_departamento) &&  $nom_departamento!=null && isset($nom_localidad) && $nom_localidad!=null) {
	 $where = " WHERE NOMBRE='$nom_departamento' and LOCALIDAD='$nom_localidad'";
	}
	else {
		die_por_fallo_en_sintaxis_peticion();
	}

	$consulta = "SELECT * FROM `departamentos` $where order by NOMBRE"; 



	 $resultado_consulta = mysqli_query($conexion,$consulta);
	 

	 if (!$resultado_consulta) {
		 die_por_fallo_en_consulta($consulta,$conexion);
	 }
	 
	 $respuesta[STATUS]=SUCCESS;
	 if (mysqli_num_rows($resultado_consulta)>0) {
		 while ($fila = mysqli_fetch_array($resultado_consulta,MYSQLI_ASSOC)){
			 ajustaColumnasFormatoJSON($resultado_consulta,$fila);
			 $datos[] = $fila;
		 }
		 $respuesta[DATA]=$datos; 
	 }
	 else {
		 $respuesta[DATA]=SINDATOS; 
	 }
	 
	  header("Content-type: application/json");
	  echo json_encode($respuesta);
}

?>
