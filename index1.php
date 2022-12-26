<html>   
  <head>   
    <title>DZIENNIK UCZNIÓW</title>   
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="style1.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">  
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
</head>  
<style>  
 @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500');  
body {  
  font-family: 'Montserrat', sans-serif;  
  text-align: center;  
}  
body{  
  background-color: rgb(63,72,83);  
  font-family: sans-serif;  
  color: rgb(220,220,220);  
  overflow-x: hidden;  
}  
tr:first-child { color: #FB667A; }  
td:hover {  
  color: white;  
  font-weight: bold;   
  transition-delay: 0s;  
    transition-duration: 0.4s;  
    transition-property: all;  
  transition-timing-function: line;  
}  
h1 {  
  position: relative;  
  padding: 0;  
  margin: 10;  
  font-family: "Raleway", sans-serif;  
 font-weight: 400;  
  font-size: 2.7rem	;  
  color: white;  
  -webkit-transition: all 0.4s ease 0s;  
  -o-transition: all 0.4s ease 0s;  
  transition: all 0.4s ease 0s;   
}  
.table {  
  width: 100%;  
  thead {  
    th {  
      padding: 10px 10px;  
      background: #00adee;  
      font-size: 25px;  
      text-transform: uppercase;  
      vertical-align: top;  
      color: #1D4A5A;  
      font-weight: normal;  
      text-align: left;  
    }  
  }  
  tbody {  
    tr {  
      td {  
        padding: 10px;  
        background: #f2f2f2;  
        font-size: 14px;  
      }  
    }  
  }  
}  
.add {  
  outline: none;  
  background: none;  
  border: none;  
}  
.edit {  
  outline: none;  
  background: none;  
  border: none;  
}  
.save {  
  outline: none;  
  background: none;  
  border: none;  
}  
.delete {  
  outline: none;  
  background: none;  
  border: none;  
}  
.edit {  
  padding: 5px 10px;  
  cursor: pointer;  
}  
.save {  
  padding: 5px 10px;  
  cursor: pointer;  
}  
.delete {  
  padding: 5px 10px;  
  cursor: pointer;  
}  
.add {  
  float: right;  
  background: transparent;  
  border: 1px solid  black;  
  color: black;  
  font-size: 13px;  
  padding: 0;  
  padding: 3px 5px;  
  cursor: pointer;  
  &:hover {  
    background: #ffffff;  
    color: #00adee;  
  }  
}  
.save {  
  display: none;  
  background: #32AD60;  
  color: #ffffff;  
  &:hover {  
    background: darken(#32AD60, 10%);  
  }  
}  
.edit {  
  background: #2199e8;  
  color: #ffffff;  
  &:hover {  
    background: darken(#2199e8, 10%);  
  }  
}  
.delete {  
  background: #EC5840;  
  color: #ffffff;  
   &:hover {  
    background: darken(#EC5840, 10%);  
  }  
}  
</style>    
  <body>   
    <center>  
		

    <?php
      require_once "connection.php";   
	  if(isset($_GET['page']))
	  {
		  $page = $_GET['page'];
	  }
	  else
	  {
		  $page = 1;
	  }
	  
	  $num_per_page = 20;
	  $start_from = ($page-1)*20;
	  $finish = $start_from + $num_per_page;
	  	  if (isset($_POST['srednia'])) 
    {$srednia = $_POST['srednia'];}
    else
    {

      $srednia  = "arytmetyczna";
    }
	  if (isset($_POST['od'])) 
    {$od = $_POST['od'];}
    else
    {

      $od  = 0;
    }
    if (isset($_POST['do'])) 
    {$do= $_POST['do'];}
    else
    {$do = 6;}


          $sql_query = "SELECT id, imie, nazwisko, ocena_polski, ocena_mat, ocena_ang, ocena_inf, ocena_fizyka, srednia_arytmetyczna, srednia_geometryczna, srednia_harmoniczna
	                  FROM (SELECT ROWNUM rnum, du.* 
					          FROM table (dziennik.daj_dane_uczniow('".$srednia."', ".$od.", ".$do." )) du 
							 WHERE ROWNUM <= ".$finish." 
					      ORDER BY rownum)
	                 WHERE rnum > ".$start_from. "order by decode('".$srednia."', 'arytemetyczna', srednia_arytmetyczna
																			  , 'geometryczna', srednia_geometryczna 
																			  , 'harmoniczna', srednia_harmoniczna
					                                             ) ASC";

      $sql_command = oci_parse($connection, $sql_query);
      oci_execute($sql_command);
    ?>
	</div>
      <div>   
        <h1>Dziennik Uczniów</h1> 
	</div>
	<nav> 
		<h2>Zakres wyszukiwania według średniej i jej rodzaju</h2>
		
			<form action="" method="post" name="from">
			<label for="srednia">Wybierz rodzaj średniej:</label>
  <select name="srednia" id="srednia" value="<?php echo $srednia; ?>" >
      <option id="aryt" name="aryt" >arytmetyczna</option>
      <option id="geom" name="geom" >geometryczna</option>
	  <option id="harm" name="harm" >harmoniczna</option>
			<input id="od" name="od" placeholder="OD" value="<?php echo $od; ?>"/>
			<input id="do" name="do" placeholder="DO" value="<?php echo $do ?>"/>
			<button type='submit'> Filtruj </button>
		</form>
	</nav>
         	<h2 align="right">ID Search Bar:</h2>
			
			
			
<div align="right">
<input type="number" id="myInput" onkeyup="myFunction()" placeholder="Search for ID.." title="Type in a name">
    <div class="container">  
		
		</div>
	
      <br />
</div>	  
        <table id="myTable" class="table table-bordered" method="post">   
          <thead>   
            <tr>   
              <th width=10% id='ID'>ID - W BAZIE</th>
              <th>Imię</th>   
              <th>Nazwisko</th>   
              <th>Ocena Polski</th>   
			  <th>Ocena Mat.</th> 
			  <th>Ocena Ang.</th> 
			  <th>Ocena Inf.</th> 
			  <th>Ocena Fizyka</th>
			  <th>Średnia Aryt.</th> 
			  <th>Średnia Geom.</th> 
			  <th>Średnia Harm.</th> 
			  <th width=12%>Operations</th>
            </tr>   
          </thead>   
          <tbody>   
			<?php
			  
			  while ($row = oci_fetch_assoc($sql_command)) 
			  {
				 echo "<tr>\n";

				 foreach ($row as $key => $item)
				 {
		             if ($key == "IMIE" || $key == "NAZWISKO" || $key == "OCENA_POLSKI" || $key == "OCENA_MAT" || $key == "OCENA_ANG" || $key == "OCENA_INF" || $key == "OCENA_FIZYKA")
					 {
				 	   echo "    <td class='data'> " . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td> \n";					 
					 }
					 else
					 {
					   echo "    <td> " . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td> \n";	 
					 }
				 }

				 echo " <td>
				 <button class='button save' name='save' onclick='save()'> Save </button>  
        		 <button class='button edit'> Edit </button>  
				 <button type='submit' name='Delete'  id='Delete' onclick=\"location.href='http://localhost/www/delete.php?ID=$row[ID]&PAGE=$page'\" class='delete'>Delete</button>
				 </td> </tr>\n";
			  }

			?>
          </tbody>   
        </table>
        <a href ='http://localhost/www/index2.php'><button type='submit' name='Insert' class='btn btn-success'>+</button></a>		
		<br />
		<br />
		<?php 
                $pr_query = "SELECT count(*) ilosc_danych
					          FROM table (dziennik.daj_dane_uczniow('".$srednia."', ".$od.", ".$do." ))";
                $pr_result = oci_parse($connection,$pr_query);
				oci_execute($pr_result);
				oci_fetch($pr_result);
				$total_record = oci_result($pr_result, 'ILOSC_DANYCH');
			

                $total_pages = ceil($total_record/$num_per_page);
				
				if($page>1)
				{
					echo "<a href='index1.php?page=".($page-1)."' class='btn btn-warning'>Previous</a>".PHP_EOL;
					
				}	
				
				for($i=1;$i<=$total_pages;$i++)
					{
						
						echo "<a href='index1.php?page=".$i."' class='btn btn-primary'>".$i."</a>".PHP_EOL ;
					}
					
					if($page>=1)
					{
					echo "<a href='index1.php?page=".($page+1)."' class='btn btn-warning'>Next</a>".PHP_EOL;
					
				}	
    ?>
    </center>   	
	<div class="flex-box-1">
	<form>	
	<button class="button button2" onclick="y">GO</button>
	<input id="inp"  name="page" placeholder="Enter page number...">

	</div>
	<script src="script.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>  
	<script>  
$(document).on('click', '.edit', function() {  
  $(this).parent().siblings('td.data').each(function() {  
    var content = $(this).html();  
    $(this).html('<input value="' + content + '" />');  
  });  
  $(this).siblings('.save').show();  
  $(this).siblings('.delete').hide();  
  $(this).hide();  
});  
$(document).on('click', '.save', function() {  
  $('input').each(function() {  
    var content = $(this).val();  
    $(this).html(content);  
    $(this).contents().unwrap();  
  });  
  $(this).siblings('.edit').show();  
  $(this).siblings('.delete').show();  
  $(this).hide();  
});  

	</script>
  </body>   
</html> 