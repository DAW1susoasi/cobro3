<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Recibos no cobrados en mes</title>
<link rel="stylesheet" type="text/css" href="../estilos/hoja.css">
<script src="../scripts/quedaron_pendientes_mes.js"></script>
</head>
<body>
<?php
require("../includes/navbar.php");
if(!isset($_SESSION["fecha"])){
	header('Location: ../formulario_mes?d=quedaron_pendientes_mes');	
}  
?>
<div class="table-container">
  <table id="dinamico"></table>
</div>
<?php
require("../includes/footer.php");
?>