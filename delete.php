<?php

 require "connection.php";

 $ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
 $PAGE = isset($_GET["PAGE"]) ? $_GET["PAGE"] : null;

 $sql_query2 = "DELETE FROM dziennik_uczniow WHERE ID = ".$ID;
 $sql_command2 = oci_parse($connection, $sql_query2);
 oci_execute($sql_command2);
 
 header("Location: http://localhost/www/index1.php?page=$PAGE");
 exit();



?>