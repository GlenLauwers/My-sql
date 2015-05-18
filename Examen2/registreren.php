<?php
 session_start();

    function __autoload( $classname )
    {
        require_once( 'classes/' . $classname . '.php' );
    }


    try
    {
        $db = new PDO('mysql:host=localhost;dbname=feest', 'root', '');
        $registratieformulier   =   'registreren.php';
        $bericht = '';
        $message    =   Message::getMessage();

        if (isset($_POST['registreer'])) 
        {
        	$email  =   $_POST['email'];
            $wachtwoord = $_POST['wachtwoord'];

            $_SESSION['registratie']['email']        =   $email;
            $_SESSION['registratie']['wachtwoord']   =   $wachtwoord;

            $isEmail    =   filter_var( $email, FILTER_VALIDATE_EMAIL );

            if (!$isEmail)
            {
                $emailError = new Message( "error", "Dit is geen geldig e-mailadres. Vul een geldig E-mailadres in." ); 
                header('location: ' . $registratieformulier );
            }

            if (empty($email)) 
            {
                $emailError = new Message( "error", "Er is geen E-mailadres ingevuld." ); 
                header('location: ' . $registratieformulier );
            }

            if (empty($wachtwoord)) 
            {
                $emailError = new Message( "error", "Er is geen wachtwoord ingevuld." ); 
                header('location: ' . $registratieformulier );
            }

            if ((empty($wachtwoord)) && (empty($email))) 
            {
                $emailError = new Message( "error", "Vul je gegevens in." ); 
                header('location: ' . $registratieformulier );
            }

            else
            {
            	$query = 'SELECT email
            				FROM personeel
            				WHERE email = "'. $email . '"';

            	$statement = $db->prepare($query);
            	$statement->execute();

            	while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
            	{
            		$personeel[] = $row;
            	}

            	if ($personeel[0]['email'] == $email )
            	{
            		$userExistsError = new Message( "error", "De gebruiker met het e-mailadres '" . $email . "' komt reeds voor in onze database." ); 

                    header('location: ' . $registratieformulier );
            	}

            	else
            	{
            		$nieuw_personeel = 'INSERT INTO personeel (voornaam, familienaam, email, wachtwoord, gebruikerstype)
            							VALUES (:voornaam, :familienaam, :email, :wachtwoord, :gebruikerstype)';

            		$statement = $db->prepare($nieuw_personeel);

            		$statement->bindValue(':familienaam', $_POST['voornaam']);
            		$statement->bindValue(':voornaam', $_POST['familienaam']);
            		$statement->bindValue(':email', $_POST['email']);
            		$statement->bindValue(':wachtwoord', $_POST['wachtwoord']);
            		$statement->bindValue(':gebruikerstype', 2);

            		$statement->execute( );

            		$hashedEmail = hash('sha512', $email);

        			$cookieValue    =   $mail . '##' . $hashedEmail;

               		$cookie =   setcookie( 'authenticated', $cookieValue, time() + 3600 );

                	header('location: dashboard.php');
            	}
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
    <title>Registreren - Personeelsfeest</title>
  </head>
    <body>
                  
		<h1>Personeelsfeest</h1>

		<h2>Registreer online</h2>

        <?php if ( $message ): ?>
            <div class="modal <?= $message['type'] ?>">
                <?= $message['text'] ?>
            </div>
        <?php endif ?>

        <form action="registreren.php" method="post">
            <label for="voornaam">Voornaam:</label> 
                <input type="text" name="voornaam" id="voornaam">

            <label for="familienaam">Familienaam:</label> 
                <input type="text" name="familienaam" id="familienaam">

            <label for="email">E-mailadres:</label> 
                <input type="text" name="email" id="email">

            <label for="wachtwoord">Wachtwoord</label>
                <input type="password" name="wachtwoord" id="wachtwoord">   

            <input type="submit" name="registreer" value="registreer">    

        </form>
      
    </body>
</html>