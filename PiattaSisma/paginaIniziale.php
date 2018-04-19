<html>
<head>
    <title> Pagina iniziale dopo aver effettuato l'accesso </title>
</head>
<body background="a.png" align="center" >
	<?php
	session_start();
	?>	
	<h1> <i align="center"> <font color='white'> My google maps  </font> </i></h1> 
	
	<br>
	<br>
	<br>
	<p align="center"> 
	<?php
	
	$email = $_SESSION['email'];		
	
	?>
	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d77626.39125022873!2d13.264916037143031!3d43.69375434472468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sit!2sit!4v1524171918639" width="1000" height="650" frameborder="0" style="border:0" allowfullscreen></iframe>
	
	<br>	
	<p align="center"> <a href="logout.php"> <font color='white'> Logout </font> <a/> </p>
	
	

</body>
</html>