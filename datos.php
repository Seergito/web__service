<?php 
 // Ejemplo de transformación a formato JSON de booleanos y Fechas
require("conexion.php");

 $consulta = "SELECT * FROM `datos`"; 

 $resultado_consulta = mysqli_query($conexion,$consulta);


 if (!$resultado_consulta) {
	 die_por_fallo_en_consulta($consulta,$conexion);
 }
 
 $respuesta[STATUS]=SUCCESS;
 if (mysqli_num_rows($resultado_consulta)==1) {
	  $fila = mysqli_fetch_array($resultado_consulta,MYSQLI_ASSOC);
	  ajustaColumnasFormatoJSON($resultado_consulta,$fila);
	  $respuesta[DATA]=$fila;
	  json_encode($respuesta); 
 }
 else {
	 $respuesta[DATA]=SINDATOS; 
 }
  header("Content-type: application/json");
  echo json_encode($respuesta);
?>