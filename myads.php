<?php
include_once('header.php');

// Funkcija prebere oglase iz baze in vrne polje objektov
function get_ads(){
	$user_id = $_SESSION["USER_ID"];
	global $conn;
	$query = "SELECT * FROM ads WHERE user_id = '$user_id';";
	$res = $conn->query($query);
	$ads = array();
	while($ad = $res->fetch_object()){
		array_push($ads, $ad);
	}
	return $ads;
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

//Preberi oglase iz baze
$ads = get_ads();

//Izpiši oglase
//Doda link z GET parametrom id na oglasi.php za gumb 'Preberi več'
?>
<div class="container pt-3 text-uppercase text-center">
  <div class="row justify-content-center mb-3">
    <?php foreach($ads as $ad){
      $categoryAd = getAdCategories($ad->id);
      $arrayImg = unserialize($ad->image);
    ?>
      <div class="col-md-6 col-lg-4 mb-4 text-center text-uppercase">
        <div class="card bg-primary bg-gradient text-white">
          <img src="<?php echo $arrayImg[0];?>" height="300" class="card-img-top" alt="<?php echo $ad->title;?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $ad->title;?></h5>
            <h5 class="card-title"><?php echo $ad->price;?> €</h5>
            <p class="card-text"><?php echo $ad->description;?></p>
            <p class="card-text">Kategorije: <?php foreach($categoryAd as $cat) { echo "<span class=\"badge bg-dark me-2\">" . $cat['name'] . "</span>"; } ?></p>
            <a href="edit.php?id=<?php echo $ad->id;?>" class="btn btn-light me-2">Uredi</a>
            <a href="delete.php?id=<?php echo $ad->id;?>" class="btn btn-danger">Odstrani</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include_once('footer.php'); ?>