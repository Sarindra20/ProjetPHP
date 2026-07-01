<?php 
$host = 'localhost';
$nomBase ='phpbase';
$username = 'root';
$password = ''; 

try{
    $connexion = new
 PDO("mysql:host=localhost;dbname=phpbase", "root", "");
    $connexion ->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);

    // echo "Connexion réussit";

}

catch (PDOException $e) {
    echo" Erreur de connexion :" .
    $e-> getMessage();
    exit;
}
?>