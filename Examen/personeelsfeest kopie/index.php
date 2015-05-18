<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }


    try
    {
        $db = new PDO('mysql:host=localhost;dbname=personeelsfeest', 'root', '');
        $index   =   'index.php';
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

                $mail       =   $_POST['mail'];
                $wachtwoord = $_POST['wachtwoord'];

                $_SESSION['registratie']['mail']            =   $mail;
                $_SESSION['registratie']['wachtwoord']      =   $wachtwoord;

                $query  =   'SELECT mailadres, wachtwoord
                                FROM personeel
                                WHERE mailadres = "'. $mail.'"';

                $statement = $db->prepare($query);
                $statement->execute();

                while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
                {
                    $gebruikers[] =   $row; 
                }

             
                if (($gebruikers[0]['mailadres'] === $mail) && ($gebruikers[0]['wachtwoord'] === $wachtwoord)) 
                {
                    header('location: dashboard.php');

                    $hashedEmail    =   hash( 'sha512', $mail );
                    $cookieValue    =   $mail . '##' . $hashedEmail;

                    $cookie =   setcookie( 'authenticated', $cookieValue, time() + 3600 );
                    
                }

                else
                {
                    $inlogError = new Message ("error", "E-mailadres of wachtwoord is niet juist. Probeer opnieuw.");
                    header('location: ' . $index );
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
        <title>Home - Personeelsfeest</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Personeelsfeest</h1>

            <h2>Login</h2>

            

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <form action="index.php" method="post">
                <p>U bent nog niet ingelogd.</p>
                <label for="mail">E-mailadres:</label> 
                    <input type="text" name="mail" id="mail">

                <label for="wachtwoord">Wachtwoord</label>
                    <input type="password" name="wachtwoord" id="wachtwoord">   

                <input type="submit" name="submit" value="log in">    

            </form>

            <p>Nog geen login? <a href="registreren.php">Registreer dan hier</a>.</p>

        </section>
        
    </body>
</html>