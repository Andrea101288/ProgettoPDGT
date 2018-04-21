<?php
  include 'settings.php';

	// Salvo i dati email e password dell'utente che vuole effettuare il login
	$user_username = $_REQUEST["username"];
	$user_password = $_REQUEST["password"];

	// Mi collego al database
	$conn = mysqli_connect($server, $user, $password) or die("Problemi nello stabilire la connessione");
	mysqli_select_db($conn, $database) or die("Errore di accesso al data base utenti");

	// Controllo che esistano nel database i dati inseriti
	$sql = "SELECT * FROM api_user WHERE '".$user_username."' = username AND '".$user_password."' = password;";
	$result = mysqli_query($conn, $sql);

  // Inizio la sessione
  session_start();

	// Se le righe sono maggiori di 0 vuol dire che ho trovato l'utente
	if (mysqli_num_rows($result) > 0){
		// Trovato: l'utente può accedere
  	// Salvo la mail della sessione
  	$_SESSION['username'] = $user_username;
		mysqli_close($conn);

    // Ridirezione l'utente alla pagina principale
    header("Location: paginaIniziale.php");
    die();
	}
	else{
  	$_SESSION['wrong_login'] = 1;
		mysqli_close($conn);

    // Ridirezione l'utente alla pagina di login
    header("Location: login.php");
    die();
	}
?>
