<?php

    include "../modelo/conexionbd.php";

    $ver = ['MOSTRAR_SOLICITUDES'];

    $paraSolicitudes = "SELECT valor FROM tbl_parametros WHERE parametro = '$ver[0]';";
    $resultadoParam = mysqli_query($conn, $paraSolicitudes);
    $mostrar = mysqli_fetch_assoc($resultadoParam);

    $modo = "DESC";

    include "../modelo/conexionbd.php";
    $solicitudes = "SELECT id_solicitud ,tbl_clientes.nombre_completo AS cliente, tbl_estatus_solicitud.estatus AS estado FROM tbl_solicitudes
                    INNER JOIN tbl_clientes
                    ON tbl_solicitudes.cliente_id = tbl_clientes.id_cliente
                    INNER JOIN tbl_estatus_solicitud
                    ON tbl_solicitudes.estatus_solicitud = tbl_estatus_solicitud.id_estatus_solicitud
                    ORDER BY cliente_id $modo limit $mostrar[valor];";
    $resultadoSoli = mysqli_query($conn, $solicitudes);

    echo '<table class="display table table-hover table-condensed text-center">
    <thead>
    <tr class="active">
    <th>Nombre cliente</th>
    <th>Estado</th>
    </tr>
    </thead>';
    while($consulta = mysqli_fetch_assoc($resultadoSoli)):

    echo '<tbody>
            <tr>
            <td>'.$consulta['cliente'].'</td>
            <td>'.$consulta['estado'].'</td>
            </tr>
            </tbody>';
    endwhile;
echo '</table>';