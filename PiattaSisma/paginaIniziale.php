<html>
<head>
    <title> Pagina iniziale dopo aver effettuato l'accesso </title>
</head>
<body background="a.png" align="center" >
	<?php
	session_start();
	?>	
	<h2> <i align="center"> <font color='white'> Mappa </font> </i></h2> 
	
	<br>
	<br>
	<br>
	<p align="center"> 
	<?php
	
	$email = $_SESSION['email'];
	
	
	?>	
	<a href='queryFatte.php?email=".$email."'></a>
	<p/>
	
	<br>
	<br>
	<br>	
	<p align="center"> <a href="logout.php"> <font color='white'> Logout </font> <a/> </p>
	
	

</body>
</html>