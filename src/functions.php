<?php

/**
 * VERIFICATION DE DONNEES ENTREES PAR L'USER DE FAçON GENERAL
 */
function verifParams(){

    if (isset($_POST) && sizeof($_POST)>0) {
        
        foreach ($_POST as $key => $value) {
            
            $data = trim($value);
            $data = stripslashes($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data);

            $_POST[$key] = $data;
        }
    }
}

/**
 * ACCUEIL : AFFICHAGE CONNEXION UTILISATEUR ET ADMIN
 */
function displayaccueil(){

    $result = '
        <div class="accueil-content vh-100 d-flex align-items-center justify-content-center opacity-75" style="background-image:url(assets/images/bookheader.jpg); height:100%;">
            <div class="user-login flex-shrink-1 w-50 d-flex flex-column align-items-center mx-2 py-5 bg-light shadow-lg  bg-body-tertiary rounded">
                <h2 class="login-title">Connexion Utilisateur</h2>
                <form action="loginUser" method="post" class="mt-4 w-50 text-center">
                    <div class="form-group mt-3">
                        <input type="email" name="email" value="" class="form-control" id="email" placeholder="Votre Email..." required/>
                    </div>
                    <div class="form-group mt-3">
                        <input type="password" name="password" value="" class="form-control" id="password" placeholder="Votre Mot de passe..." required/>
                    </div>
                    <button type="submit" class="btn my-3">Se connecter</button>
                    <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."createCount".'">Créer un compte</a>
                </form>
            </div>
            <div class="admin-login flex-shrink-1 w-50 d-flex flex-column align-items-center mx-2 py-5 bg-primary shadow-lg  bg-body-tertiary rounded">
                <h2 class="login-title text-light">Connexion Administrateur</h2>
                <form action="loginAdmin" method="post" class="mt-4 w-50 text-center">
                    <div class="form-group mt-3"> 
                        <input type="email" name="email" value="" class="form-control" id="email" placeholder="Votre Email..." required/>
                    </div>
                    <div class="form-group mt-3">
                        <input type="password" name="password" value="" class="form-control" id="password" placeholder="Votre Mot de passe..." required/>
                    </div>
                    <button type="submit" class="btn my-3 bg-light text-primary fw-bold">Se connecter</button>
                </form>
            </div>
        </div>
    ';

    return $result;
}

/**
 * AFFICHAGE CREATION COMPTE UTILISATEUR
 */
function displaycreateCount(){

    $result  = '
        <h1 class="">INSCRIVEZ - VOUS</h1>
        <form action="actionInscription" method="post" class="mt-4">
        <div class="form-group mt-3">
            <label for="">Nom : </label><br />
            <input type="text" name="nom" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Prénom : </label><br />
            <input type="text" name="prenom" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Email : </label><br />
            <input type="email" name="email" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Password : </label><br />
            <input type="password" name="password" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
        <label for="">Ville : </label><br />
        <input type="text" name="ville" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Sexe : </label><br />
            <select name="sexe" class="form-control"> 
            <option value="1">Masculin</option> 
            <option value="2">Féminin</option>  
            </select> 
        </div>
        <button type="submit" class="btn my-3">S\'inscrire</button>
        <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."accueil".'">Retour</a>
        
        </form> 
        ';

        return $result;
}

/**
 * TRAITEMENT DES DONNEES POUR CREATION COMPTE UTILISATEUR
 */
function displayactionInscription(){
    global $model;

    $nom = strtoupper($_POST['nom']);
    $prenom = ucwords($_POST['prenom']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ville = $_POST['ville'];
    $sexe = $_POST['sexe'];

    $dataUser = $model->addUser($nom, $prenom, $email, $password, $ville, $sexe);

    if ($dataUser) {
        $authenUser = $model->authentifierUser($email, $password);
        $_SESSION['user'] = $authenUser;

        if ($authenUser) {
            
            header("Location: ".BASE_URL.SP."livre"."");
        }
    }
}

/**
 * AFFICHAGE DES LIVRES DANS L'ENSEMBLE ET GESTION DES FILTRES PAR TITRE ET AUTEUR
 */
function displaylivre(){
    global $model;
    global $categorie;

    $dataBook = $model->getBook(NULL, NULL, NULL, NULL);
    if (isset($_SESSION['admin'])) {
        $result = '
        <a href="'.BASE_URL.SP."addLivre".'" class="btn btn-success add-book my-3 w-100 h2">Ajout livre</a>
        ';
        $result .= '<table class="table caption-top my-3">
            <thead class=" bg-dark text-light">
              <tr>
                <th scope="col" class="text-primary">Titre</th>
                <th scope="col" class="text-primary">Auteur</th>
                <th scope="col" class="text-primary">Categorie</th>
                <th scope="col" class="text-primary">Etat</th>
                <th scope="col" class="text-primary">Actions</th>
              </tr>
            </thead>
            <tbody>';
    }else{
        $result = '<table class="table caption-top my-3">
            <thead class=" bg-dark text-light">
              <tr>
                <th scope="col">Titre</th>
                <th scope="col">Auteur</th>
                <th scope="col">Categorie</th>
                <th scope="col">Etat</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>';
    }

    //LES FILTRES
    if (isset($_POST['rechercheBook']) && !empty($_POST['rechercheBook'])) {
        
        $rechercheBook = $_POST['rechercheBook'];
        $rechercheBook = strtoupper($rechercheBook);
        $rechercheBook = strip_tags($rechercheBook);
        $rechercheBook = htmlspecialchars($rechercheBook);
        //print_r($rechercheBook); exit();

        $rechercheTitre = $model->getBook(NULL, NULL, $rechercheBook, NULL);
        $rechercheAuteur = $model->getBook(NULL, NULL, NULL, $rechercheBook);

        if (isset($rechercheTitre[0]) && $rechercheBook == $rechercheTitre[0]['titre']) {      
            
            //LIVRES PAR TITRE
            foreach ($rechercheTitre as $key => $value) {

                $empruntBook = $model->getEmpruntBook($value['id'], NULL);
        
                $result .='
                <tr>
                    <td>'.strtoupper($value['titre']).'</td>
                    <td>'.strtoupper($value['auteur']).'</td>
                    <td>'.$categorie[$value['categorie']-1]['nom'].'</td>';
                    
                if (isset($empruntBook[0]) && $empruntBook[0]['idBook'] == $value['id']) {
                    
                    $result .= '
                    <td class="etat-disponible"><a class="text-success fw-bold">Emprunté</a></td>
                    ';
                }else{
                    $result .= '
                    <td class="etat-disponible"><a class="text-success fw-bold">Disponible</a></td>
                ';
                }     
                $result .= '<td class="actions">';
        
                if (!isset($_SESSION['admin'])) {
                    
                    $result .= '
                    <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                    ';
                }else{
                    $result .= '
                    <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                    <a href="'.BASE_URL.SP."supprimerBook".SP.$value['id'].'" class="supprimer btn btn-block btn-primary">Supprimer</a>
                    ';
                }
        
                $result .= '</td>
                </tr>
                ';
            }
        }elseif (isset($rechercheAuteur[0]) && $rechercheBook == $rechercheAuteur[0]['auteur']) {
               
            //LIVRES PAR AUTEURS
            foreach ($rechercheAuteur as $key => $value) {

                $empruntBook = $model->getEmpruntBook($value['id'], NULL);
        
                $result .='
                <tr>
                    <td>'.strtoupper($value['titre']).'</td>
                    <td>'.strtoupper($value['auteur']).'</td>
                    <td>'.$categorie[$value['categorie']-1]['nom'].'</td>';
                    
                if (isset($empruntBook[0]) && $empruntBook[0]['idBook'] == $value['id']) {
                    
                    $result .= '
                    <td class="etat-disponible"><a class="text-success fw-bold">Emprunté</a></td>
                    ';
                }else{
                    $result .= '
                    <td class="etat-disponible"><a class="text-success fw-bold">Disponible</a></td>
                ';
                }     
                $result .= '<td class="actions">';
        
                if (!isset($_SESSION['admin'])) {
                    
                    $result .= '
                    <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                    ';
                }else{
                    $result .= '
                    <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                    <a href="'.BASE_URL.SP."supprimerBook".SP.$value['id'].'" class="supprimer btn btn-block btn-primary">Supprimer</a>
                    ';
                }
        
                $result .= '</td>
                </tr>
                ';
            }
        }

    }else{
        //TOUS LES LIVRES

    foreach ($dataBook as $key => $value) {

            $empruntBook = $model->getEmpruntBook($value['id']);
    
            $result .='
            <tr>
                <td>'.strtoupper($value['titre']).'</td>
                <td>'.strtoupper($value['auteur']).'</td>
                <td>'.$categorie[$value['categorie']-1]['nom'].'</td>';
                
            if (isset($empruntBook[0]) && $empruntBook[0]['idBook'] == $value['id']) {
                
                $result .= '
                 <td class="etat-disponible"><a class="text-success fw-bold">Emprunté</a></td>
                ';
            }else{
                $result .= '
                <td class="etat-disponible"><a class="text-success fw-bold">Disponible</a></td>
               ';
            }     
            $result .= '<td class="actions">';
    
            if (!isset($_SESSION['admin'])) {
                
                $result .= '
                 <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                ';
            }else{
                $result .= '
                 <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                 <a href="'.BASE_URL.SP."supprimerBook".SP.$value['id'].'" class="supprimer btn btn-block btn-primary">Supprimer</a>
                ';
            }
    
            $result .= '</td>
            </tr>
            ';
        }
    
    }

        
    $result .= '
    </tbody>
    </table>
    ';

    return $result;
}

/**
 *   AFFICHAGE PAGE AJOUT LIVRE : UNIQUEMENT POUR ADMIN
 */
function displayaddLivre(){

    $result  = '
        <form action="addLivreAction" method="post" class="mt-4">
        <div class="form-group mt-3">
            <label for="">Titre : </label><br />
            <input type="text" name="titre" value="" class="form-control" id="titre" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Auteur : </label><br />
            <input type="text" name="auteur" value="" class="form-control" id="titre" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Categorie : </label><br />
            <select name="categorie" class="form-control" id="categorie"> 
            <option value="1">Manga</option> 
            <option value="2">Roman</option>  
            <option value="3">Comics</option>  
            <option value="4">Sciences</option>  
            <option value="5 selected">Autres</option>  
            </select> 
        </div>
        <div class="form-group mt-3">
            <label for="">Date de parution : </label><br />
            <input type="date" name="date_parution" value="" class="form-control" id="date_parution" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Description : </label><br />
            <input type="text" name="description" value="" class="form-control" id="description" required/>
        </div>
      
        <button type="submit" class="btn my-3">Ajouter</button>
        <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."retour".'">Retour</a>
        
        </form> 
        ';

        return $result;
}

/**
 * TRAITEMENT DES DONNEES SUR L'AJOUT DE LIVRES
 */
function displayaddLivreAction(){
    global $model;

    $titre = strtoupper($_POST['titre']);
    $auteur = strtoupper($_POST['auteur']);
    $categorie = $_POST['categorie'];
    $date_parution = $_POST['date_parution'];
    $description = $_POST['description'];

    //print_r($date_parution); exit();
    $dataLivre = $model->addBook($titre, $auteur, $categorie, $date_parution, $description);
    if ($dataLivre) {
        
        header("Location: ".BASE_URL.SP."livre"."");
    }else{
        return NULL;
    }
}

/**
 * AFFICHAGE DES LIVRES PAR CATEGORIE
 */
function displaycategorie(){
    global $model;
    global $categorie;
    global $url;
    $idCategorie = $url[1];

    $result = '
    <h1 href="#" class="my-2">Bienvenue sur les livres de categorie '.$categorie[$idCategorie-1]['nom'].' !</h1>
    ';

    if (isset($idCategorie) && $idCategorie>0 && is_numeric($idCategorie) && $idCategorie<= sizeof($categorie)) {
        
        $dataBook = $model->getBook($idCategorie, NULL, NULL, NULL);
        $result .= '<table class="table caption-top">
            <thead class=" bg-dark text-light">
              <tr>
                <th scope="col" class="text-primary">Titre</th>
                <th scope="col" class="text-primary">Auteur</th>
                <th scope="col" class="text-primary">Categorie</th>
                <th scope="col" class="text-primary">Etat</th>
                <th scope="col" class="text-primary">Actions</th>
              </tr>
            </thead>
            <tbody>';
    
        foreach ($dataBook as $key => $value) {
            
            $result .='
            <tr>
                <td>'.$value['titre'].'</td>
                <td>'.$value['auteur'].'</td>
                <td>'.$categorie[$idCategorie-1]['nom'].'</td>   
                <td class="etat-disponible"><a>Disponible</a></td>  
                <td class="actions">'; 
            
            if (!isset($_SESSION['admin'])) {
        
                $result .= '
                    <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                ';
            }else{
                $result .= '
                    <a href="'.BASE_URL.SP."voirBook".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                    <a href="'.BASE_URL.SP."supprimerBook".SP.$value['id'].'" class="supprimer btn btn-block btn-primary">Supprimer</a>
                ';
            }

            $result .='</td>
            </tr>
            ';
        }
        
        $result .= '
        </tbody>
        </table>
        ';
    
    }else{

        $result = 'Error : Page introuvable';
    }

    return $result;
}

/**
 * RETOUR SUR LA PAGE DES LIVRES
 */
function displayretour(){

    header("Location: ".BASE_URL.SP."livre"."");
}

/**
 * SUPPRIMER UN LIVRE DE LA BASE DE DONNEES
 */
function displaysupprimerBook(){

    global $model;
    global $url;
    $id = $url[1];

    $deleteBook = $model->deleteBook($id);

    if ($deleteBook) {
        header("Location: ".BASE_URL.SP."livre"."");
    }else{
        return NULL;
    }
}

/**
 * VOIR LES DETAILS D'UN LIVRE ET EFFECTUER UN EMPRUNT
 */
function displayvoirBook(){

    global $model;
    global $categorie;
    global $url;
    $idBook = $url[1];

    if (isset($idBook) && $idBook>0 && is_numeric($idBook)) {
        
        $dataBook = $model->getBook(NULL, $idBook, NULL, NULL);
        $book = $dataBook[0];
       
        $empruntBook = $model->getEmpruntBook($idBook, NULL);
        if (isset($empruntBook[0])) {
            $user = $model->getUserById($empruntBook[0]['idUser']);
        }

        if (!isset($_SESSION['admin'])) {
            
            $result ='
            <div class="voir-book my-3 w-70">
                <div class="card">
                    <img src="'.BASE_URL.SP."assets".SP."images".SP."book.jpg".'" alt="">
                    <div class="card-body">
                    <h2>Titre : '.$book['titre'].'</h2>
                    <p>Categorie : '.$categorie[$book['categorie']-1]['nom'].'</p>
                    <p>Date de parution : '.$book['date_parution'].'</p>
                    <p>Description : '.$book['description'].'</p>
                    <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."retour".'">Retour</a>
                    </div>
                </div>';
            
            if (isset($empruntBook[0]) && $empruntBook[0]['idBook'] == $idBook) {
                $result .= '
                <div class="card">
                    <img src="'.BASE_URL.SP."assets".SP."images".SP."homme.png".'" alt="">
                    <div class="card-body">
                    <h2>Eprunté par : '.$user['nom']." ".$user['prenom'].'</h2>
                    <p>Numéro : '.$user['id'].'</p>
                    <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."rendreBookEmprunt".SP.$book['id'].'">Rendre</a>
                    </div>
                </div>';
                
            }else{
                
                $result .='
                <div class="emprunt">
                    <p>Saisir le numéro utilisateur pour emprunter ce livre</p>
                    <div class="form-group mt-3">
                        <select name="rechercher" class="form-control" id="categorie">           
                        <option>'.$_SESSION['user']['nom']." ".$_SESSION['user']['prenom']." / "."Numéro : ".$_SESSION['user']['id'].'</option>  
                        </select> 
                    </div>
                    <form action="'.BASE_URL.SP."empruntAction".SP.$book['id'].'" method="post">
                        <div class="form-group mt-3">
                            <label for="">Numéro : </label><br />
                            <input type="number" name="numero" value="" class="form-control" id="numero"/>
                        </div>
                        <button type="submit" class="btn btn-warning btn my-3">Emprunter</button>
                    </form>
                </div>';
            }
        

            $result .= '
            </div>
            ';
 
        }else{
            //AFFICHAGE APRES EMPRUNT LIVRE
        $result = '
        <div class="voir-book w-50">
            <div class="card">
                <img src="'.BASE_URL.SP."assets".SP."images".SP."book.jpg".'" alt="">
                <div class="card-body">
                <h2>Titre : '.$book['titre'].'</h2>
                <p>Categorie : '.$categorie[$book['categorie']-1]['nom'].'</p>
                <p>Date de parution : '.$book['date_parution'].'</p>
                <p>Description : '.$book['description'].'</p>
                <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."retour".'">Retour</a>
                </div>
            </div>
        </div>';

        }
    }

    return $result;
}


/**
 * AFFICHAGE DES UTILISATEURS
 */
function displayuser(){
    global $model;
   
    if (isset($_SESSION['admin'])) {
        $result = '
        <a href="'.BASE_URL.SP."addUser".'" class="btn btn-success add-book my-3 w-100 h2">Ajout Utilisateur</a>
        ';
    }

    $dataUser = $model->getUser();
    $result .= '<table class="table caption-top">
            <thead class="">
              <tr>
                <th scope="col" class="text-primary">Id</th>
                <th scope="col" class="text-primary">Nom</th>
                <th scope="col" class="text-primary">Prénom</th>
                <th scope="col" class="text-primary">Email</th>
                <th scope="col" class="text-primary">Ville</th>
                <th scope="col" class="text-primary">Sexe</th>
                <th scope="col" class="text-primary">Actions</th>
              </tr>
            </thead>
            <tbody>';
        foreach ($dataUser as $key => $value) {
            if ($value['sexe'] == 1) {
        
                $value['sexe'] = "Masculin";
            }elseif ($value['sexe'] == 2) {
                
                $value['sexe'] = "Féminin";
            }
            $result .='
            <tr>
                <td>'.$value['id'].'</td>
                <td>'.$value['nom'].'</td>
                <td>'.$value['prenom'].'</td>
                <td>'.$value['email'].'</td>   
                <td>'.$value['ville'].'</td>   
                <td>'.$value['sexe'].'</td>   
                <td class="actions"> 
                    <a href="'.BASE_URL.SP."voirUser".SP.$value['id'].'" class="btn btn-block btn-light">Voir</a>
                    <a href="'.BASE_URL.SP."supprimerUser".SP.$value['id'].'" class="supprimer btn btn-block btn-primary">Supprimer</a>
                </td>
            </tr>
            ';
           
        }
    
    $result .= '
    </tbody>
    </table>
    ';

    return $result;
}

/**
 *   AFFICHAGE PAGE AJOUT UTILISATEUR
 */
function displayaddUser(){

    $result  = '
        <form action="addUserAction" method="post" class="mt-4">
        <div class="form-group mt-3">
            <label for="">Nom : </label><br />
            <input type="text" name="nom" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Prénom : </label><br />
            <input type="text" name="prenom" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Email : </label><br />
            <input type="email" name="email" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Password : </label><br />
            <input type="password" name="password" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Ville : </label><br />
            <input type="text" name="ville" value="" class="form-control" required/>
        </div>
        <div class="form-group mt-3">
            <label for="">Sexe : </label><br />
            <select name="sexe" class="form-control"> 
            <option value="1">Masculin</option> 
            <option value="2">Féminin</option>  
            </select> 
        </div>
        <button type="submit" class="btn my-3">Enregistrer</button>
        <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."user".'">Retour</a>
        
        </form> 
        ';

        return $result;
}

/**
 * SUPPRESSION D'UN UTILISATEUR DANS LA BASE DE DONNEES
 */
function displaysupprimerUser(){

    global $model;
    global $url;
    $id = $url[1];

    $deleteBook = $model->deleteUser($id);

    if ($deleteBook) {
        header("Location: ".BASE_URL.SP."user"."");
    }else{
        return NULL;
    }
}

/**
 * TRAITEMENT DES DONNEES POUR L'AJOUT D'UN UTILISATEUR PAR L'ADMIN
 */
function displayaddUserAction(){
    global $model;

    $nom = strtoupper($_POST['nom']);
    $prenom = ucwords($_POST['prenom']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ville = $_POST['ville'];
    $sexe = $_POST['sexe'];

    $dataUser = $model->addUser($nom, $prenom, $email, $password, $ville, $sexe);

    //print_r($_POST); exit();
    if ($dataUser) {
        $authen = $model->authentifierUser($email, $password);

        if ($authen) {
            header("Location: ".BASE_URL.SP."user"."");
        }
    }else{
        return NULL;
    }
}

/**
 * VOIR LES DETAILS D'UN UTILISATEUR PAR L'ADMIN
 */
function displayvoirUser(){

    global $model;
    global $url;
    $idUser = $url[1];

    if (isset($idUser) && $idUser>0 && is_numeric($idUser)) {
        
        $dataUser = $model->getUserById($idUser);
        $empruntBook = $model->getEmpruntBook(NULL, $idUser);

       if (isset($dataUser['sexe'])) {

            if ($dataUser['sexe'] == 1) {
            
                $dataUser['sexe'] = "Masculin";
            }elseif ($dataUser['sexe'] == 2) {
                
                $dataUser['sexe'] = "Féminin";
            }
       }
        $result = '
        <div class="voir-book">
            <div class="card">
                <img src="'.BASE_URL.SP."assets".SP."images".SP."lecteur.jpg".'" alt="">
                <div class="card-body">
                <h2>'.$dataUser['nom']." ".$dataUser['prenom'].'</h2>
                <p>Email : '.$dataUser['email'].'</p>
                <p>Ville : '.$dataUser['ville'].'</p>
                <p>Sexe : '.$dataUser['sexe'].'</p>
                <p>Numéro : '.$dataUser['id'].'</p>
                <p>Emprunt en cours : '; 
            if (isset($empruntBook[0])) {
                foreach ($empruntBook as $key => $value) {
    
                    $idBook = $value['idBook'];
                    $book = $model->getBook(NULL, $idBook, NULL, NULL);
                    
                    $result .='<br> Titre : '.$book[0]['titre'].' - Auteur :  '.$book[0]['auteur'].' <br>';
                }
                
            }else{
                $result .='Aucun';
            }
                
            $result .= '</p>
                <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."user".'">Retour</a>
                </div>
            </div>
        </div>
        ';
        
    }

    return $result;

    //print_r($book); exit();
}

/**
 * CONNEXION POUR ADMIN
 */
function displayloginAdmin(){
    global $model;

    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin = $model->authentifierAdmin($email, $password);

    if ($admin) {
        $_SESSION['admin']= $email;
        header("Location: ".BASE_URL.SP."livre"."");
    }else{

        header("Location: ".BASE_URL.SP."accueil"."");
    }
}

/**
 * CONNEXION POUR UTILISATEUR
 */
function displayloginUser(){
    global $model;

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $model->authentifierUser($email, $password);

    //print_r($user); exit();
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: ".BASE_URL.SP."livre"."");
    }else{

        header("Location: ".BASE_URL.SP."accueil"."");
    }
}

/**
 * LA DECONNEXION
 */
function displaydeconnexion(){

    if (isset($_SESSION['admin'])) {
        unset($_SESSION['admin']);
    }elseif ($_SESSION['user']) {
        unset($_SESSION['user']);
    }
    header("Location: ".BASE_URL.SP."accueil"."");
}

/**
 * PROFIL UTILISATEUR
 */
function displayprofil(){

    if (isset($_SESSION['user']['sexe'])) {
        
        if ($_SESSION['user']['sexe'] == 1) {
            
            $_SESSION['user']['sexe'] = "Masculin";
        }elseif ($_SESSION['user']['sexe'] == 2) {
            
            $_SESSION['user']['sexe'] = "Féminin";
        }
    }

    $result = '

    <ul class="list-group my-3">
    <li class="list-group-item active" aria-current="true">Bienvenu sur votre profil '.$_SESSION['user']['nom']." ".$_SESSION['user']['prenom'].'</li>
    <li class="list-group-item">Sexe : '.$_SESSION['user']['sexe'].'</li>
    <li class="list-group-item">Nom : '.$_SESSION['user']['nom'].'</li>
    <li class="list-group-item">Prénom : '.$_SESSION['user']['prenom'].'</li>
    <li class="list-group-item">Email : '.$_SESSION['user']['email'].'</li>
    <li class="list-group-item">Ville : '.$_SESSION['user']['ville'].'</li>
    </ul>
    <div class="mt-3">
    <a href="'.BASE_URL.SP."updateProfil".'" class="btn btn-block btn-success">Mettre à jour mes données</a>
    </div>
    ';

    return $result;
}

/**
 * MISE A JOUR DU PROFIL UTILISATEUR
 */
function displayupdateProfil(){

    $result  = '
        <form action="updateProfilAction" method="post" class="mt-4">
        <div class="input-group mt-3">
        <label class="input-group-text" for="inputGroupSelect01">Sexe</label>
        <select class="form-select" id="inputGroupSelect01">
            <option selected>Choose...</option>
            <option value="1">Masculin</option>
            <option value="2">Féminin</option>
        </select>
        </div>
        <div class="form-group mt-3">
            <label for="">Nom : </label><br />
            <input type="text" name="nom" value="'.$_SESSION['user']['nom'].'" class="form-control"/>
        </div>
        <div class="form-group mt-3">
            <label for="">Prénom : </label><br />
            <input type="text" name="prenom" value="'.$_SESSION['user']['prenom'].'" class="form-control"/>
        </div>
        <div class="form-group mt-3">
            <label for="">Email : </label><br />
            <input type="email" name="email" value="'.$_SESSION['user']['email'].'" class="form-control"/>
        </div>
        <div class="form-group mt-3">
            <label for="">Ville : </label><br />
            <input type="text" name="ville" value="'.$_SESSION['user']['ville'].'" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-success my-3">Mettre à jour</button>
        <a type="btn" class="btn btn-primary my-3" href="'.BASE_URL.SP."profil".'">Retour</a>
        
        </form> 
        ';

        return $result;

}

/**
 * TRAITEMENT DES DONNEES DE LA MISE A JOUR DU PROFIL UTILISATEUR
 */
function displayupdateProfilAction(){

    global $model;

    $_POST['id'] = $_SESSION['user']['id'];

    //print_r($_POST); exit();

    $updateUser = $model->updateInfosUser($_POST);

    if ($updateUser) {
        
        $_SESSION['user'] = $model->getUserById($_POST['id']);
        $result = '<p class="btn btn-success btn-block mt-3">Mise à jour réussie </p>';
    }else{
        $result = '<p class="btn btn-danger btn-block">Mise à jour réussie </p>';
    }

    return $result.displayprofil();
}

/**
 * TRAITEMENT DES DONNEES POUR EMPRUNTER UN LIVRE PAR L'UTILISATEUR
 */
function displayempruntAction(){
        
    if (isset($_POST['numero']) && !empty($_POST['numero']) && ($_POST['numero'] == $_SESSION['user']['id'])) {
        global $model;
        global $url;
        $idUser = $_POST['numero'];
        $idBook = $url[1];
        $dataEmprunt = $model->empruntBook($idUser, $idBook);

        if ($dataEmprunt) {
            header("Location: ".BASE_URL.SP."livre"."");

        }else{
            return FALSE;
        }
        
    }
}

/**
 * RENDRE LE LIVRE EMPRUNTE : SUPPRIMER L'EMPRUNT DE LA BASE DE DONNEES
 */
function displayrendreBookEmprunt(){

    global $model;
    global $url;
    $idBook = $url[1];

    $deleteBookEmprunt = $model->deleteBookEmprunt($idBook);

    if ($deleteBookEmprunt) {
        header("Location: ".BASE_URL.SP."livre"."");
    }else{
        return NULL;
    }
}

/**
 * AFFICHAGE EMPRUNT EFFECTUE PAR LES UTILISATEURS
 */
function displayemprunt(){
    global $model;

    $dataEmprunt = $model->getEmpruntBook();
   
        $result = '
        <h1 class="my-3 text-center">LES EMPRUNTS</h1>
        ';
        $result .= '<table class="table table-dark caption-top my-3">
            <thead class="text-danger">
              <tr>
                <th scope="col" class="text-danger">Nom et prénom</th>
                <th scope="col" class="text-danger">Sexe</th>
                <th scope="col" class="text-danger">Ville</th>
                <th scope="col" class="text-danger">Livre emprunté</th>
                <th scope="col" class="text-danger">Auteur</th>
                <th scope="col" class="text-danger">Date Emprunt</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($dataEmprunt as $key => $value) {
                
                $user = $model->getUserById($value['idUser']);
                $book = $model->getBook(NULL,$value['idBook'], NULL, NULL);

                if ($user['sexe'] == 1) {
        
                    $user['sexe'] = "Masculin";
                }elseif ($user['sexe'] == 2) {
                    
                    $user['sexe'] = "Féminin";
                }

                $result .='
                <tr>
                    <td>'.$user['nom']." ".$user['prenom'].'</td>
                    <td>'.$user['sexe'].'</td>
                    <td>'.$user['ville'].'</td>
                    <td>'.$book[0]['titre'].'</td>
                    <td>'.$book[0]['auteur'].'</td>
                    <td>'.$value['date_emprunt'].'</td>
                ';
            }

    
        
        $result .= '
        </tbody>
        </table>
        ';

        return $result;
}

?>