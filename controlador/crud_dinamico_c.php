<?php
if(isset($_POST['function'])){
    require("../modelo/modelo.php");
    session_start();
	$_POST['function']();
}

function getRecibos(){
    $num_filas = listar($_SESSION["usuario"]);
    $pagina = $_POST["pagina"];
    require("../includes/paginacion.php");
    $total_introducido = totalIntroducido($_SESSION["usuario"]) ? totalIntroducido($_SESSION["usuario"]) : 0;
?>
 	<tr>
		<th WIDTH="130">Página</th>
		<th>Id</th>
    	<th>Importe</th>       
	 </tr> 
     <tr>
     	<td style="white-space: nowrap">

<?php
require("../includes/botones_paginacion.php");
?>

		</td>
		<td><input id="id" name='id' type='text' pattern="[0-9]{1,10}" style="width:125px" required
				<?php
					$encontrado = FALSE;
					while(!$encontrado){ 
					  $id = rand(1, 9999999999);
					  $encontrado = !existeRecibo($id) ? TRUE : FALSE;
					}
				    echo "value='$id'";
				?>/>
		</td>
		<td><input id="importe" name='importe' type='number' pattern="[0-9]{2,5}" min="10" style="width:100px" required	value="<?php echo rand(10, 99999); ?>" /></td>
        <input class="oculto" type='submit' name='enviar' value='Insertar/Actualizar'/>
      </tr> 
      <tr>
		  <td><input type='button' id="eliminar_todos" value='Eliminar todos'/></td>
		  <td><?php echo $num_filas . " recibos"; ?></td>
		  <td><?php echo number_format($total_introducido, 2) . " €"; ?></td>
      </tr>
<?php
  foreach(busqueda($_SESSION["usuario"], $empezar_desde, $tamao_pagina) as $r):
?>            
      <tr>
          <td>
            <input type='button' class="eliminar" value='Eliminar'/>
            <input type='button' class="editar" value='Editar'/>
          </td>
          <td><?php echo $r->id_recibo; ?></td>
		  <td><?php echo $r->importe; ?></td>
      </tr>       
<?php  
  endforeach; 
}

function eliminarReciboo(){
    if(existeRecibo($_POST["id"])){
        eliminarRecibo($_POST['id']);
    }
}

function eliminarRecibosTemp(){
    eliminarTodos_recibos_temp($_SESSION["usuario"]);
}

function submit(){
    if(isset($_POST["importe"]) && isset($_POST["id"])){
        $id = trim(htmlentities($_POST["id"]));
        $importe = trim(htmlentities($_POST["importe"]));
        if(ctype_digit($importe) && ctype_digit($id)){
            if($importe >= 10 && $importe <= 99999 && $id > 0 && $id <= 9999999999){
                if(existeRecibo($id)){
                  actualizarImporte($importe, $id);
                }
                else{
                  insertar($_SESSION["usuario"], fechaUsuario($_SESSION["usuario"]), $id, $importe);
                }
            }
        }
    }
}