	<html>
<head>
    <title> registrazione alla piattaforma </title>
	<meta name="GENERATOR" content="Evrsoft First Page">
</head>
<body background="a.png" align="center" >
	<?php
	session_start();
	?>
	<h1><i align="center"> <font color="white"> Inserisci i dati richiesti per registrarti <font> </i> </h1>
	
	<form  method="post" name="registra" action="controlloRegistrazione.php" id="accesso">
    <table>
		<tr>
		<td> <font color="white"> Username <font> </td>

        <td> <input id="username" name="username" required> </td>
      </tr>
		<tr>
        <td> <font color="white"> Password <font> </td>

        <td><input id="password" name="password" required> </td>
      </tr>	  
		<tr>
	   
        <td><font color="white"> mail <font></td>

        <td><input id="email" name="email" required> </td>
      </tr>		 
		
    </table> <br>
	
	<input id="ok" value="REGISTER" type="submit" name="OK">
	
  </form>
	
	
	<p align="center"> <a href="index.php"> <font color="white"> Home <font> <a/></p>
	 
</body>
</html>