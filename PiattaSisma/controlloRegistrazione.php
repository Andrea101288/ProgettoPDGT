
<html>
<head>
  <title>controllo registrazione</title>
  <meta name="GENERATOR" content="Evrsoft First Page">
</head>

<body background="a.png" align="center" >
<?php
	
	// inizio sessione
	session_start();
	
	// salvo i dati dell'utente che desidera registrarsi
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$email = $_REQUEST["email"];   
   
	// setto la variabile session per controllare se la mail è gia presente in database
	$_SESSION['email'] = $email;
   
	// mi connetto al database
	$conn = mysqli_connect("localhost", "root", "") or die("Problemi nello stabilire la connessione");
	mysqli_select_db($conn,"piattasisma") or die("Errore di accesso al data base api_user");

	//controllo duplicati: non posso accettare due Username uguali
	$result = mysqli_query($conn, " select * from api_user where email = '$email' ");
	
	// se trova una riga abbiamo trovato un utente con lo stesso username!
	if (mysqli_num_rows($result) > 0) 
	{
		// mando un messaggio di errore 
		echo "<h1><i align='center'> <font color='white'> Email già presente in database! </font> </i> </h1>";
		echo "<h3><a href='registrazione.php'> <font color='white'> Retry </font> </a></h3>";
	}
	else
	{	
		// eseguo la quer per l'inserimento dei dati nel database 
		$comando = " INSERT INTO api_user VALUES('".$username."', '".$password."', '".$email."', 1 );";
		echo $comando;
		// se ritorna false c'è un errore 
		if (!mysqli_query($conn, $comando)){
			echo "<h1><i align='center'> <font color='white'> Inserimento fallito si e' verificato un errore tecnico </font> </i> </h1>";
			echo "<h3><a href='registrazione.php'> <font color='white'> Retry </font> </a></h3>";
			
		}else{
			// altrimenti inserisco i dati nel database 
			echo "<h1><i align='center'> <font color='white'> Registrazione effetuata, Benvenuto ".$username."! </font> </i> </h1>";
			// accedo alla pagina inziale del sito
			echo "<h3><a href='paginaIniziale.php'> <font color='white'> Entry </font> </a></h3>";
		}
	}
	mysqli_close($conn);
?>
</body>
</html>
