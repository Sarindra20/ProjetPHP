<?php 
require 'conn.php';
session_start();

$error = "";

if($_SERVER ['REQUEST_METHOD'] == 'POST'){

$username = $_POST ['Login'];
$password = $_POST ['MotdePasse'];

$stmt = $connexion -> prepare( "SELECT * FROM admin WHERE Login = :Login");

$stmt ->  execute(['Login' => $username]);

$admin = $stmt -> fetch(PDO :: FETCH_ASSOC);

if(!$admin){
    $error = "Utilisateur non trouvé";
}

elseif($admin && $password == $admin['MotdePasse']){
    $_SESSION['admin'] = $admin['Login'];
        header("Location: Etudiant/liste.php");                  
        exit;
}

else  {
    $error = "Nom de l'utilisateur ou mot de passe incorrect";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>

    <style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}


body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f4f6f9;
}


.boiteConn {
    width: 380px;
    padding: 30px;
    background: white;
    border-radius: 12px;
    box-shadow: 0px 5px 20px rgba(0,0,0,0.15);
    text-align: center;
}


.boiteConn h1 {
    margin-bottom: 25px;
    color: #04371d;
    font-size: 24px;
    text-transform: uppercase;
}


.boiteConn input {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}


.boiteConn input:focus {
    border-color: #04371d;
    box-shadow: 0 0 5px rgba(4,55,29,0.3);
}


.boiteConn button {
    width: 100%;
    padding: 12px;
    margin-top: 25px;
    border: none;
    border-radius: 8px;
    background: #04371d;
    color: white;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}


.boiteConn button:hover {
    background: #066b35;
}


.error {
    color: red;
    margin-top: 10px;
    font-size: 13px;
}




    </style>
</head>
<body>
   
<div class="boiteConn">
    <h1 class="titre">User Login</h1>
 <form method="POST">
        <input type="text" placeholder="Username" name="Login" id="login" required>
    <br><br>
    <input type="password" name="MotdePasse" id="motPasse" placeholder="Password" required>

    <br><br>

    <button type="submit">Se connecter</button>

  
    </form>

</div>
   
</body>
</html>