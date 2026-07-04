<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

     
        .nav {
            position: fixed;
            top: 70px;
            left: 0;

            width: 240px;
            height: calc(100vh - 70px);

            background: #ffffff;
            box-shadow: 3px 0 15px rgba(0, 0, 0, .15);

            padding: 20px 0;
            overflow-y: auto;
        }

    
        .side .titre {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #023123;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

    
        .liste {
            list-style: none;
            padding: 0;
            margin: 0;
        }

      
        .liste li {
            width: 100%;
        }

      
        .nav-link {
            display: block;
            padding: 12px 18px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            border-left: 4px solid transparent;
            transition: 0.2s;
        }

       
        .nav-link:hover {
            background: #f5f7fa;
            border-left: 4px solid #2ecc71;
            color: #2ecc71;
        }

        
        .nav-link.active {
            background: #eafaf1;
            border-left: 4px solid #27ae60;
            color: #172d20;
        }

       
        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        .liste {
            padding-top: 30px;
        }

        .side {
            padding-top: 100px;

        }

        .titre1 {
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .title {
            position: relative;
            float: right;
        }
    </style>
</head>

<body>

    <div class="nav">
      
        <div class="side">
            <h3 class="titre1">SIDEBAR</h3>
        </div>
        <ul class="liste">
            <li class="nav-item"><a href="../Etudiant/liste.php" class="nav-link bg-warning text-dark text-center fs-5">Etudiant</a></li>
            <li class="nav-item"><a href="../Professeur/listePro.php" class="nav-link bg-warning text-dark text-center fs-5">Professeur</a></li>
            <li class="nav-item"><a href="../Organisme/listeOrg.php" class="nav-link bg-warning text-dark text-center fs-5">Organisme</a></li>
            <li class="nav-item"><a href="../Soutenir/listeSoute.php" class="nav-link bg-warning text-dark text-center fs-5">Soutenance</a></li>
            <li class="nav-item"><a href="../Etudiant/effectif.php" class="nav-link bg-warning text-dark text-center fs-5">Effectif</a></li>
            <li class="nav-item"><a href="#" class="nav-link bg-warning text-dark text-center fs-5">#</a></li>
            <li class="nav-item"><a href="#" class="nav-link bg-warning text-dark text-center fs-5">#</a></li>
        </ul>
    </div>
</body>

</html>