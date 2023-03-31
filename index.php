<?php
include_once('header.php');

// Funkcija prebere oglase iz baze in vrne polje objektov
function get_ads(){
    global $conn;
    $query = "SELECT * FROM ads ORDER BY date DESC;";
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

?>
<div class="row justify-content-center mt-3 mb-3">
<?php
//Izpiši oglase
//Doda link z GET parametrom id na oglasi.php za gumb 'Preberi več'
foreach($ads as $ad) {
    $categoryAd = getAdCategories($ad->id);
    $arrayImg = unserialize($ad->image);
?>
  <div class="col-md-6 col-lg-4 mb-4 text-center text-uppercase">
    <article>
      <a href="ad.php?id=<?php echo $ad->id;?>" class="text-decoration-none text-dark">
        <div class="card bg-primary bg-gradient text-white">
          <img src="<?php echo $arrayImg[0];?>" height="300" class="card-img-top" alt="<?php echo $ad->title;?>">
          <div class="card-body bg-primary bg-gradient">
            <h5 class="card-title text-white"><?php echo $ad->title;?></h5>
            <h5 class="card-title text-white"><?php echo $ad->price;?> €</h5>
            <p class="card-text mb-0"><small class="text-white">Kategorije:</small></p>
            <ul class="list-unstyled mb-0">
              <?php foreach($categoryAd as $cat) { ?>
              <li class="d-inline-block me-2"><span class="badge bg-dark test-white"><?php echo $cat['name'];?></span></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </a>
    </article>
  </div>
<?php } ?>
</div>
<br>
<?php
include_once('footer.php');
?>