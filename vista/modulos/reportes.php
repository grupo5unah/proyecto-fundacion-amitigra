<?php
include_once("./modelo/conexion.php");
$id_objeto = 4;
$rol_id = 2;

$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,id_rol,id_objeto FROM tbl_permisos
WHERE id_rol = '$rol_id' AND id_objeto = '$id_objeto'");
$columna = $stmt->fetch_assoc();
//$stmt->bind_result($insercion,$eliminacion,$actualizacion,$consulta,$objeto, $rol);
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content contenedor-reporte">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> Reportes </h3>

            </div>
            <div class="box-body  cja ">
                <!--LLamar al formulario aqui-->
                <div class="row caja-formulario">
                    <h4 class="text-center">¿Qué reporte quieres realizar?</h4>
                    <form id="formReporte" name="formulario" method="POST" >
                        <div class="col-sm-3 cja-selecion">
                            <label for=" " class="">Selecciona el reporte que quieras generar</label>
                            <select name="" id="tipo-reporte" class="col">
                                <option value="0">Elija un reporte</option>
                                <option value="1">Reporte de Inventario</option>
                                <option value="2">Reporte de Ventas de Boletos</option>
                                <option value="3">Reporte de Reservaciones</option>
                                <option value="4">Reporte de visitantes</option>
                            </select>
                        </div>

                        <!-- Campo de entrada de semana -->
                        <div class="col-sm-3 cja-selecion ">
                            <label for="">Selecciona la fecha inicio deseada:</label>
                            <input type="date" id="fecha-reporte-inicio"class="form-control pull-rigth  fecha-repor" name="semana" value="3" min="2018-W10" max="2018-W20" step="2" />
                        </div>
                        <div class="col-sm-3 cja-selecion">
                            <label for="">Selecciona la fecha final deseada:</label>
                            <input type="date" id="fecha-reporte-final" class="form-control pull-rigth  fecha-repor" name="semana" value="3" min="2018-W10" max="2018-W20" step="2" />
                        </div>
                        <div class="col-ms col-xl-6">
                          <button type=" submit " class="btn secundary" value="">
                            Ver Reporte
                        </button>
                        </div>


                    </form>
                    <div class="col-ms-3 col xl-4 btones">
                        
                        <button type=" submit " class="btn secundary" value="">
                            Generar Reporte
                        </button>
                        <button type=" Reset " class="btn secundary" value="">
                            Cancelar                        </button>
                    </div>

                </div>
                <label for="">Detalle:</label>
                <div>
                    <textarea name="" id="" cols="100" rows="5"></textarea>
                </div>
            </div>
            <!-- /.box-body -->


        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>