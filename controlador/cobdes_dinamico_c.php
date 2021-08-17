<?php
if(isset($_POST['function'])){
    require("../modelo/modelo.php");
    session_start();
	$_POST['function']();
}

function getRecibos(){
    $num_filas = listarPendiente($_SESSION["usuario"]);
    $pagina = $_POST["pagina"];
    require("../includes/paginacion.php");
    $total_introducido = saldoPendiente($_SESSION["usuario"]) ? saldoPendiente($_SESSION["usuario"]) : 0;
?>
  <tr>
	<th WIDTH="148">Página</th>
	<th WIDTH="150">Importe</th>
	<th WIDTH="150">Id</th>
	<th WIDTH="100">Fecha</th>
	<th WIDTH="350">Observaciones</th>
  </tr>
  <tr>
    <td>

<?php
require("../includes/botones_paginacion.php");
?>

	</td>
    <td><?php echo number_format($total_introducido, 2) . " €"; ?></td>
    <td><?php echo $num_filas . " recibos"; ?></td>
	<td></td>
	<td></td>
  </tr>
<?php

foreach(recibosPendientes($_SESSION["usuario"], $empezar_desde, $tamao_pagina) as $r):
?>
  <tr>
   <td>
        <input type='button' class="descargar" value='Descargar'/>
        <input type='button' class="cobrar" value='Cobrar'/>
   </td>
   <td><?php echo $r->importe; ?></td>
   <td><?php echo $r->id_recibo; ?></td>
   <td><?php echo $r->fecha_valor; ?></td>
   <td><?php echo $r->observaciones; ?></td>
  </tr>  
<?php
endforeach;
}

function cobrarReciboo(){
    if(existeRecibo($_POST['id'])){
        cobrarRecibo($_POST["id"], $_SESSION["semana"]);
    }
}

function descargarReciboo(){
    if(existeRecibo($_POST['id'])){
        descargarRecibo($_POST["id"], $_SESSION["semana"]);
    }
}