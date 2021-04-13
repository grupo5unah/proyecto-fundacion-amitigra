<div class="content-wrapper">

    <section class="content-header">
      <h1>Perfil <small> ajustes</small></h1>      
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><i class="fa fa-user"></i> Perfil de usuario</li>
      </ol>
    </section>

    <section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-body box-profile">

						<div class="form-group">
							<div class="alert alert-light" role="alert">
								<h4><i class="fa fa-database"> Importante:</i></h4>
								<strong>Por que una copia de seguridad de la Base de datos?</strong>
								<br>
								Es muy importante el poder contar con una copia de nuestra base de datos, ya que si en algun momento
								presentamos problemas podes reestablecer la informacion.
							</div>
						</div>
					</div>
				</div>
      		</div>
		</div>
        
        <!--INICIO DE LA TABLA-->
        <div class="col-md-8">
          	<div class="nav-tabs-custom2">
				<ul class="nav nav-tabs">
				<li><a href="#settings" data-toggle="tab">Informacion</a></li>
				<li><a href="#settings2" data-toggle="tab">Seguridad</a></li>
				</ul>
			
				<div class="tab-content">
					<div class="active tab-pane" id="settings">
						<form method="POST" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">

							<div class="form-group">
								<div class="alert alert-light" role="alert">
								<h4><i class="fa fa-user"> Informacion general</i></h4>
								Hola <strong><?php echo $_SESSION['usuario'];?></strong>
								aquí puedes configurar tu información personal, tu <strong>nombre de usuario</strong> no se puede modificar.
								</div>
							</div>

							<div class="form-group">
								<label for="inputName" class="col-sm-3 control-label">Nombre completo:</label>

								<div class="input-group col-sm-8">
								<input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo ucwords(strtolower($_SESSION['nombre_completo']));?>" placeholder="Nombre">
								</div>
							</div>

							<div class="form-group">
								<label for="inputName" class="col-sm-3 control-label">Nombre de usuario:</label>

								<div class="input-group col-sm-8">
								<input type="text" readonly name="usuario" class="form-control" id="usuario" value="<?php echo ucwords(strtolower($usuario));?>" placeholder="Nombre de usuario" disabled>
								<p id="notificacion"></p>
								</div>
							</div>

							<div class="form-group">
								<label for="inputName" class="col-sm-3 control-label">Tel./Celular:</label>

								<div class="input-group col-sm-8">
								<input type="tel" name="telefono" class="form-control" id="telefono" value="<?php echo ucwords(strtolower($_SESSION['telefono']));?>" placeholder="Numero telefono fijo o celular">
								</div>
							</div>

							<div class="form-group">
								<label for="inputEmail" class="col-sm-3 control-label">Correo Electrónico:</label>

								<div class="input-group col-sm-8">
								<input type="email" name="correo" class="form-control" id="correo" value="<?php echo $_SESSION['correo'];?>" placeholder="Correo electronico">
								</div>
							</div>
			
							<div class="text-center form-group">
								<div class="col-sm-offset-2 col-sm-8">
								<input type="hidden" id="tipo" name="cambio_info" value="cambio_info">
								<?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
								<button type="button" id="editar" class="btn btn-success actualizar editar" data-toggle="modal" data-target="" data-idusuario="<?= $_SESSION['id'];?>" data-nombreusuario="<?= $_SESSION['usuario'] ?>">
								Guardar cambios</button><?php }?>
								</div>
							</div>
						</form>
					</div>
		
					<div class="tab-pane" id="settings2">
						<form method="POST" id="cambioPass" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
							
							<div class="form-group">
								<div class="input-group col-sm-8">
								<input type="hidden" class="form-control" name="usuario" value="<?php echo $usuario;?>" placeholder="Ingrese su contraseña actual">
								<span class="input-group-btn">
								</span>
								</div>
							</div>

							<div class="form-group">
								<div class="alert alert-light" role="alert">
								<h4><i class="fa fa-unlock-alt"> Cambio de contraseña</i></h4>
								<strong><?php echo $_SESSION['usuario'];?></strong>
								en este espacio puedes hacer cambio de tu contraseña haciendo click en el siguiente botón.
								</div>
							</div>
					
							<div class="text-center form-group">
								<div class="col-sm-offset-2 col-sm-8">
								<input type="hidden" name="cambios" value="act">
								<?php if ($columna['permiso_actualizacion'] == 1 OR $columna['permiso_actualizacion'] == 0) {?>
								<button type="button" id="cambioContrasena" class="btn btn-success actualizar" data-toggle="modal2" data-target="#modal-default2">
								Click aqui para cambiar la contraseña
								</button><?php }?>
								</div>
							</div>
						</form>
					</div>
				</div>
          	</div>
        </div>
        <!--FIN DE LA TABLA-->
      </div>
    </section>

    <!-- /.content -->
  </div>