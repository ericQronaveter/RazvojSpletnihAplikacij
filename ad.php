<?php 
include_once('header.php');

function addView($id) {
	global $conn;
	if (!isset($_COOKIE["page_views_$id"])) {
		// If no cookie exists, increment the view count and set a new cookie
		$conn->query("UPDATE ads SET views = views + 1 WHERE id = $id;");
		setcookie("page_views_$id", 1, time() + 43200); // 12-hour expiration
	}
} 

//Funkcija izbere oglas s podanim ID-jem. Doda tudi uporabnika, ki je objavil oglas.
function get_ad($id){
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT ads.*, users.username FROM ads LEFT JOIN users ON users.id = ads.user_id WHERE ads.id = $id;";
	$res = $conn->query($query);
	if($obj = $res->fetch_object()){
		return $obj;
	}
	return null;
}

function get_user_info($id){
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT email, phoneNumber FROM users WHERE id = $id;";
	$res = $conn->query($query);
	if($obj = $res->fetch_object()){
		return $obj;
	}
	return null;
}

function getAdCategories($id) {
	global $conn;
	$query = "SELECT category.name FROM categoryAd JOIN category ON categoryAd.idCategory = category.id WHERE categoryAd.idAd = '$id';";
	$result = $conn->query($query);
    $categoryAd = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryAd[] = $row;
    }
    return $categoryAd;
}

if(!isset($_GET["id"])){
	echo "Manjkajoči parametri.";
	die();
}

$id = $_GET["id"];
addView($id);
$ad = get_ad($id);
$userInfo = get_user_info($ad->user_id);

if($ad == null){
	echo "Oglas ne obstaja.";
	die();
}

$categoryAd = getAdCategories($ad->id);
$arrayImg = unserialize($ad->image);

?>
<div class="row justify-content-center p-3 m-3 text-center text-uppercase">
	<div class="col-md-8">
		<div class="card bg-primary bg-gradient text-white">
			<?php foreach($arrayImg as $img) { ?>
			<img src="<?php echo $img;?>" style="max-height:500px;" class="card-img-top" alt="<?php echo $ad->title;?>">
			<?php } ?>
			<div class="card-body">
				<h5 class="card-title"><?php echo $ad->title;?></h5>
				<p class="card-text"><?php echo $ad->description;?></p>
				<h5 class="card-title"><?php echo $ad->price;?> €</h5>
				<ul class="list-unstyled mb-3">
				<?php foreach($categoryAd as $cat) { ?>
					<li class="d-inline-block me-2"><span class="badge bg-secondary"><?php echo $cat['name'];?></span></li>
				<?php } ?>
				</ul>
				<div class="row mb-3">
				<div class="col-sm-6">
					<p class="card-text"><small class="text-white">Objavil: <?php echo $ad->username; ?></small></p>
				</div>
				<div class="col-sm-6 text-end">
					<p class="card-text"><small class="text-white">Ogledi: <?php echo $ad->views; ?></small></p>
				</div>
				</div>
				<hr>
				<p class="card-text"><strong>Telefon:</strong> <?php echo $userInfo->phoneNumber; ?></p>
				<p class="card-text"><strong>E-naslov:</strong> <?php echo $userInfo->email; ?></p>
				<a href="index.php" class="btn btn-primary">Nazaj</a>
			</div>
   		</div>
	</div>
</div>
	<?php

include_once('footer.php');
?>