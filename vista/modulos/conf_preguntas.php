<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Configuracion de preguntas</title>
	<link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="../dist/css/estilos_user.css">
</head>
<body>
	<main>
		<div class="contenedor-caja-conf">
			<H2>CONFIGURACION DE PREGUNTAS</H2>
			<form action="" class="formulario-conf" id="formulario">
				<!-- Grupo: pregunta 1 -->
				<div class="formulario__grupo" id="grupo__pregunta1">
					<label for="area1" class="formulario__label">Elija una pregunta:</label>
					<div class="formulario__grupo-input">
                        <select class="formulario__input" id="area1" name="area1" value="<php if(isset($res1)) echo $res1?>">
                         <option value="">Seleccione una pregunta</option>
                            <?php
                             include_once ('../../modelo/conexion.php');
      
                             $stmt = "SELECT * FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                        </select>  
						<input type="text" class="formulario__input" name="respuesta1" id="respuesta1" placeholder="  Ingrese su respuesta">  
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="msg_error">El nombre debe ser de 4 a 16 caracteres y solo puede contener letras mayusculas.</p>
				</div>

				<!-- Grupo: pregunta 2 -->
				<div class="formulario__grupo" id="grupo__pregunta2">
					<label for="area2" class="formulario__label">Elija una pregunta</label>
					<div class="formulario__grupo-input">
                        <select class="formulario__input" id="area2" name="area2" value="<php if(isset($res1)) echo $res1?>">
                         <option value="">Seleccione una pregunta</option>
                            <?php
                             include_once ('../../modelo/conexion.php');
      
                             $stmt = "SELECT * FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                        </select> 
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<input type="text" class="formulario__input" name="respuesta2" id="respuesta2" placeholder="  Ingrese su respuesta">
					<p class="msg_error">El apellido debe ser de 4 a 16 caracteres y solo puede contener mayusculas</p>
				</div>

				<!-- Grupo: pregunta 3 -->
				<div class="formulario__grupo" id="grupo__pregunta3">
					<label for="usuario" class="formulario__label">Elija una pregunta</label>
					<div class="formulario__grupo-input">
                        <select class="formulario__input" id="area3" name="area3" value="<php if(isset($res1)) echo $res1?>">
                         <option value="">Seleccione una pregunta</option>
                            <?php
                             include_once ('../../modelo/conexion.php');
      
                             $stmt = "SELECT * FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                        </select> 
						<input type="text" class="formulario__input" name="respuesta3" id="respuesta3" placeholder="  Ingrese su respuesta">
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="msg_error">El apellido debe ser de 4 a 16 caracteres y solo puede contener mayusculas</p>
				</div> <br>


				<div class="formulario__mensaje" id="formulario__mensaje">
					<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellenar todos los campos. </p>
				</div>
				<br> <br>
				<div class="formulario__grupo formulario__grupo-btn-enviar">
					<button type="submit" class="formulario__btn">Cancelar</button>
					<button type="submit" class="formulario__btn">Registrar</button>
		
				</div>
			</form>

		</div>
	</main>

	<script src="../dist/js/configuracion.js"></script>
	<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>