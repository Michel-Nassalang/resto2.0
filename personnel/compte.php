<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=resto2.0', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    } 
    session_start();
    if(isset($_SESSION['pseudo']) && isset($_SESSION['id'])){
?>
<link rel="stylesheet" href="compte.css">
    <div class="side-menu">
        <div class="sidebar">
            <h1>Resto 2.0</h1>
        </div>
        <ul>
            <li><a href="?act=acceuil"><img src="../files/font/home.svg" alt="">&nbsp; Acceuil</a></li>
            <li><a href="?act=info"><img src="../files/font/info-circle.svg" alt="">&nbsp; Info+</a></li>
            <li><a href="?act=services"><img src="../files/font/servicestack.svg" alt="">&nbsp; Services</a></li>
            <li><a href="?act=achat"><img src="../files/font/shopify.svg" alt="">&nbsp; Achats</a></li>
            <li><a href="?act=partage"><img src="../files/font/share-square.svg" alt="">&nbsp; Partage</a></li>
        </ul>
    </div>
    <div class="container">
        <header>
            <nav>
                <div class="dashboard">
                    <img src="../files/font/bars.svg" alt="">
                    <h3>Acceuil</h3>
                </div>
                <div class="search">
                    <input type="text" value="" placeholder="Recherche">
                    <button type="button"> <img src="../files/font/search.svg"></button>
                </div>
                <button type="button" class="notif"><img src="../decoration/images/ring2.png"></button>
                <?php 
                    if(isset($_SESSION['pseudo']) && isset($_SESSION['id']) ){
                ?>
                <button type="button" class="profil"><img src="../files/profil/<?= $_SESSION['id']?>.png"></button>
                <?php 
                    }else{
                ?>  
                <button type="button" class="profil"><img src="../files/profil/profil.png"></button>
                <?php 
                    }
                ?>
            </nav>
        </header>
    </div>
<?php
    $compte = $db->prepare("SELECT * FROM compte WHERE id_compte = :cid");
    $compte->execute([
        'cid' => $_SESSION['id']
    ]);
    $mon_compte = $compte->fetch();
    if(isset($_GET['info'])){
    ?>
    
    <?php
    }
    elseif (isset($_GET['services'])) {
        # code...
    }elseif (isset($_GET['achat'])) {
        # code...
    }elseif (isset($_GET['partage'])) {
        # code...
    }
    else{
?>
    <div class="contain">
        <div class="column1">
            <div class="t_jaune">
                <div class="image">
                    <img src="../decoration/images/jaunes.png" alt="">
                </div>
                <div class="num">
                    <h3>Tickets </h3>
                    <h4><?= $mon_compte['t_repas'] ?></h4>
                </div>
            </div>
            <div class="t_rouge">
                <div class="image">
                    <img src="../decoration/images/rouges.png" alt="">
                </div>
                <div class="num">
                    <h3>Tickets petit déjeuner</h3>
                    <h4><?= $mon_compte['t_pdej'] ?></h4>
                </div>
            </div>
            <div class="solde">
                <div class="image">
                    <img src="../decoration/images/soldes.png" alt="">
                </div>
                <div class="num">
                    <h3>Solde</h3>
                    <h4><?= 1200 ?> Frcs CFA</h4>
                </div>
            </div>
        </div>
        <div class="column2">
            <div class="class1">
                <h4>Activités récentes</h4>
                <div class="activ"> 
                    <div class="colonnel">
                    </div> 
                    <?php  $trans = $db->prepare("SELECT * FROM transaction WHERE proprio= :proprio ORDER BY id DESC LIMIT 10");
                        $trans->execute(["proprio" => $_SESSION["pseudo"]]);
                        $act = $trans->fetch(PDO::FETCH_OBJ);
                        while($activ = $act){
                    ?>     
                    <div class="colonne">
                        ####
                    </div> 
                    <?php      
                        }
                    ?>
                </div>
            </div>
            <div class="class2">
                <h4>Amis</h4>
            </div>
        </div>
    </div>
<?php
    }
    }else{
        header("Location:../index.php");
    }
?>
