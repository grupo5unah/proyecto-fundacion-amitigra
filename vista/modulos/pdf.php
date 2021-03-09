<?php
	$tiempo_inicial = microtime(true);
	for($i = 0;$i < 100000000; $i++) {
		//
	}
	$tiempo_final = microtime(true);
	$tiempo = $tiempo_final - $tiempo_inicial;
	
	echo "El tiempo de ejecución del archivo ha sido de " . $tiempo . " segundos";
?>