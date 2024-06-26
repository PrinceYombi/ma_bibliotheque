<?php

class dataLayer{

    private $connexion;

    /**
     * CONNEXION A LA BASE DE DONNEES my_librairy
     */
    function __construct(){

        try {
            
            $this->connexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_ROOT, DB_PASSWORD);
    
            //echo 'Connexion réussie !';
        } catch (\Throwable $th) {
            
            echo "Erreur de connexion à la base de données";
        }

    }

    /**
     * AJOUTER UN LIVRE DANS LA BASE DE DONNEES
     * 
     * $titre : titre du livre
     * 
     * $auteur : auteur du livre
     * 
     * $data_parution : la date d'apparution du livre
     * 
     * $description : description du livre
     */
    function addBook($titre, $auteur, $categorie, $date_parution, $description){

        $sql = "INSERT INTO book (titre, auteur, categorie, date_parution, description) VALUES (:titre, :auteur, :categorie, :date_parution, :description)";

        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(
                ":titre"=>$titre,
                ":auteur"=>$auteur,
                ":categorie"=>$categorie,
                ":date_parution"=>$date_parution,
                ":description"=>$description
            ));

            if ($r) {
                
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * RECUPERATION D'UN LIVRE 
     * 
     * $categorie : Livre par catégorie
     * 
     * $idBook : Livre selon idBook
     * 
     * $titre : Livre selon le titre
     * 
     * $auteur : Livre selon l'auteur
     * 
     * @return $data : Array
     */
    function getBook($categorie=NULL, $idBook=NULL, $titre=NULL, $auteur=NULL){

        $sql = "SELECT * FROM book ";
        
        try {
            if (isset($categorie)) {
                $sql .= "WHERE categorie = $categorie";
            }
            if (isset($idBook)) {
                $sql .= "WHERE id = $idBook";
            }
            if (isset($titre)) {
                $sql .= "WHERE titre = '$titre'";
            }
            if (isset($auteur)) {
                $sql .= "WHERE auteur = '$auteur'";
            }

            //print_r($sql); exit();
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array());
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($r) {
                
                return $data;
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * RECUPERATION DES CATEGORIES
     * 
     * @return $data : les categories
     */
    function getCategorie(){
        $sql = "SELECT * FROM categorie";

        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array());
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($r) {
                
                return $data;
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * SUPPRESION DU LIVRE
     * 
     * $id : id du livre
     * 
     * @return TRUE : suppression avec success
     * 
     * @return FALSE : echec de la suppression
     */
    function deleteBook($id){

        $sql = "DELETE FROM book WHERE id = :id";

        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(":id"=>$id));

            if ($r) {
                
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (\Throwable $th) {
            
            return FALSE;
        }
    }

    /**
     * AJOUTER UN UTILISATEUR
     * 
     * $nom : nom de l'user
     * 
     * $prenom : prenom de l'user
     * 
     * $email : email user
     * 
     * $password : password user
     * 
     * $ville : ville user
     * 
     * $sexe : sexe user
     */
    function addUser($nom, $prenom, $email, $password, $ville, $sexe){

        $sql = "INSERT INTO users (nom, prenom, email, password, ville, sexe) VALUES (:nom, :prenom, :email, :password, :ville, :sexe)";

        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(
                ":nom"=>$nom,
                ":prenom"=>$prenom,
                ":email"=>$email,
                ":password"=>sha1($password),
                ":ville"=>$ville,
                ":sexe"=>$sexe
            ));

            if ($r) {
                
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * RECUPERATION DE L'USER
     * 
     * @return $data : les donnees de l'user
     */
    function getUser(){

        $sql = "SELECT * FROM users ";
        
        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array());
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($r) {

                return $data;
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * RECUPERATION DE L'USER SELON ID
     * 
     * $iduser : id utilisateur
     * 
     * @return $data[0] : un utilisateur precis
     */
    function getUserById($idUser){

        $sql = "SELECT * FROM users ";
        
        try {
          
            if (isset($idUser)) {
                $sql .= "WHERE id = :id";
            }
            //print_r($sql); exit();
            $result = $this->connexion->prepare($sql);
            $result->execute(array(":id"=>$idUser));
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($data) {
                
                unset($data[0]['password']);
                return $data[0];
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * AUTHENTIFICATION CONNEXION ADMIN
     * 
     * $email : email admin
     * 
     * $password : password admin
     * 
     * @return $data : les donnees de l'admin apres authentif
     * 
     * @return FALSE : echec authentification
     */
    function authentifierAdmin($email, $password){

        $sql = "SELECT * FROM admin WHERE email=:email";
        
        try {
          
            //print_r($sql); exit();
            $result = $this->connexion->prepare($sql);
            $result->execute(array(":email"=>$email));
            $data = $result->fetch(PDO::FETCH_ASSOC);
            
            if ($data && ($data['password'] == $password)) {

                unset($data['password']);
                return $data;
            }else{
                return FALSE;
            }
            
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**AUTHENTIFICATION CONNEXION UTILISATEUR
     * 
     * $email : email user
     * 
     * $password : password user
     * 
     * @return $data : les donnees user apres authentif
     * 
     * @return FALSE : echec authentification
     */
    function authentifierUser($email, $password){

        $sql = "SELECT * FROM users WHERE email=:email";
        
        try {
          
            //print_r($sql); exit();
            $result = $this->connexion->prepare($sql);
            $result->execute(array(":email"=>$email));
            $data = $result->fetch(PDO::FETCH_ASSOC);

            if (($data['password'] == sha1($password))) {
                
                unset($data['password']);
                return $data;
            }else{
                return FALSE;
            }
            
        //print_r($data); exit();
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * MISE A JOUR PROFIL UTILISATEUR
     * 
     * $newInfos : array($_POST)
     */
    function updateInfosUser($newInfos){

        $sql = "UPDATE users SET ";
        $idUser = $newInfos['id'];
        unset($newInfos['id']);

        try {
            
            foreach ($newInfos as $key => $value) {
                $value = stripslashes($value);
                $sql .= " $key = '$value' ,";
            }

            $sql = substr($sql,0,-1);
            $sql .= " WHERE id=:id";
            //print_r($sql); exit();
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(":id"=>$idUser));

            if ($r) {
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * SUPPRESSION D'UN UTILISATEUR
     * 
     * $id : id user
     */
    function deleteUser($id){

        $sql = "DELETE FROM users WHERE id = :id";

        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(":id"=>$id));

            if ($r) {
                
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (\Throwable $th) {
            
            return FALSE;
        }
    }

    /**
     * EMPRUNT LIVRE
     * 
     * $iduser : id utilisateur
     * 
     * $idBook : id livre
     */
    function empruntBook($idUser, $idBook){

        $sql = "INSERT INTO emprunt_livre (idUser, idBook) VALUES(:idUser, :idBook)";

        try {
            
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(
                ":idUser"=>$idUser,
                ":idBook"=>$idBook
            ));

            if ($r) {
                
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return NULL;
        }
    }

    /**
     * RECUPERATION DE L'EMPRUNT
     * 
     * $idBook : id livre
     */
    function getEmpruntBook($idBook=NULL, $idUser=NULL){

        
        $sql = "SELECT * FROM emprunt_livre ";
        
        try {
          

            if (isset($idBook)) {
                $sql .= "WHERE idBook = $idBook";
            }
            if (isset($idUser)) {
                $sql .= "WHERE idUser = $idUser";
            }
            //print_r($sql); exit();
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array());
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($r) {
               return $data;
            }
        } catch (\Throwable $th) {
            
            return NULL;
        }
    }

    /**
     * SUPPRESSION DE L'EMPRUNT / RENDRE LE LIVRE
     * 
     * $idBook : id livre
     */
    function deleteBookEmprunt($idBook){

        $sql = "DELETE FROM emprunt_livre WHERE idBook = :idBook";

        try {
            $result = $this->connexion->prepare($sql);
            $r = $result->execute(array(":idBook"=>$idBook));

            if ($r) {
                
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (\Throwable $th) {
            
            return FALSE;
        }
    }
}


?>