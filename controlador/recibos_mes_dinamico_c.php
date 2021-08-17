<?php
if(isset($_POST['function'])){
    require("../modelo/modelo.php");
    session_start();
	$_POST['function']();
}

function getRecibos(){
    $num_filas = recibos_mes($_SESSION["usuario"], $_SESSION["fecha"]);
    $pagina = $_POST["pagina"];
    require("../includes/paginacion.php");
    $total_introducido = total_recibos_mes($_SESSION["usuario"], $_SESSION["fecha"]) ? total_recibos_mes($_SESSION["usuario"], $_SESSION["fecha"]) : 0;
?>
 	<tr>
		<th WIDTH="115">Página</th>
    	<th>Importe</th>
        <th>Id</th>
        <th WIDTH="70">Fecha</th>
        <th>Sem.Cob.</th>
        <th>Sem.Des.</th>
        <th>Observaciones</th>
	 </tr> 
     <tr>
     	<td style="white-space: nowrap">
<?php
require("../includes/botones_paginacion.php");
?>

		</td>
	    <td><input id="importe" name='importe' type='number' pattern="[0-9]{2,5}" min="10" style="width:100px" required/></td>
        <td><input id="id" name="id" type="text" pattern="[0-9]{1,10}" style="width:125px" readonly required/></td>
        <td id="fecha"></td>
        <td><input id="cobrado" name="cobrado" type="text" pattern="[0-5]" style="width:72px" required/></td>
        <td><input id="descargado" name="descargado" type="text" pattern="[0-5]" style="width:72px" required/></td>
	    <td><input id="observaciones" name='observaciones' type='text' style="width:200px"/></td>
        <input class="oculto" type='submit' name='enviar' value='Actualizar'/>
	</tr> 
    <tr>
		<td></td>
		<td><?php echo number_format($total_introducido, 2) . " €"; ?></td>
    	<td><?php echo $num_filas . " recibos"; ?></td> 
		<td></td>
		<td></td>
		<td></td>
		<td></td>		
    </tr>
<?php
foreach(recibos_mes_busqueda($_SESSION["usuario"], $empezar_desde, $tamao_pagina, $_SESSION["fecha"]) as $r):
?>
    <tr>
        <td>
            <input type='button' class="eliminar" value='Eliminar'/>
            <input type='button' class="editar" value='Editar'/>
        </td>
        <td><?php echo $r->importe; ?></td>
        <td><?php echo $r->id_recibo; ?></td>
        <td><?php echo $r->fecha; ?></td>
        <td><?php echo $r->semana_cobro > 0 ? $r->semana_cobro : ''; ?></td>
        <td><?php echo $r->semana_descargo > 0 ? $r->semana_descargo : ''; ?></td>
        <td><?php echo $r->observaciones; ?></td>
    </tr>    
<?php
endforeach;
}

function eliminarReciboo(){
    if(existeRecibo($_POST["id"])){
        eliminarRecibo($_POST['id']);
    }
}

function submit(){
    if(isset($_POST["importe"]) && isset($_POST["id"]) && isset($_POST["cobrado"]) && isset($_POST["descargado"])){
        $id = trim(htmlentities($_POST["id"]));
        $importe = trim(htmlentities($_POST["importe"]));
        $cobrado = trim(htmlentities($_POST["cobrado"]));
        $descargado = trim(htmlentities($_POST["descargado"]));
        $observaciones = isset($_POST["observaciones"]) ? trim(htmlentities($_POST["observaciones"])) : NULL;
        if(ctype_digit($importe) && ctype_digit($id) && ctype_digit($cobrado) && ctype_digit($descargado)){
            if($importe >= 10 && $importe <= 99999 && $id > 0 && $id <= 9999999999){
                if(
                       ($id > 0 && $id <= 9999999999)
                    && ($importe > 0 && $importe <= 99999) 
                    && (!$cobrado || !$descargado) 
                    && ($cobrado >= 0 && $cobrado < 6)
                    && ($descargado >= 0 && $descargado < 6)){
                    if(existeRecibo($id)){
                      actualizarTodo($importe, $id, $observaciones, $cobrado, $descargado);
                    }
                }
            }
        }
    }
}
?>