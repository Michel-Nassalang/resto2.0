<?php 
    try {
        $db = new PDO('mysql:host=localhost;dbname=resto2.0', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    } 
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="acceuil.css">
    <title>Resto 2.0 ֍ UGB</title>
</head>
<body>
    <div class="fixel">
        <form action="" method="post">
            <input type="text" name="pseudo" placeholder='Pseudo' required="required">
            <input type="password" name="password" placeholder="Mot de Passe" required="required">
            <input type="submit" class="submit" value="Je me connecte"><br>
            <a href="connexion/inscription.php" style ="color:white; text-decoration:none">M'inscrire</a><br>
        </form>
    </div>
</body>
</html>
<?php 
    if(isset($_POST['pseudo']) && isset($_POST['password']) && !empty($_POST['pseudo']) && !empty($_POST['password']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $pass = htmlspecialchars($_POST['password']);
        $connexion = $db->prepare('SELECT * FROM administration WHERE pseudo = :pseudo');
        $connexion->execute([
                    'pseudo' => $pseudo
                ]);
        $compte = $connexion->fetch();
        $ligne = $connexion->rowCount();
        $connexion_admin = $db->prepare('SELECT * FROM administrateur WHERE pseudo = :pseudo');
        $connexion_admin->execute([
                    'pseudo' => $pseudo
                ]);
        $compte_admin = $connexion_admin->fetch();
        $aligne = $connexion_admin->rowCount();
        if($ligne == 1)
        {
            if(password_verify($pass, $compte['password']))
            {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $compte['id'];
                header('Location: personnel/compte.php');
            }
            else{
?>
                <div class="erreur_code">
                    <p>Veuillez vérifier votre mot de passe.</p>
                </div>
<?php   
                }
        }elseif ($aligne == 1) {
            if(password_verify($pass, $compte_admin['password']))
            {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $compte_admin['id'];
                header('Location: admin/admin.php');
            }
            else{
?>
                <div class="erreur_code">
                    <p>Veuillez vérifier votre mot de passe.</p>
                </div>
<?php       }
        }else{
?>
                <div class="erreur_code">
                    <p>Veuillez vérifier votre pseudo.</p>
                </div>
<?php
        }
    }elseif(isset($_POST['pseudo']) && isset($_POST['password']) && empty($_POST['pseudo']) && empty($_POST['password']))
    {
?>
                <div class="erreur">
                    <p>Veuillez vérifier votre pseudo ou votre mot de passe si vous vous êtes inscris. <br>
                    Sinon veilllez vous inscrire. Nous serions contents de vous compter parmi vous.</p>
                </div>
<?php
    }
?>