<?php

  $connection = oci_connect('scott', 'tiger', 'dev');
  if (!$connection) 
  {
     $error = oci_error();
     trigger_error(htmlentities($error['message'], ENT_QUOTES), E_USER_ERROR); 
  }
  
?>