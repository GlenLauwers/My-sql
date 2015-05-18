<?php
 session_start();

    function __autoload( $classname )
    {
        require_once( 'classes/' . $classname . '.php' );
    }


    try
    {
        $db = new PDO('mysql:host=localhost;dbname=feest', 'root', '');
        $bericht = '';
        $index   =   'index.php';
        $message    =   Message::getMessage();

        if (isset($_POST['inloggen'])) 
        {	
        	$email = $_POST['mail'];
        	$wachtwoord = $_POST['wachtwoord'];

        	$_SESSION['registratie']['mail'] 	= $email;
        	$_SESSION['registratie']['wachtwoord'] = $wachtwoord;

        	$query = 'SELECT email, wachtwoord
        				FROM personeel
        				WHERE email = "'. $email .'"';

        	$statement = $db->prepare($query);
        	$statement->execute();

        	while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
        	{
        		$personeel[] = $row;
        	}

        	if ( ( $personeel[0]['email'] === $email ) && ( $personeel[0]['wachtwoord'] === $wachtwoord ) )
        	{
        		$hashedEmail = hash('sha512', $email);

        		$cookieValue    =   $mail . '##' . $hashedEmail;

                $cookie =   setcookie( 'authenticated', $cookieValue, time() + 3600 );

                header('location: dashboard.php');
        	}

        	else
        	{
        		$inlogError = new Message ("error", "E-mailadres of wachtwoord is niet juist. Probeer opnieuw.");
                header('location: ' . $index );
        	}

        }

    }

    catch ( PDOException $e )
    {
        $bericht    =   'Er ging iets mis bij het inladen van de database: "' . $e->getMessage().'"';
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="" />
    <title>Home - Personeelsfeest</title>
  </head>

  <body>
    <h1>Personeelsfeest</h1>

    <h2>Home</h2>
    
    <p><?= $bericht ?></p>

    <?php if ( $message ): ?>
        <div class="modal <?= $message['type'] ?>">
            <?= $message['text'] ?>
        </div>
    <?php endif ?>

    <p>U ben nog niet ingelogd. Gelieve u in te loggen</p>
    <p>Hebt u nog geen login, dan kunt u zich <a href="registreren.php">hier registreren</a>.</p>

    <form action="index.php" method="post">
    	<label for="mail">E-mailadres:</label>
    		<input type="text" name="mail" id="mail">

    	<label for="wachtwoord">Wachtwoord:</label>
    		<input type="password" name="wachtwoord" id="wachtwoord">

    	<input type="submit" name="inloggen" id="inloggen" value="Login">
    </form>

  </body>
</html>