<?php 
    try {
        $db = new PDO('mysql:host=localhost;dbname=resto2.0', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    } 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../acceuil.css">
    <title>Resto 2.0 ֍ UGB</title>
</head>
<body>
    <div class="fixel" >
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="prenom" placeholder="Prénom" required="required">
            <input type="text" name="nom" placeholder="Nom" required="required">
            <input type="text" name="ide" placeholder="Id Etudiant" required="required">
            <input type="text" name ="pseudo" placeholder="Pseudo" required="required">
            <input type="email" name="email" placeholder="Email" required="required">
            <input type="password" name="password" placeholder="Mot de Passe" required="required">
            <input type="password" name="confirmation" placeholder="Confirmation" required="required">
            <input type="text" name="ufr" placeholder="Ufr">
            <input type="file" name="image" class="upload_box" required="required" />
            <select name="genre" id="genre">
                <option value="Homme" selected>Homme</option>
                <option value="Femme">Femme</option>
            </select>
            <input type="submit" class="submit" value="Je m'inscris"><br>
            <a href="../index.php" style ="color:white; text-decoration:none">Me connecter</a>
        </form>
    </div>
</body>
</html>
<?php 
    //------------------------------------------------
    if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['ide']) && isset($_POST['pseudo']) &&
     isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmation']) && isset($_POST['ufr']) && 
     !empty($_POST['nom']) && !empty($_POST['prenom']) &&
     !empty($_POST['password']) && !empty($_POST['confirmation']) && !empty($_POST['pseudo']) && !empty($_POST['email']))
    {   
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $ide = htmlspecialchars($_POST['ide']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirmation = htmlspecialchars($_POST['confirmation']);
        $ufr = htmlspecialchars($_POST['ufr']);
        $genre = htmlspecialchars($_POST['genre']);
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $image = htmlspecialchars($_FILES['image']['name']);
        $image_tmp = htmlspecialchars($_FILES['image']['tmp_name']);
        $image_error = htmlspecialchars($_FILES['image']['error']);
        $image_size = htmlspecialchars($_FILES['image']['size']);
        
        $selection_mail = $db->prepare('SELECT * FROM etudiant WHERE email = :email');
        $selection_mail->execute([
                    'email' => $email
                ]);
        $e_mail = $selection_mail->fetch();
        $selection_pseudo = $db->prepare('SELECT * FROM etudiant WHERE pseudo = :pseudo');
        $selection_pseudo->execute([
                    'pseudo' => $pseudo
                ]);
        $p_seudo = $selection_pseudo->fetch();
        $selection_ide = $db->prepare('SELECT * FROM etudiant WHERE id_etudiant = :ide');
        $selection_ide->execute([
                    'ide' => $ide
                ]);
        $id_e = $selection_ide->fetch();
        if($password != $confirmation)
        {
        ?>
            <div class="erreur_code">
                <p>Les mots de passe donnés ne correspondent pas. <br>
                Veuillez vérifier si le mot de passe donné correspond à celui donné dans la confirmation</p>
            </div>
            
        <?php
        }
        elseif (!empty($e_mail)) {
        ?>
            <div class="erreur_code">
                <p>L'email que que vous avait donné existe déjà pour un compte. <br>
                Merci de réessayer avec une autre adresse email</p>
            </div>
        <?php }
        elseif (!empty($p_seudo)) {
        ?>
            <div class="erreur_code">
                <p>Veuillez réessayer avec un autre pseudo car ce dernier est déjà utilisé.</p>
            </div>
        <?php
        } 
        elseif (!empty($id_e)) {
            ?>
                        <div class="erreur_code">
                            <p>Veuillez vérifier votre identifiant d'étudiant.</p>
                        </div>
            <?php
        }else{
            if (isset($image) && $image_error == 0) {
                if ($image_size <= 4000000){
                    $info_fichier = pathinfo($image);
                    $extension_fichier = $info_fichier['extension'];
                    $auto_extension = array('jpg','png','jpeg');
                    if (in_array($extension_fichier, $auto_extension)) {
                        $img = $image;
                        if ($extension_fichier === 'png') {
                            move_uploaded_file($image_tmp, '../files/verification/'.basename($ide.".png"));
                        }else{
                            move_uploaded_file($image_tmp, '../files/verification/'.basename($ide.".jpg"));
                        }
                        $insertion = $db->prepare('INSERT INTO administration(id_etudiant, nom, prenom, pseudo, email, password, ufr) VALUES (:id_etudiant, :nom, :prenom, :pseudo, :email, :pass, :ufr)');
                        $insertion->execute([
                            "id_etudiant" => $ide,
                            "nom" => $nom,
                            "prenom" => $prenom,
                            "pseudo" => $pseudo,
                            "email" => $email,
                            "pass" => $pass,
                            "ufr" => $ufr
                        ]);
                        ?>
                        <div class="erreur_code">
                                <p>Nous vous remercions pour l'inscription. Veuillez patienter 2 jours pour la validation de votre compte. </p>
                            </div>
                        <?php
                    }
                    else{
                        ?>
                        <div class="erreur_code">
                            <p>Veuillez insérer une image de format png, jpg ou jpeg.</p>
                        </div>
                        <?php
                    }
                }
                else {
                    ?>
                    <div class="erreur_code">
                        <p>Veuillez insérer une image de plus petite taille.</p>
                    </div>
                <?php
                }
            }else {
                ?>
                <div class="erreur_code">
                    <p>Veuillez charger une image correcte.</p>
                </div>
            <?php
            }
        }
    }
?>