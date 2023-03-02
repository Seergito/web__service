<?php 
require("conexion.php");
extract($_GET);

if (count($_GET)==2 && isset($email) && $email!=null && isset($clave) && $clave!=null ) { // clave encriptada según md5
 $where=" WHERE EMAIL='$email' AND CLAVE='$clave'";
}
else {
	die_por_fallo_en_sintaxis_peticion();
}

 $consulta = "SELECT * FROM `usuarios` $where"; 

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