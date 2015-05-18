<?php
 session_start();

    function __autoload( $classname )
    {
        require_once( 'classes/' . $classname . '.php' );
    }


    try
    {
        $db = new PDO('mysql:host=localhost;dbname=feest', 'root', '');
        $dashboard   =   'dashboard.php';
        $bericht = '';
        $message    =   Message::getMessage();

        $email = $_SESSION['registratie']['email'];
        $wachtwoord = $_SESSION['registratie']['wachtwoord'];

        $query = 'SELECT *
        			FROM gekozengerecht
        			INNER JOIN personeel on personeel.id = gekozengerecht.id_personeel
        			INNER JOIN gerecht on gekozengerecht.id_gerecht = gerecht.id
					';

        $statement = $db->prepare($query);
        $statement->execute();

        while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
        {
            $personeel[] =   $row; 
        }

        var_dump($personeel);
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
    <title>Dashboard - Personeelsfeest</title>
  </head>
    <body>
                  
		<h1>Personeelsfeest</h1>

		<h2>Dashboard</h2>

        <?php if ( $message ): ?>
            <div class="modal <?= $message['type'] ?>">
                <?= $message['text'] ?>
            </div>
        <?php endif ?>

    </body>
</html>