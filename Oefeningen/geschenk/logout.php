<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    $hashedEmail    =   hash( 'sha512', $email );
    $cookieValue    =   $email . '##' . $hashedEmail;

    $cookie =   setcookie( 'authenticated', $cookieValue, time() - 3600 );

    $logout = new Message ("logout", "U bent afgemeld. Tot de volgende keer.");
    header('location: index.php');
    

?>