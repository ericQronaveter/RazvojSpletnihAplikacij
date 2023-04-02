<?php

// Model za uporabnika
/*
    Model z uporabniki.
    Čeprav nimamo users_controller-ja, ta model potrebujemo pri oglasih, 
    saj oglas vsebuje podatke o uporabniku, ki je oglas objavil.
    Razred implementira metodo find, ki jo uporablja Ads model zato, da 
    user_id zamenja z instanco objekta User z vsemi podatki o uporabniku.
*/

class User
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $address;
    public $postNumber;
    public $phoneNumber;
    public $isAdmin;

    // Konstruktor
    public function __construct($id, $username, $password, $email, $address, $postNumber, $phoneNumber, $isAdmin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
        $this->postNumber = $postNumber;
        $this->phoneNumber = $phoneNumber;
        $this->isAdmin = $isAdmin;
    }

    // Metoda, ki vrne uporabnika z določenim ID-jem iz baze
    public static function find($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM users WHERE id = '$id';";
        $res = $db->query($query);
        if ($user = $res->fetch_object()) {
            return new User($user->id, $user->username, $user->password, $user->email, $user->address, $user->postNumber, $user->phoneNumber, $user->isAdmin);
        }
        return null;
    }

    public static function all()
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $query = "SELECT * FROM users;"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $users = array();
        while ($user = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $ads
            array_push($users, new User($user->id, $user->username, $user->password, $user->email, $user->address, $user->postNumber, $user->phoneNumber, $user->isAdmin));
        }
        return $users;
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

    public static function insert($username, $password, $email, $address, $postNumber, $phoneNumber)
    {
        $db = Db::getInstance();
        $username = mysqli_real_escape_string($db, $username);
        $password = mysqli_real_escape_string($db, $password);
        $email = mysqli_real_escape_string($db, $email);
        $address = mysqli_real_escape_string($db, $address);
        $postNumber = mysqli_real_escape_string($db, $postNumber);
        $phoneNumber = mysqli_real_escape_string($db, $phoneNumber);

        $query = "INSERT INTO users (username, password, email, address, postNumber, phoneNumber) VALUES('$username', '$password', '$email', '$address', '$postNumber', '$phoneNumber');";
        if ($db->query($query)) {
            $id = mysqli_insert_id($db); // preberemo id, ki ga je dobil vstavljen oglas
            return User::find($id); // preberemo nov oglas iz baze in ga vrnemo controllerju
        } else {
            return null; // v primeru napake vrnemo null
        }
    }
}
