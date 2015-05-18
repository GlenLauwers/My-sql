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

        if (isset($_POST['confirm-edit']))
        {
           
        
            $query  =   'SELECT *
                        FROM gerechten
                        WHERE id = "'. $_POST['confirm-edit'].'"';

            $statement = $db->prepare($query);
            $statement->execute();
    
            while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
            {
                $gerechten_bewerk[] =   $row; 
            }


        } 

        if (isset($_POST['wijzigen_artikel'])) 
        {
            $update_artikel    =   'UPDATE gerechten
                                    SET     naam_gerecht        =   :naam_gerecht,
                                            type                =   :type
                                    WHERE id = "'. $_POST['id_edit'].'"';
                                    
            $statement = $db->prepare( $update_artikel );
        
            $statement->bindValue(":naam_gerecht", $_POST['titel_edit']);                      
            $statement->bindValue(":type", $_POST['artikel_edit']); 

            $gedaan = $statement->execute( );
            if ($gedaan) 
            {
                $bewerk = new Message( "success", "De database is bewerkt." );
                header('location: artikels.php');
            }

            else
            {
                $bewerk = new Message( "error", "De database is niet bewerkt. Probeer opnieuw" ); 
                header('location: artikels.php');
                
            }
        }

        if (isset($_POST['confirm-verwijder'])) 
        {
            $verwijder_query =  'DELETE FROM gerechten 
                                    WHERE id = :id
                                    LIMIT 1';

            $del_statement  =   $db->prepare($verwijder_query);
            $del_statement->bindValue( ':id', $_POST['confirm-verwijder'] );
            $deleted  =   $del_statement->execute();


            if ($deleted) 
            {
                 $userExistsError = new Message( "succes", "Het gerecht is verwijderd" ); 
                header('location: artikels.php');
            }
    
            else
            {
                 $userExistsError = new Message( "error", "Het gerecht is niet verwijderd" ); 
                header('location: artikels.php');
            }


        }

        if (isset($_POST['toevoegen'])) 
        {
            if ((empty($_POST['naam'])) || (empty($_POST['type']))) 
            {
               $userExistsError = new Message( "error", "U moet alle velden invullen." ); 
                header('location: artikels.php');
            }

            else
            {

                $nieuw_gerecht   =   'INSERT INTO gerechten (naam_gerecht, type)
                                        VALUES (:naam_gerecht, :type) ';

                $statement  =   $db->prepare($nieuw_gerecht);

                $statement->bindValue(':naam_gerecht', $_POST['naam']);
                $statement->bindValue(':type', $_POST['type']);

                $statement->execute( );

                $registrationSuccess = new Message("success", "Uw gerecht is toegevoegd.");
                header('location: artikels.php');
            }
        }


        
        if ($gebruikers_type === 'Gebruiker') 
        {
            $userExistsError = new Message( "error", "U hebt geen bevoegdheid om op deze pagina te komen." ); 
            header('location: dashboard.php');
        }

        if (!isset($_COOKIE['authenticated'])) 
        {
            header('location: index.php');
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
        <title>Menu - Personeelsfeest</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Personeelsfeest</h1>

            <h2>Artikels</h2>

             <p>U bent ingelogd als "<?= $gebruiker[0]['voornaam'] ?> <?= $gebruiker[0]['familienaam'] ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
             <p>Terug naar <a href="dashboard.php">dashboard</a>.</p>

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

                <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                    <button class="nieuwartikel" type="submit" id="nieuw_artikel" name="nieuw_artikel">Nieuw gerecht toevoegen</button>
                </form>

            
            <div class="links">
                <?php foreach ($gerechten as $key => $value): ?>
                    <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                        <input type="hidden" name="id" id="id_edit" value="<?= $value['id'] ?>">
                        <ul>
                            <li><b>Naam: </b><?= $value['naam_gerecht'] ?></li>
                            <li><b>Type: </b><?= $value['type'] ?></li>
                        </ul>    
                            <button type="submit" id="confirm-edit" name="confirm-edit" value="<?= $value['id'] ?>">Wijzigen</button>
                            <button type="submit" id="confirm-verwijder" name="confirm-verwijder" value="<?= $value['id'] ?>">Verwijderen</button>
                    </form>
                <?php endforeach ?>
            </div>

            <?php if (empty($gerechten)): ?>
                <p>Geen artikels gevonden</p>
            <?php endif ?>

            <div class="rechts">
                <?php if (isset($_POST['confirm-edit'])): ?>
                    <?php foreach ($gerechten_bewerk as $key => $value): ?>
                        <div class="formulier"> 
                            <h3>Bewerken</h3>
        
                            <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                                <input type="hidden" name="id_edit" id="id_edit" value="<?= $value['id'] ?>">
            
                                <label for="titel_edit">Naam:</label>
                                    <input type="text" name="titel_edit" id="titel_edit" value="<?= $value['naam_gerecht'] ?>">
            
                                <label for="artikel_edit">Type: </label>
                                    <select name="artikel_edit">
                                        <option value="voorgerecht">Voorgerecht</option>
                                        <option value="hoofdgerecht">Hoofdgerecht</option>
                                        <option value="dessert">Dessert</option>
                                    </select>
            
                                <input type="submit" name="wijzigen_artikel" value="Wijzigen">
                            </form> 
                        </div>
                    <?php endforeach ?>
                <?php endif ?>

                <?php if (isset($_POST['nieuw_artikel'])): ?>
                    <div class="formulier"> 
                        <h3>Nieuw gerecht toevoegen</h3>

                        <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                            <label for="naam">Naam: </label>
                                <input type="text" id="naam" name="naam">

                            <label for="type">Type: </label>
                                    <select name="type">
                                        <option value="voorgerecht">Voorgerecht</option>
                                        <option value="hoofdgerecht">Hoofdgerecht</option>
                                        <option value="dessert">Dessert</option>
                                    </select>

                            <input type="submit" name="toevoegen" value="toevoegen">
                        </form>
                    </div>
                <?php endif ?>
            </div>
        </section>        
    </body>
</html>