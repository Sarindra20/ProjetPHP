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

        *{
            padding: 0;
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
        }
    body{
                    background-color: #ffffff;

    }
        .boiteConn{
    /* border: 1px solid black; */
    border-radius: 20px;
    /* padding-left: 400px; */
    margin-left: 550px;
    margin-top: 200px;
    height: 400px;
    width: 400px;
    box-shadow: 5px 10px 10px black;
    background-color: #fffdfd;
    text-align: center; 
    display: flex;
    flex-direction: column;
    /* gap: 15px; */
    padding: 0;

}

input{
    height: 35px;
    width: 250px;
    border-radius: 30px;
    /* margin-top: 100px; */
    /* margin-bottom: 15px; */
}

input,button{
        margin-top: 40px;

}
button{
    height: 35px;
    width: 200px;
    border-radius: 30px;
    cursor: pointer;
    margin-top: 50x;
    box-shadow: 5px 10px 10px black;

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