<?php
  include 'settings.php';

	// Salvo i dati dell'utente che desidera registrarsi
	$user_username = $_REQUEST["username"];
	$user_password = $_REQUEST["password"];
	$user_email = $_REQUEST["email"];

	// Mi collego al database
	$conn = mysqli_connect($server, $user, $password) or die("Problemi nello stabilire la connessione");
	mysqli_select_db($conn, $database) or die("Errore di accesso al data base utenti");

	//controllo duplicati: non posso accettare due Username uguali
  $sql = "SELECT * FROM api_user WHERE username = '".$user_username."'";
	$result = mysqli_query($conn, $sql);

  // Inizio la sessione
  session_start();

	// Se trovo almeno una riga abbiamo gia' un utente con lo stesso username
	if (mysqli_num_rows($result) > 0)
	{
  	$_SESSION['wrong_login'] = 1;
		mysqli_close($conn);

    // Ridirezione l'utente alla pagina principale
    header("Location: registrazione.php");
    die();
	}
	else
	{
		// Eseguo la query per l'inserimento dei dati nel database
		$sql = "INSERT INTO api_user VALUES('".$user_username."', '".$user_password."', '".$user_email."', 1 );";

		// se ritorna false c'è un errore
		if (!mysqli_query($conn, $sql)){
    	$_SESSION['wrong_login'] = 1;

      // Ridirezione l'utente alla pagina principale
      header("Location: registrazione.php");
      die();
		}else{
    	// Salvo la mail della sessione
    	$_SESSION['username'] = $user_username;
			mysqli_close($conn);

      // Ridirezione l'utente alla pagina principale
      header("Location: paginaIniziale.php");
      die();
		}
	}
?>
