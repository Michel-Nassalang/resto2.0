<?php
    session_start();
    if(isset($_SESSION['pseudo']) && isset($_SESSION['id'])){
?>

<link rel="stylesheet" href="admin.css">
<header>
    <div class="navbar">
        <div class='logo'>Resto 2.0<span></span></div>
        <ul>
            <li><a href="admin.php">Acceuil</a></li>
            <li><a href="pages/new.php">Etudiants</a></li>
            <li><a href="../deconnexion.php">Deconnexion</a></li>
        </ul>
    </div>
</header>
<div class="content">
    <h1>Administrateur Resto 2.0</h1>
    <p>Nos restos ont besoin de gens compétents pour assurer le bien être de nos étudiants.
     Pour assurer ce bien être des étudiants, nous allons ensemble fournir le nécessaire pour accompagner ces étudiants
     dans leur procédure d'enregistrement avec votre accord.
    </p>
    <div class="intro">
        <div class="falc"><span></span><a href="pages/gestiona.php">Administration</a></div>
        <div class="falc"><span></span><a href="pages/info.php">Informations</a></div>
    </div>
</div>
<?php  
 }else{
     header("Location:../index.php");
 }
?>