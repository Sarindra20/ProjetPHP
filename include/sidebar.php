<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
   <!-- <link rel="stylesheet" href="../assets/bootstrap/css/sidebarstyle.css"> -->
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
    li{
    text-decoration: 0;
    list-style: none;
   color: #000000;

}
.nav{
    border: 1px solid black;
    border-radius: 20px;
        box-shadow: 0px 1px 2px black;
        float: left;
        height: 650px;
        width: 250px;
          position: absolute;
          display: flex;
          margin-top: 80px;

}
.side{
    margin-top: 10px;
    margin-left: 70px;
}
.liste{
    margin-left: -33px;
    margin-top: -200px;
}
a{
         height: 50px;
    width: 250px;
}
.nav-link.active{
    background-color: #f7d410 !important;
    border: 1px solid black;
    color: #000000;
}
.nav-link:hover{
    background-color: #e41576 !important;
    color: #000000 !important;
    border-radius: 0px;
    transition: 0.3s;
    border-color: #280df9;
}








</style>
</head>    

<body>

    <div class="nav">

        <div class="side">
            <h3 class="titre">SIDEBAR</h3>
        </div>
        <ul class="liste">
            <li class="nav-item"><a href="../Etudiant/liste.php" class="nav-link bg-warning text-dark text-center fs-5">Etudiant</a></li>
            <li class="nav-item"><a href="../Professeur/listePro.php" class="nav-link bg-warning text-dark text-center fs-5">Professeur</a></li>
            <li class="nav-item"><a href="../Organisme/listeOrg.php" class="nav-link bg-warning text-dark text-center fs-5">Organisme</a></li>
            <li class="nav-item"><a href="../Soutenir/listeSoute.php" class="nav-link bg-warning text-dark text-center fs-5">Soutenance</a></li>
            <li class="nav-item"><a href="#" class="nav-link bg-warning text-dark text-center fs-5">#</a></li>
            <li class="nav-item"><a href="#" class="nav-link bg-warning text-dark text-center fs-5">#</a></li>
            <li class="nav-item"><a href="#" class="nav-link bg-warning text-dark text-center fs-5">#</a></li>
        </ul>
    </div>
</body>
</html>