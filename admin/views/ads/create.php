<?php
// Funkcija preveri, ali v bazi obstaja uporabnik z določenim imenom in vrne true, če obstaja.
function username_exists($username){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query);
	return mysqli_num_rows($res) > 0;
}

// Funkcija preveri, ali v bazi obstaja uporabnik z določenim email in vrne true, če obstaja.
function email_exists($email){
	global $conn;
	$email = mysqli_real_escape_string($conn, $email);
	$query = "SELECT * FROM users WHERE email='$email'";
	$res = $conn->query($query);
	return mysqli_num_rows($res) > 0;
}

// Funkcija ustvari uporabnika v tabeli users. Poskrbi tudi za ustrezno šifriranje uporabniškega gesla.
function register_user($username, $password, $email, $address, $postNumber, $phoneNumber){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$email = mysqli_real_escape_string($conn, $email);
	$address = mysqli_real_escape_string($conn, $address);
	$postNumber = mysqli_real_escape_string($conn, $postNumber);
	$phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
	$pass = sha1($password);

	$query = "INSERT INTO users (username, password, email, address, postNumber, phoneNumber) VALUES ('$username', '$pass', '$email', '$address', '$postNumber', '$phoneNumber');";
	if($conn->query($query)){
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

$error = "";
if(isset($_POST["submit"])){
	//Preveri če se gesli ujemata
	if($_POST["password"] != $_POST["repeat_password"]) {
		$error = "Gesli se ne ujemata.";
	}
	else if(strlen($_POST["username"]) < 8) {
		$error = "Uporabniško ime krajše od 8 znakov.";
	}
	else if(strlen($_POST["password"]) < 8) {
		$error = "Geslo je krajše od 8 znakov.";
	}
	//Preveri ali uporabniško ime obstaja
	else if(username_exists($_POST["username"])) {
		$error = "Uporabniško ime je že zasedeno.";
	}
	//Preveri ali email že obstaja
	else if(email_exists($_POST["email"])) {
		$error = "Enaslov je že zaseden.";
	}
	//Podatki so pravilno izpolnjeni, registriraj uporabnika
	else if(register_user($_POST["username"], $_POST["password"], $_POST["email"], $_POST["address"], $_POST["postNumber"], $_POST["phoneNumber"])) {
		header("Location: login.php");
		die();
	}
	//Prišlo je do napake pri registraciji
	else {
		$error = "Prišlo je do napake med registracijo uporabnika.";
	}
}

?>

<div class="row justify-content-center p-3 m-2">
  <div class="col-md-6 col-lg-4">
    <div class="card bg-primary bg-gradient text-white">
      <div class="card-body text-center">
        <h2 class="card-title text-uppercase">Registracija</h2>
        <form action="?controller=users&action=store" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label text-uppercase">Uporabniško ime</label>
            <input type="text" class="form-control" name="username" id="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label text-uppercase">Geslo</label>
            <input type="password" class="form-control" name="password" id="password" required>
          </div>
          <div class="mb-3">
            <label for="repeat_password" class="form-label text-uppercase">Ponovi geslo</label>
            <input type="password" class="form-control" name="repeat_password" id="repeat_password" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label text-uppercase">E-naslov</label>
            <input type="email" class="form-control" name="email" id="email" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label text-uppercase">Naslov</label>
            <input type="text" class="form-control" name="address" id="address">
          </div>
          <div class="mb-3">
            <label for="postNumber" class="form-label text-uppercase">Pošta</label>
            <input type="number" class="form-control" name="postNumber" id="postNumber" min="1000" max="9999">
          </div>
          <div class="mb-3">
            <label for="phoneNumber" class="form-label text-uppercase">Telefonska številka</label>
            <input type="number" class="form-control" name="phoneNumber" id="phoneNumber">
          </div>
          <div class="mb-3">
            <input class="btn btn-light" type="submit" name="submit" value="DODAJ">
          </div>
          <label style="color: red;"><?php echo $error; ?></label>
        </form>
      </div>
    </div>
  </div>
</div>