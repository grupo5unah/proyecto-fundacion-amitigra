<?php

  session_destroy();
  $_SESSION['usuario']= null;
  $_SESSION['id'] = null;
  session_unset();
  sleep(2);
  echo '<script>
  window.location = "vista/modulos/login.php";
  </script>';
  //header('Location:');

