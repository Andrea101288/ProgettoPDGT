<html>
<head>
    <title>login alla piattaforma</title>
</head>
<body background="a.png" align="center" >
	<?php
	session_start();
	?>
	<h1><i align="center"> <font color="white"> Inserisci la tua email e la tua password per accedere <font> </i> </h1>
	<form  method="post" name="Accedi" action="controlloLogin.php" id="accesso">
    <table>
	 <tr>
        <td> <font color="white"> Indirizzio e-mail <font> </td> 

        <td><input id="email" name="email" required> </td>
      </tr>
	  
      <tr>
        <td> <font color="white"> Password <font> </td> 

        <td><input id="password" name="password" required> </td>
      </tr>
	  
	  
    </table> 
	<br>
	
	<input id="ok" value="ACCEDI" type="submit" name="OK">
	
  </form>
	
	
	<p align="center"><a href="index.php"> <font color="white"> Home <font> <a/></p>
	
	

</body>
</html>