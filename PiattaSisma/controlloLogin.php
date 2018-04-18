<html>
<head>
  <title>Login dal DataBase</title>
  <meta name="GENERATOR" content="Evrsoft First Page">
</head>

<body background="a.png" align="center" >
<?php
	
	// inizio la sessione
	session_start();
	
	// salvo i dati email e password dell'utente che vuole effettuare il login
	$email = $_REQUEST["email"];
	$password = $_REQUEST["password"];
	
	// controllo che la mail sia la stessa
	$_SESSION['email']= $email;
  
	// mi collego al datab
	$conn = mysqli_connect("localhost", "root", "") or die("Problemi nello stabilire la connessione");
	mysqli_select_db($conn, "piattasisma") or die("Errore di accesso al data base utenti");

	//controllo che esistano nel database i dati inseriti
	$sql = "select * from api_user where '".$email."' = email AND '".$password."' = password;";
	$result = mysqli_query($conn, $sql);
	
	// se le righe sono maggiori di 0 vuol dire che ho trovato l'utente
	if (mysqli_num_rows($result) > 0){ 
		//trovato: l'utente può accedere 
		mysqli_close($conn);	 
		echo "<h1><i align='center'> <font color='white'> Welcome! </font> </i> </h1>";
		echo "<h3><a href='paginaIniziale.php'> <font color='white'> Entry </font> </a></h3>";
	}
	else{ 
		// l'utente non esiste 
		echo "<h1><i align='center'> <font color='white'>  Dati inseriti non corretti! </font> </i> </h1>";
		echo "<h3><a href='login.php'> <font color='white'> Retry </font> </a></h3>";
		mysqli_close($conn);
	}
?>
</body>
</html>
