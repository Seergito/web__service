<?php 
// En todos lo ficheros PHP, es importante NO poner espacios ni líneas en blanco antes de <?php. Generaría un error al usar la función header.(las cabeceras HTTP deben enviarse al navegador/cliente antes de cualquier contenido).
/* Nota: Para probar el WebService se puede utilizar la extensión del navegador Chrome: Advanced REST client o POSTMAN
	 // Constantes para mensajes json. Se sigue el formato: https://github.com/omniti-labs/jsend
	 // Ejemplos:
	{
		status : "success",
		data : {
			"post" : { "id" : 1, "title" : "A blog post", "body" : "Some useful content" }
		 }
	}

	{
		"status" : "fail",
		"data" : { "title" : "A title is required" }
	}

	{
		"status" : "error",
		"message" : "Unable to communicate with database"
	}

	Nota 1: Se genera la salida JSON usando la función json_encode: http://php.net/manual/es/function.json-encode.php
	Nota 2: Se genera la salida JSON usando la función json_decode: http://php.net/manual/es/function.json-decode.php
*/

define('STATUS','status');  // El valor de 'status' puede ser: error, fail (fallo) o SUCCESS (éxito) 
define('FAIL','fail'); // No se ha podido satisfacer la petición, mensaje en DATA.
define('SUCCESS','success'); // Todo OK
		define('DATA','data'); // Se envían datos de respuesta con FAIL Y SUCCESS.
				define('SINDATOS',null);
define('ERROR','error'); // Error grave del servidor al intentar procesar la petición.
		   define('MESSAGE','message'); // Mensaje en caso de ERROR.
		   define('CODE','code'); // Código de error HTTP (opcional).
					define('ERROR_EN_SINTAXIS_PETICION',400); // Código de ejemplo

 /**** Functiones de error uso habitual ****/
 function die_por_fallo_en_sintaxis_peticion() { // Error en los parámetros.
	  header("Content-type: application/json");
	  $respuesta[STATUS]=FAIL;									// url                 // JSON
	  $respuesta[DATA]='Sintaxis peticion errónea: ' . $_SERVER['QUERY_STRING'] . file_get_contents('php://input'); 
	//  http_response_code(ERROR_EN_SINTAXIS_PETICION);
	  die (json_encode($respuesta));
 }
 
 function die_por_fallo_en_consulta($consultaSQL,$conexionMySQL){
	  header("Content-type: application/json");
	  $respuesta[STATUS]=FAIL;
	  $respuesta[DATA]='SQL: ' . $consultaSQL . ' Causa: ' . mysqli_error($conexionMySQL);
	  die (json_encode($respuesta));
 }
 
 /** funciones de transformación de tipos de datos MySQL a formato JSON **/
 
 function intaboolean($x){
	 if ($x) return true;
	 else return false;
 }
 
 function fechaHoraJSON($fechaMySQL){
	 $dt = new DateTime($fechaMySQL);
	 $dt->setTimezone(new DateTimeZone('UTC'));

	 return $dt->format('Y-m-d\TH:i:s\Z');
 } 
 
 function ajustaColumnasFormatoJSON($resultado_consulta,&$fila) {
	  $fila = array_change_key_case($fila, CASE_LOWER); // Transformamos a minúsculas los índices/nombres de columnas
	  
	  $i=0;
	  foreach($fila as $columna => $dato) { // ajustamos formato valores a JSON	 
            $tipo = mysqli_fetch_field_direct($resultado_consulta, $i)->type;
			if ($tipo==12 || $tipo==10 || $tipo==7)	$fila[$columna]=fechaHoraJSON($dato); // date, datetime, timestamp
			if ($tipo==1)  							$fila[$columna]=intaboolean($dato); // boolean
		   $i++;
	  }
 }

 /**** Conexión con el servidor MySQL ****/

 $servidor="localhost"; // Ordenador donde reside el servidor MySQL.
 $usuario="root"; // Usuario de MySQL
 $clave="root"; // Contraseña del usuario MySQL
 $base_de_datos="empresa"; // Base de datos del $servidor al que queremos conectarnos

 $conexion=@mysqli_connect ($servidor, $usuario, $clave, $base_de_datos); //@ para evitar que se emita el error.
 if (!$conexion)  {
	  header("Content-type: application/json");  // Le indicamos al cliente web que el contenido enviado está en formtato JSON.(Esto asegura una correcta interpretación del contenido).
	  $respuesta[STATUS]=ERROR;
	  $causa_error=@mysqli_connect_error();
	  $respuesta[MESSAGE]='Error de conexión con servidor MySQL, '. utf8_encode($causa_error);
	  die (json_encode($respuesta));
 }
 else {
	 mysqli_set_charset($conexion,"utf8"); // Le indicamos a MySQL codificación a utilizar en el intercambio de datos: UTF8
 }



?>