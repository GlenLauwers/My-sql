<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=Geschenk', 'root', '');
        $registratieformulier   =   'registreren.php';
        $message    =   Message::getMessage();
        $gebruikers = array();
 
        if (isset($_COOKIE['authenticated'])) 
        {
            header('location: dashboard.php');
        }

        else
        {
            if (isset($_POST['submit'])) 
            {   

                $gebruikersnaam  =   $_POST['gebruikersnaam'];
                $wachtwoord = $_POST['wachtwoord'];
                $voornaam  =   $_POST['voornaam'];
                $familienaam = $_POST['familienaam'];
                $email  =   $_POST['email'];

                $_SESSION['registratie']['gebruikersnaam']   =   $gebruikersnaam;
                $_SESSION['registratie']['wachtwoord']       =   $wachtwoord;

                $isEmail    =   filter_var( $email, FILTER_VALIDATE_EMAIL );

                if (!$isEmail)
                {
                    $emailError = new Message( "error", "Dit is geen geldig e-mailadres. Vul een geldig e-mailadres in." ); 
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
                    $query  =   'SELECT gebruikersnaam
                                    FROM personeel
                                    WHERE gebruikersnaam = "'. $gebruikersnaam.'"';

                    $statement = $db->prepare($query);
                    $statement->execute();

                    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
                    {
                        $gebruikers[] =   $row; 
                    }

                    if ($gebruikers[0]['gebruikersnaam'] === $gebruikersnaam) 
                    {
                        $userExistsError = new Message( "error", "De gebruiker komt reeds voor in onze database." ); 
                        header('location: ' . $registratieformulier );
                    }

                    else
                    {
                        $hashed_wachtwoord =   hash( 'sha512', $wachtwoord );

                        $nieuwe_gebruiker   =   'INSERT INTO personeel (gebruikersnaam, email, wachtwoord, gebruikerstype, voornaam, familienaam)
                                                    VALUES (:gebruikersnaam, :email, :wachtwoord, :gebruikerstype, :voornaam, :familienaam) ';

                        $statement  =   $db->prepare($nieuwe_gebruiker);

                        $statement->bindValue(':gebruikersnaam', $gebruikersnaam);
                        $statement->bindValue(':wachtwoord', $hashed_wachtwoord);
                        $statement->bindValue(':email', $email);
                        $statement->bindValue(':gebruikerstype', "gebruiker");
                        $statement->bindValue(':voornaam', $voornaam);
                        $statement->bindValue(':familienaam', $familienaam);

                        $statement->execute( );

                        $registrationSuccess = new Message("success", "Welkom, u bent vanaf nu geregistreerd in onze app.");
                        header('location: dashboard.php');

                        $hashedEmail    =   hash( 'sha512', $email );
                        $cookieValue    =   $email . '##' . $hashedEmail;

                        $cookie =   setcookie( 'authenticated', $cookieValue, time() + 3600 );
                    }
                }
            }
        }
    }
    
    catch ( PDOException $e )
    {
        $bericht    =   'Er ging iets mis bij het inladen van de database: "' . $e->getMessage().'"';
    }

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Geschenken</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Geschenken</h1>

            <h2>Registreer online</h2>

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <form action="registreren.php" method="post">
                
                <label for="gebruikersnaam">Gebruikersnaam:</label> 
                    <input type="text" name="gebruikersnaam" id="gebruikersnaam">

                <label for="email">E-mail:</label> 
                    <input type="text" name="email" id="email">

                <label for="wachtwoord">Wachtwoord:</label>
                    <input type="password" name="wachtwoord" id="wachtwoord"> 

                <label for="voornaam">Voornaam:</label>
                    <input type="text" name="voornaam" id="voornaam">

                <label for="familienaam">Familienaam:</label>
                    <input type="text" name="familienaam" id="familienaam">    

                <input type="submit" name="submit" value="registreer">    

            </form>

        </section>
        
    </body>
</html>