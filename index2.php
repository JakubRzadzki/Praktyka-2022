<?php

require "connection.php";

$ID = isset($_GET["ID"]) ? $_GET["ID"] : null;
$PAGE = isset($_GET["PAGE"]) ? $_GET["PAGE"] : null;
$DZIENNIK = "SELECT imie,nazwisko,ocena_polski,ocena_mat,ocena_ang,ocena_inf,ocena_fizyka FROM DZIENNIK_UCZNIOW WHERE ID ='$ID'";
$DZIENNIK_RESULT = oci_parse($connection,$DZIENNIK);
oci_execute($DZIENNIK_RESULT);
$dane_ucznia = oci_fetch_assoc($DZIENNIK_RESULT);
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <title>DODAJ LUB ZMIEŃ DANE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
function myFunction() {
  var element = document.body;
  element.classList.toggle("dark-mode");
}
  </script>
</head>
<body>
<label class="switch">
  <input onclick="myFunction()"type="checkbox" checked id="checkbox">
  <span class="slider round"></span>
  
</label>

<div class="container">
  <h1>Dodaj lub zmień dane w dzienniku uczniów</h1>
  <div class="col-lg-4">
  <form action="" name="form1" method="post">
    <div class="form-group">
      <label for="imie">Imię:</label>
      <input type="text" class="form-control" id="imie" placeholder="Podaj imię" name="imie"
      value = "<?php echo $dane_ucznia["IMIE"]; ?>" />
      <label for="nazwisko">Nazwisko:</label>
      <input type="text" class="form-control" id="nazwisko" placeholder="Podaj nazwisko" name="nazwisko" 
      value = "<?php echo $dane_ucznia["NAZWISKO"]; ?>" />
      <label for="ocena_polski">Ocena Polski:</label>
      <input type="number" class="form-control" id="ocena_polski" placeholder="Podaj ocenę z języka polskiego" name="ocena_polski"
      value = "<?php echo $dane_ucznia["OCENA_POLSKI"]; ?>" />
      <label for="ocena_mat">Ocena Matematyka:</label>
      <input type="number" class="form-control" id="ocena_mat" placeholder="Podaj ocenę z matematyki" name="ocena_mat"
      value = "<?php echo $dane_ucznia["OCENA_MAT"]; ?>" />
      <label for="ocena_ang">Ocena Angielski:</label>
      <input type="number" class="form-control" id="ocena_ang" placeholder="Podaj ocenę z języka angielskiego" name="ocena_ang"
      value = "<?php echo $dane_ucznia["OCENA_ANG"]; ?>" />
      <label for="ocena_inf">Ocena Informatyka:</label>
      <input type="number" class="form-control" id="ocena_inf" placeholder="Podaj ocenę z informatyki" name="ocena_inf"
      value = "<?php echo $dane_ucznia["OCENA_INF"]; ?>" />
      <label for="ocena_fizyka">Ocena Fizyka:</label>
      <input type="number" class="form-control" id="ocena_fizyka" placeholder="Podaj ocenę z fizyki" name="ocena_fizyka"
      value = "<?php echo $dane_ucznia["OCENA_FIZYKA"]; ?>" />
      	<?php
	if ($ID <> null) 
	{ 
	?>
	  <label for="IS">ID:</label>
      <input readonly type="number" class="form-control" id="ID" value="<?php echo $ID; ?>" name="ID"> 
    <?php
	}
    ?>	
    </div>
	<?php
	if ($ID == null) 
	{ 
	?>
	<button type="submit" name="Insert" class="btn btn-success">Insert</button>
	<?php
	}
	else
	{
    ?>
   <button type="submit" name="Update"  class="btn btn-primary">Update</button>
   <?php
	}
	?>
  </form>
</div>
</div>
<?php
if(isset($_POST["Insert"]))
{
       $sql_query1 = "begin  
                      
                        dziennik.dodaj_ucznia('$_POST[imie]','$_POST[nazwisko]','$_POST[ocena_polski]','$_POST[ocena_mat]','$_POST[ocena_ang]','$_POST[ocena_inf]','$_POST[ocena_fizyka]'); end;" ;
       $sql_command1 = oci_parse($connection, $sql_query1);
       oci_execute($sql_command1);
}
else if (isset($_POST["Update"]))
{  
   $sql_query2 = "begin UPDATE DZIENNIK_UCZNIOW  
   SET IMIE = '$_POST[imie]',
    NAZWISKO = '$_POST[nazwisko]',
     ocena_polski = '$_POST[ocena_polski]',
      ocena_mat = '$_POST[ocena_mat]',
       ocena_ang = '$_POST[ocena_ang]',
        ocena_inf = '$_POST[ocena_inf]',
         ocena_fizyka = '$_POST[ocena_fizyka]'
   
   
   
   where ID = ('$ID');


   
   dziennik.aktualizuj('$ID');
   
   
   end;";
   $sql_command2 = oci_parse($connection, $sql_query2);
   oci_execute($sql_command2);
   
    header("Location: http://localhost/www/index1.php?page=$PAGE");
    exit();

}
?>
</body>
</html>