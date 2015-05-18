<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=personeelsfeest', 'root', '');
        $artikel = array();
        
        $message    =   Message::getMessage();
        $mail  =    $_SESSION['registratie']['mail'];
        $gebruikers_type = $_SESSION['gebruikers']['type'];

        $query  =   'SELECT *
                    FROM personeel
                    WHERE mailadres = "'. $mail.'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $gebruiker[] =   $row; 
    }

     $query  =   'SELECT *
                    FROM gerechten
                    ';

        $statement = $db->prepare($query);
        $statement->execute();

        while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
        {
            $gerechten[] =   $row; 
        }

         $query  =   'SELECT *
                        FROM personeel
                       INNER JOIN menukeuze ON menukeuze.id_personeel = personeel.id
                    ';

        $statement = $db->prepare($query);
        $statement->execute();

        while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
        {
            $personeel[] =   $row; 
        }

        if (isset($_POST['wijzigen'])) 
        {
            $menu    =   'UPDATE menukeuze
                                    SET     voorgerecht        =   :voorgerecht,
                                            hoofdgerecht                =   :hoofdgerecht,
                                            dessert     = :dessert
                                    WHERE id = "'. $_POST['id'].'"';
                                    
            $statement = $db->prepare( $menu );
        
            $statement->bindValue(":voorgerecht", $_POST['voorgerecht']);                      
            $statement->bindValue(":hoofdgerecht", $_POST['hoofdgerecht']); 
            $statement->bindValue(":dessert", $_POST['dessert']); 

            $gedaan = $statement->execute( );
            if ($gedaan) 
            {
                $bewerk = new Message( "success", "De database is bewerkt." );
                header('location: personeel_lijst.php');
            }

            else
            {
                $bewerk = new Message( "error", "De database is niet bewerkt. Probeer opnieuw" ); 
                header('location: personeel_lijst.php');
            }

            $personeel    =   'UPDATE personeel
                                    SET     voornaam        =   :voornaam,
                                            familienaam                =   :familienaam,
                                            mailadres     = :mailadres
                                    WHERE id = "'. $_POST['id'].'"';
                                    
            $statement = $db->prepare( $personeel );
        
            $statement->bindValue(":voornaam", $_POST['voornaam']);                      
            $statement->bindValue(":familienaam", $_POST['familienaam']); 
            $statement->bindValue(":mailadres", $_POST['mailadres']); 

            $gedaan = $statement->execute( );
            if ($gedaan) 
            {
                $bewerk = new Message( "success", "De database is bewerkt." );
                header('location: personeel_lijst.php');
            }

            else
            {
                $bewerk = new Message( "error", "De database is niet bewerkt. Probeer opnieuw" ); 
                header('location: personeel_lijst.php');
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
        <title>Personeel - Personeelsfeest</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Personeelsfeest</h1>

            <h2>Personeel</h2>

            <p>U bent ingelogd als "<?= $gebruiker[0]['voornaam'] ?> <?= $gebruiker[0]['familienaam'] ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>

            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <thead>
                        <tr>
                                <th>Voornaam</th>
                                <th>Familienaam</th>
                                <th>E-mailadres</th>
                                <th>Voorgerecht</th>
                                <th>Hoofdgerecht</th>
                                <th>Nagerecht</th>
                          
                            <th></th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php foreach ($personeel as $key => $personeel): ?>
                            <tr>
      
                                    <td><?= $personeel['voornaam'] ?></td>
                                    <td><?= $personeel['familienaam'] ?></td>
                                    <td><?= $personeel['mailadres'] ?></td>
                                    <td><?= $personeel['voorgerecht'] ?></td>
                                    <td><?= $personeel['hoofdgerecht'] ?></td>
                                    <td><?= $personeel['dessert'] ?></td>
                                <td>
                                    <button type="submit" name="edit" value="<?= $personeel['id_personeel'] ?>" class="edit-button">
                                        Wijzigen
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>                        
                    </tbody>       
                </table>
            </form>

            <?php if (isset($_POST['edit'])): ?>

                <form action="personeel_lijst.php" method="POST">
                    <input type="hidden" name="id" value="<?= $personeel['id_personeel'] ?>">
                    <label for="voornaam">Voornaam:</label>
                        <input type="text" name="voornaam" value="<?= $personeel['voornaam'] ?>">

                    <label for="familienaam">Familienaam:</label>
                        <input type="text" name="familienaam" value="<?= $personeel['familienaam'] ?>">

                    <label for="mailadres">E-mailadres:</label>
                        <input type="text" name="mailadres" value="<?= $personeel['mailadres'] ?>">

                    <label for="voorgerecht">Voorgerecht:</label>
                        <input type="text" name="voorgerecht" value="<?= $personeel['voorgerecht'] ?>">

                    <label for="hoofdgerecht">Hoofdgerecht:</label>
                        <input type="text" name="hoofdgerecht" value="<?= $personeel['hoofdgerecht'] ?>">

                    <label for="dessert">Dessert:</label>
                        <input type="text" name="dessert" value="<?= $personeel['dessert'] ?>">

                    <input type="submit" name="wijzigen" value="Wijzigen">
                </form>
                
            <?php endif ?>


