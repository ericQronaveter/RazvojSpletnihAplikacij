<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
// Model za uporabnika
/*
    Model z uporabniki.
    Čeprav nimamo users_controller-ja, ta model potrebujemo pri oglasih, 
    saj oglas vsebuje podatke o uporabniku, ki je oglas objavil.
    Razred implementira metodo find, ki jo uporablja Ads model zato, da 
    user_id zamenja z instanco objekta User z vsemi podatki o uporabniku.
*/

class Comment
{
    public $id;
    public $title;

    // Konstruktor
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    // Metoda, ki vrne uporabnika z določenim ID-jem iz baze
    public static function find($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM comments WHERE id = '$id';";
        $res = $db->query($query);
        if ($comment = $res->fetch_object()) {
            return new Comment($comment->id, $comment->title);
        }
        return null;
    }

    public static function all()
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $query = "SELECT * FROM comments;"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $comments = array();
        while ($comment = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $ads
            array_push($comments, new Comment($comment->id, $comment->title));
        }
        
        return $comments;
    }

    public function update($username, $password, $email, $address, $postNumber, $phoneNumber)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $this->id);
        $username = mysqli_real_escape_string($db, $username);
        $password = mysqli_real_escape_string($db, $password);
        $email = mysqli_real_escape_string($db, $email);
        $address = mysqli_real_escape_string($db, $address);
        $postNumber = mysqli_real_escape_string($db, $postNumber);
        $phoneNumber = mysqli_real_escape_string($db, $phoneNumber);


        // Preverimo, če je uporabnik zamenjal sliko in sestavimo ustrezen query
        $query = "";
        $query = "UPDATE users SET username = '$username', password = '$password', email = '$email', address = '$address', postNumber = '$postNumber', phoneNumber = '$phoneNumber' WHERE id = '$id'";

        if ($db->query($query)) {
            return User::find($id); //iz baze pridobimo posodobljen oglas in ga vrnemo controllerju
        } else {
            return null;
        }
    }

    public function delete()
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $this->id);
        $query = "DELETE FROM users WHERE id = '$id'";
        if ($db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    public static function insert($title)
    {
        $db = Db::getInstance();
        $query = "INSERT INTO comments (ad_id, user_id, comment_text) VALUES (1, 2, '$title')";
        if ($db->query($query)) {
            $id = mysqli_insert_id($db); // preberemo id, ki ga je dobil vstavljen oglas
            return Comment::find($id); // preberemo nov oglas iz baze in ga vrnemo controllerju
        } else {
            return null; // v primeru napake vrnemo null
        }
    }
}
