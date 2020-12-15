<?php

  session_destroy();
  $_SESSION['usuario']= null;
  $_SESSION['id'] = null;
  session_unset();
  echo '<script>
  window.location = "login.php";
  </script>';