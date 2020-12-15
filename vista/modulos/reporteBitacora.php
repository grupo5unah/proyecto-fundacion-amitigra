<?php
include_once("./modelo/conexion.php");
$id_objeto = 3;
//$rol = $_SESSION['mi_rol'];
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON
                        tbl_usuarios.rol_id = tbl_roles.id_rol 
                        WHERE tbl_roles.rol = ?");
$stmt->bind_Param("s",$rol_id);
$stmt->execute();
$stmt->bind_Result($id_rol);

if($stmt->affected_rows){

  $existe = $stmt->fetch();
while($stmt->fetch()){
  $mi_rol = $id_rol;
}

if($existe){





$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,id_rol,id_objeto FROM tbl_permisos
WHERE id_rol = '$mi_rol' AND id_objeto = '$id_objeto'");
$columna = $stmt->fetch_assoc();

?>
<main>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="box">
        
        <div class="box-body">
          <!--LLamar al formulario aqui-->
          <form method="POST">
           <!--AQUI CARGAMOS EL RESTO-->

            <h1>Hola mundo, reporte bitacora</h1>
            <input type="text" value="<?php echo $mi_rol;?>">
<?php }}?>
            <br>
            <?php if ($columna["permiso_insercion"] == 1) {?><button name="editar"> Editar</button><?php }?>
            <?php if ($columna["permiso_eliminacion"] == 1) {?><button name="eliminar"> Eliminar</button><?php }?>
            <?php if($columna["permiso_actualizacion"] == 1) {?> <button>Actualizacion </button><?php }?>
            <?php if($columna["permiso_consulta"] == 1) {?> <button>Consulta</button><?php }?>
            <button>gen pdf</button>
            <iframe type="application/pdf" src="http://docs.google.com/gview?url=
http://www.educoas.org/portal/bdigital/contenido/valzacchi/ValzacchiCapitulo-2New.pdf
&amp;embedded=true" style="width:100%; height:700px;" frameborder="0" ></iframe>

           <!--AQUI FINALIZA LA CARGA-->         
          </form>
          <!--Fin llamado formulario-->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  </main>