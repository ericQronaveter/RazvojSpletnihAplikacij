<?php
include_once('header.php');

if(!isset($_GET["id"])){
	echo "Manjkajoči parametri.";
	die();
}
$adId = $_GET["id"];
if($adId == null){
	echo "Oglas ne obstaja.";
	die();
}

function removeAd($id) {
    global $conn;
    $user_id = $_SESSION["USER_ID"];
	$query = "SELECT * FROM ads WHERE user_id='$user_id' AND id = '$id'";
	if($conn->query($query)) {
		$query = "DELETE FROM ads WHERE user_id='$user_id' AND id = '$id'";
        $conn->query($query);
        return true;
	} else {
        return false;
    }
    return false;
}

// Funkcija prebere oglas iz baze
function get_ad($id){
	global $conn;
    $user_id = $_SESSION["USER_ID"];
	$query = "SELECT * FROM ads WHERE user_id = '$user_id' AND id = '$id'";
	$res = $conn->query($query);
    $ad = $res->fetch_object();
	return $ad;
}

//Preberi oglas iz baze
$ad = get_ad($adId);


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

$categoryAd = getAdCategories($adId);

function getCategories() {
	global $conn;
	$query = "SELECT name FROM category;";
	$arr = $conn->query($query);
	return $arr;
}

$category = getCategories();

function addCategory($id, $categories) {
	global $conn;
	$category = getCategories();
	for ($x = 0; $x < 9; $x++) {
		foreach($category as $cat) {
			if ($cat['name'] == $categories[$x]) {
				$idCat = $x + 1;
				$query = "INSERT INTO categoryAd (idAd, idCategory)
					VALUES('$id', '$idCat');";
				$conn->query($query);
			}
		}
	}
	return true;
}

// Funkcija vstavi nov oglas v bazo. Preveri tudi, ali so podatki pravilno izpolnjeni. 
// Vrne false, če je prišlo do napake oz. true, če je oglas bil uspešno vstavljen.

function publish($title, $desc, $imgs, $categoryPost, $price) {
	global $conn, $ad;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	$price = mysqli_real_escape_string($conn, $price);
	$user_id = $_SESSION["USER_ID"];

    $sources = $ad->image;
	$arr=array();


    if(strlen($imgs['name'][0]) > 1) {
		for ($x = 0; $x < count($imgs['name']); $x++) {
			$photoName = mysqli_real_escape_string($conn, $imgs["name"][$x]); //Pazimo, da je enolično!
			//sliko premaknemo iz začasne poti, v neko našo mapo, zaradi preglednosti
			move_uploaded_file($imgs["tmp_name"][$x], "photos/".$photoName);
			$source="photos/".$photoName;		
			//V bazo shranimo $pot
			array_push($arr,$source);
		}
		$sources = serialize($arr);
    }
	
	$date = date("Y-m-d");

	$query = "INSERT INTO ads (title, description, user_id, image, views, date, price)
				VALUES('$title', '$desc', '$user_id', '$sources', 0, '$date', '$price');";

	if($conn->query($query)){
		$last_id = $conn->insert_id;
		//addCategory($last_id, $categoryPost);
		if(addCategory($last_id, $categoryPost)){
			return true;
		}
		else{
			return false;
		}
	}
	else{
		//Izpis MYSQL napake z: echo mysqli_error($conn); 
		return false;
	}
}

function isCategorySet($category) {
	global $conn;
	if (isset($category)) {
		return mysqli_real_escape_string($conn, $category);
	}
	return "";
}

$error = "";
if(isset($_POST["submit"])){

	$c1 = isCategorySet($_POST["Računalništvo"]);
	$c2 = isCategorySet($_POST["Avto-moto"]);
	$c3 = isCategorySet($_POST["Šport"]);
	$c4 = isCategorySet($_POST["Dom"]);
	$c5 = isCategorySet($_POST["Telefonija"]);
	$c6 = isCategorySet($_POST["Gradnja"]);
	$c7 = isCategorySet($_POST["Oblačila-pobutev"]);
	$c8 = isCategorySet($_POST["Fotografija"]);
	$c9 = isCategorySet($_POST["Knjige"]);

	$categoryPost = array($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9);
	
	if(publish($_POST["title"], $_POST["description"], $_FILES['file'], $categoryPost, $_POST["price"])){
		header("Location: delete.php?id=$adId");
		die();
	}
	else{
		$error = "Prišlo je do napake pri urejanju oglasa.";
	}
}
?>
<div class="row justify-content-center pt-3 text-center text-uppercase">
  <div class="col-md-6 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">Objavi oglas</h2>
        <form action="edit.php?id=<?php echo $adId;?>" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" name="title" value="<?php echo $ad->title;?>" id="title">
          </div>
          <?php foreach ($category as $cat) { ?>
            <?php $checked = in_array($cat['name'], array_column($categoryAd, 'name')) ? 'checked' : ''; ?>
            <div class="form-check d-flex align-items-center justify-content-center">
              <input class="form-check-input" type="checkbox" name="<?php echo $cat['name']; ?>" id="<?php echo $cat['name']; ?>" value="<?php echo $cat['name']; ?>" <?php echo $checked; ?>>
              <label class="form-check-label" for="<?php echo $cat['name']; ?>">
                <?php echo $cat['name']; ?>
              </label>
            </div>
          <?php } ?>
          <div class="mb-3">
            <label for="description" class="form-label">Vsebina</label>
            <textarea class="form-control" name="description" id="description" rows="5"><?php echo $ad->description;?></textarea>
          </div>
		  <div class="mb-3">
            <label for="price" class="form-label">Cena €</label>
            <input type="number" class="form-control" name="price" id="price" min=0 value="<?php echo $ad->price;?>">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Slika</label>
            <input class="form-control" type="file" name="file[]" id="file" multiple>
          </div>
          <div class="mb-3">
            <input class="btn btn-primary" type="submit" name="submit" value="UREDI">
            <a class="btn btn-secondary" href="index.php">Nazaj</a>
          </div>
          <label style="color: red;"><?php echo $error; ?></label>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include_once('footer.php');
?>