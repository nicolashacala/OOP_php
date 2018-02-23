<?php
function loadClass($className){
    require $className.'.php';
}
spl_autoload_register('loadClass');

session_start();

if(isset($_GET['disconnection'])){
    session_destroy();
    header('location: .');
    exit();
}
if(isset($_SESSION['charac'])){
    $charac = $_SESSION['charac'];
}

$db = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new CharacterManager($db);

if(isset($_POST['create']) && isset($_POST['name'])){
    $charac = new Character(['name' => $_POST['name']]);

    if(!$charac->validName()){
        $message = 'The name chosen is not valid.';
        unset($charac);
    }
    elseif($manager->exists($charac->name())){
        $message = 'This name is already taken.';
        unset($charac);
    }
    else{
        $manager->add($charac);
    }
}
elseif(isset($_POST['use']) && isset($_POST['name'])){
    if($manager->exists($_POST['name'])){
        $charac = $manager->get($_POST['name']);
    }
    else{
        $message = 'This character does not exist.';
    }
}
elseif(isset($_GET['hit'])){
    if(!isset($charac)){
        $message = 'Please create a character or log in.';
    }
    else{
        if(!$manager->exists((int)$_GET['hit'])){
            $message = 'The character you want to hit does not exist';
        }
        else{
            $characToHit = $manager->get((int)$_GET['hit']);
            $response = $charac->hit($characToHit);

            switch ($response){
                case Character::ME :
                $message = 'Why would you hit yourself???';
                break;
                
                case Character::CHARACTER_HIT :
                $charac->earnExperience(5, $characToHit);

                $message = 'HIT! +'.($characToHit->level()*5).'XP!';
                
                $manager->update($charac);
                $manager->update($characToHit);
                
                break;
                
                case Character::CHARACTER_KILLED :
                $charac->earnExperience(10, $characToHit);

                $message = 'You killed ' .$characToHit->name(). '! +'.($characToHit->level()*10).'XP!';
                
                $manager->update($charac);
                $manager->delete($characToHit);
                
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TP : Mini-fighting game</title>
    <meta charset="utf-8" />
</head>
<body>
<p>Number of characters created: <?= $manager->count() ?></p>
<?php
if(isset($message)){
    echo '<p>' . $message . '</p>';
}

if(isset($charac)){
    ?>
    <p><a href="?disconnection">Disconnection</a></p>
    <fieldset>
        <legend>My informations</legend>
        <p>
            Name: <?= htmlspecialchars($charac->name()) ?><br/>
            Level: <?= $charac->level() ?><br/>
            Experience: <?= $charac->experience() ?><br/>
            Damage: <?= $charac->damage() ?>
        </p>
    </fieldset>
    <fieldset disabled="disabled">
        <legend>Who do you  want to hit?</legend>
        <p>
            <?php
            $characList = $manager->getList($charac->name());

            if(empty($characList)){
                echo 'Nobody to hit';
            }
            else{
                foreach($characList as $oneCharac){
                    echo '<a href="?hit=' . $oneCharac->id() . '">' . htmlspecialchars($oneCharac->name()) . '</a>(level: '. $oneCharac->level() .', damage: ' . $oneCharac->damage() . ')<br/>';
                }
            }
            ?>
        </p>
    </fieldset>
<?php
}
else{
?>
<form action="" method="post">
    <p>
        Name: <input type="text" name="name" maxlength="50" />
        <input type="submit" value="Create this character" name="create" />
        <input type="submit" value="Use this character" name="use" />
    </p>
</form>
<?php
}
?>
</body>
</html>
<?php
if(isset($charac)){
    $_SESSION['charac'] = $charac;
}
?>