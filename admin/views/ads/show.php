<div class="container rounded text-center text-white bg-primary mt-5 p-3" >
<h1>Uporabniško ime: <?php echo $user->username; ?></h1><hr>
<h1>Geslo: <?php echo $user->password; ?></h1><hr>
<h1>E-naslov: <?php echo $user->email; ?></h1><hr>
<h1>Naslov: <?php echo $user->address; ?></h1><hr>
<h1>Pošta: <?php echo $user->postNumber; ?></h1><hr>
<h1>Telefon: <?php echo $user->phoneNumber; ?></h1><hr>
<h1>Admin: <?php echo $user->isAdmin; ?></h1><hr>
<a href="index.php"><button class="btn btn-light text-uppercase">Nazaj</button></h1><hr>
</div>