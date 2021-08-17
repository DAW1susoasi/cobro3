<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Recibos mes</title>
<link rel="stylesheet" type="text/css" href="../estilos/hoja.css">
<script src="../scripts/recibos_mes.js"></script>
</head>
<body>
<?php
require("../includes/navbar.php");
if(!isset($_SESSION["fecha"])){
	header('Location: ../formulario_mes?d=recibos_mes');
}
?>
<form method="POST" action="">
   <div class="table-container">
    <table id="dinamico"></table>
  </div>
</form>
<?php
require("../includes/footer.php");
?>