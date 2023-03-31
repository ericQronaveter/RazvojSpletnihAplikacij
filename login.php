<?php
include_once('header.php');

function validate_login($username, $password){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$pass = sha1($password);
	$query = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
	$res = $conn->query($query);
	if($user_obj = $res->fetch_object()){
		return $user_obj->id;
	}
	return -1;
}

$error="";
if(isset($_POST["submit"])){
	//Preveri prijavne podatke
	if(($user_id = validate_login($_POST["username"], $_POST["password"])) >= 0){
		//Zapomni si prijavljenega uporabnika v seji in preusmeri na index.php
		$_SESSION["USER_ID"] = $user_id;
		header("Location: index.php");
		die();
	} else{
		$error = "Prijava ni uspela.";
	}
}
?>
<div class="row justify-content-center p-3 mb-5">
  <div class="col-md-6 col-lg-4">
    <div class="card bg-primary bg-gradient text-white">
      <div class="card-body text-center">
        <h2 class="card-title text-center text-uppercase">Prijava</h2>
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label text-uppercase">Uporabniško ime</label>
            <input type="text" class="form-control" name="username" id="username">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label text-uppercase">Geslo</label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="mb-3">
            <input class="btn btn-light text-center" type="submit" name="submit" value="PRIJAVI">
          </div>
          <label><?php echo $error; ?></label>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include_once('footer.php');
?>