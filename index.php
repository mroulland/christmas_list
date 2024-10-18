<?php 
    $file = file_get_contents("data.json");
    $datas = json_decode($file,true);
    $users = $datas["users"];

    $errors = [];
    if(isset($_POST) && !empty($_POST["id_user"])){
        if(isset($_POST["id_user"]) && is_numeric($_POST["id_user"]) && in_array($_POST["id_user"], array_keys($users))){
            $id = $_POST["id_user"];
        }else{
            $errors["id_user"] = "Le nom d'utilisateur n'est pas reconnu";
        }

        if(isset($_POST["idea"]) && strlen($_POST["idea"]) > 10 && strlen($_POST["idea"]) < 100){
            $idea = stripslashes(htmlspecialchars($_POST["idea"]));
        }
        else{
            $errors["idea"] = "Il y a une erreur (longueur < 10 ou > à 100)";
        }

        if(isset($_POST["link"]) && !empty($_POST["link"])){
            if(preg_match("#https:\/\/[a-z0-9\/:%_+.,\#\?\!@&=-]+#", $_POST["link"])){
                $link = stripslashes(htmlspecialchars($_POST["link"]));
            }else{
                 $errors["link"] = "Le lien n'est pas conforme";
            }
        }else{
            $link = "";
        }
    
        if(empty($errors)){
            array_push($users[$id]["wishlist"], array("idea"=>$idea, "link"=>$link, "status" => "0"));
            $datas["users"] = $users;
            file_put_contents("data.json", json_encode($datas));

            unset($_POST);
        }
    }

    if(isset($_GET["id_user"]) && isset($_GET["id_item"]) && isset($_GET["status"])){
        // enregistrement du nouveau status
        $datas["users"][$_GET["id_user"]]["wishlist"][$_GET["id_item"]]["status"] = $_GET["status"];
        file_put_contents("data.json", json_encode($datas));
        return json_encode('reponse ok');
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Liste de cadeaux de Noël</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <img src="imgs/Joyeux.png" max-height="600px" alt="cover">

    </header>
    <main>
        <section class="count">
            <p><span id="days">00</span><br><span id="day_label">jours</span></p>
            <p><span id="hours">00</span><br><span id="hours_label">heures</span></p>
            <p><span id="minutes">00</span><br><span id="minutes_label">minutes</span></p>
            <p><span id="secondes">00</span><br><span id="secondes_label">secondes</span></p>
        </section>
        <?php if(isset($_GET["name"])){ ?>
        <section class="cards">

            <?php 
            foreach($users as $id_user => $user){ 
                $list_user[$id_user] = $user["name"];
            ?>
            <article>
                <h2>Liste de <?php echo ucfirst($user["name"])?></h2>
                <img class="profil" src="imgs/<?php echo $user["picture"] ?>" alt="photo">
                <?php if($_GET["name"] == $user["name"]){ ?><i>Tu ne verras pas les éléments cochés dans ta liste</i><?php } ?>
                <form action="/">
                    <ul>
                        <?php foreach($user["wishlist"] as $index => $item){ ?>
                        <li>
                            <input type="checkbox" <?php if($item["status"] && $_GET["name"] != $user["name"]){?> checked <?php } ?> id="<?php echo $id_user."_".$index ?>">
                            <label for="<?php echo $id_user."_".$index ?>">
                                <?php echo  $item["idea"] ?>
                                <?php if(!empty($item["link"])){ ?><a href="<?php echo $item["link"]?>" target="_blank"><img src="imgs/hyperlien.png" alt="lien"width="20"></a><?php } ?>
                            </label>
                        </li>
                    <?php } ?>
                    </ul>
                </form>
            </article>
        <?php } ?>
        </section>
        

        <section class="add_gift">
            <h2>Ajouter une idée de cadeau</h2>
            <form action="#" method="POST">
                <div>
                    <select name="id_user" required>
                        <option value="" disabled selected hidden>Pour qui ?</option>
                        <?php 
                        asort($list_user);
                        foreach($list_user as $index => $user){ ?>
                            <option value="<?php echo $index;?>"><?php echo ucfirst($user);?></option>
                        <?php }?>
                    </select>
                    <input type="text" name="idea" placeholder="Quoi ?" required>
                </div>
                <input type="text" name="link" placeholder="Lien vers la boutique, l'article, Amazon, etc ...">
                <input type="submit" value="Envoyer">
            </form>
        </section>
        <?php } ?>
    </main>

    <footer>
    <p><a href="https://www.flaticon.com/fr/icones-gratuites/lien" title="lien icônes">Lien icônes créées par Royyan Wijaya -
    Flaticon</a></p>
    <p><a href="https://unsplash.com/fr/@torewen/illustrations" title="images">Image de profile par Tor Ewen -
    Unsplash</a></p>
    <script src="script.js"></script>
    <script>
        
        <?php if(!isset($_GET["name"]) || empty($_GET["name"]) || !in_array($_GET["name"], array('lucas', 'sam', 'emma', 'sophie', 'paul', 'alice'))){ ?>
        prompt_(); 
           
        <?php }       
        ?>
    </script>
    </footer>
</body>
</html>

