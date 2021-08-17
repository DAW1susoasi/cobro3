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
	    <th WIDTH="150">Página</th>
        <th>Importe</th>
        <th>Id</th>
        <th WIDTH="70">Fecha</th>
        <th>Observaciones</th>
	 </tr>
	 <tr>
       <td style="white-space: nowrap">

<?php
require("../includes/botones_paginacion.php");
?>

	   </td>
	   <td><input type="number" id="importe" name="importe" min="10" style="width:100px" readonly/></td>
	   <td><input type="text" id="id" name="id" pattern="[0-9]{1,10}" style="width:125px" readonly/></td>
	   <td id="fecha"></td>
	   <td><input id="observaciones" name='observaciones' type='text' style="width:200px"/></td>
	   <input class="oculto" type='submit' name='enviar' value='Actualizar'/>
	 </tr> 
	 <tr>
	   <td></td>
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
            <input type='button' class="editar" value='Editar'/>
        </td>
        <td><?php echo $r->importe; ?></td>
        <td><?php echo $r->id_recibo; ?></td>
        <td><?php echo $r->fecha_valor; ?></td>
        <td><?php echo $r->observaciones; ?></td>
    </tr>    
<?php
endforeach;
}

function submit(){
    if(isset($_POST["importe"]) && isset($_POST["id"])){
        $id = trim(htmlentities($_POST["id"]));
        $importe = trim(htmlentities($_POST["importe"]));
        $observaciones = isset($_POST["observaciones"]) ? trim(htmlentities($_POST["observaciones"])) : NULL;
        if(ctype_digit($importe) && ctype_digit($id)){
            if($importe >= 10 && $importe <= 99999 && $id > 0 && $id <= 9999999999){
                if(
				   ($id > 0 && $id <= 9999999999)
				    && ($importe > 0 && $importe <= 99999)){
                    if(existeRecibo($id)){
                      actualizarTodo($importe, $id, $observaciones, 0, 0);
                    }
                }
            }
        }
    }
}