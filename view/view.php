<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <!--
        -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($action == "categorie" || $action =="voirBook" || $action == "voirUser" || $action =="livre"):?>
        <!--<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap/bootstrap.css">-->
        <link rel="stylesheet" href="../assets/css/style.css">
    <?php endif ?>
    <?php if($action !== "categorie"):?>
        <!--<link rel="stylesheet" href="assets/bootstrap/css/bootstrap/bootstrap.css">-->
        <link rel="stylesheet" href="assets/css/style.css">
    <?php endif ?>
</head>
<body>
  
    <?php if($url[0] !=="accueil"): ?>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid w-50">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL.SP."livre"?>">Livres</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Catégorie</a>
                            <ul class="dropdown-menu">   
                            <?php 
                            
                            foreach ($categorie as $key => $value) {
                                
                                echo '<li><a class="dropdown-item" href="'.BASE_URL.SP."categorie".SP.$value['id'].'">'.$value['nom'].'</a></li>';
                            }
                            ?>

                            </ul>

                        </li>
                        <?php if(isset($_SESSION['admin'])):?>
                            <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL.SP."user"?>">Utilisateurs</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL.SP."emprunt"?>">Emprunt</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <form action="livre" method="post" class="w-50">
            <div class="input-group">
                <input type="text" class="form-control" name="rechercheBook" placeholder="Réchercher un livre par son titre ou auteur ...">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon1"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            </form>
            <?php if(!isset($_SESSION['admin'])):?>             
                <a href="<?php echo BASE_URL.SP."profil" ?>" class="btn btn-outline-success mx-3" type="button">Profil</a>
            <?php endif ?>
            <?php if(isset($_SESSION['admin']) || (isset($_SESSION['user']))):?>             
                <a href="<?php echo BASE_URL.SP."deconnexion" ?>" class="btn btn-outline-success mx-3" type="button">Déconnexion</a>
            <?php endif ?>
        </nav>
        <div class="librairy-title">
            <p class="title">Light BIBLIOTHEQUE</p>
            <p>Tous vos livres préferés !</p>
        </div>
    </header>
    <div class="container">
        <?php echo $content ?>
    </div>
    <?php endif ?>

    <?php if($url[0]=="accueil"):?>
    <div class="">
        <?php echo $content ?>
    </div>
    <?php endif ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>