<?php
    session_start();
?>
<header>
        <div class='logo'>Resto 2.0<span></span></div>
        <nav>
            <ul>
                <li class="liste one"><a href="../../admin/admin.php">Acceuil</a></li>
                <li class="liste two "><a href="../../admin/pages/new.php">Etudiants</a></li>
                <li class="liste one"><a href="../../admin/pages/info.php">Info+</a></li>
                <?php 
                if(isset($_SESSION['pseudo']) && isset($_SESSION['id'])){
                ?>
                <li class="liste two"><a href="../../deconnexion.php">Deconnexion</a></li>
                <?php 
                }else{
                ?>
                <li class="liste two"><a href="../index.php">Connexion</a></li>
                <?php
                }
                ?> 
            </ul>
        </nav>
    </header>
    <link rel="stylesheet" href="../../decoration/inside/cadre.css">
    
    