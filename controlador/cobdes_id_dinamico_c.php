<?php
if(isset($_POST['function'])){
    require("../modelo/modelo.php");
    session_start();
	$_POST['function']();
}

function getRecibos(){
?>
	   <tr>
		<td WIDTH="147"></td>
		<th WIDTH="150">Id</th>
		<th WIDTH="150">Importe</th>
		<th WIDTH="100">Fecha</th>
		<th WIDTH="350">Observaciones</th>
	   </tr>
	   <tr>
		 <td></td>
		 <td><input id="id" name="id" type="text" pattern="[0-9]{1,10}" required></td>
		 <td></td>
		 <td></td>
		 <td></td>
	   </tr>     
<?php  
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

function submit(){
?>
	   <tr>
		<td WIDTH="147"></td>
		<th WIDTH="150">Id</th>
		<th WIDTH="150">Importe</th>
		<th WIDTH="100">Fecha</th>
		<th WIDTH="350">Observaciones</th>
	   </tr>
	   <tr>
		 <td></td>
		 <td><input id="id" name="id" type="text" pattern="[0-9]{1,10}" required></td>
		 <td></td>
		 <td></td>
		 <td></td>
	   </tr>
<?php
    if(isset($_POST["id"]) && $r = recibosPendientes_id($_SESSION["usuario"], $_POST["id"])){
?>
       <tr>
          <td>
            <input type='button' id="descargar" value='Descargar'/>
            <input type='button' id="cobrar" value='Cobrar'/>
           </td>
         <td><?php echo $r->id_recibo; ?></td>
         <td><?php echo $r->importe; ?></td>
         <td><?php echo $r->fecha_valor; ?></td>
         <td><?php echo $r->observaciones; ?></td>
       </tr>
<?php 
    }
}