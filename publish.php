<?php
include_once('header.php');

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
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	$price = mysqli_real_escape_string($conn, $price);
	$user_id = $_SESSION["USER_ID"];

	$arr=array();

	for ($x = 0; $x < count($imgs['name']); $x++) {
		$photoName = mysqli_real_escape_string($conn, $imgs["name"][$x]); //Pazimo, da je enolično!
		//sliko premaknemo iz začasne poti, v neko našo mapo, zaradi preglednosti
		move_uploaded_file($imgs["tmp_name"][$x], "photos/".$photoName);
		$source="photos/".$photoName;		
		//V bazo shranimo $pot
		array_push($arr,$source);
	}

	$sources = serialize($arr);

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
	return mysqli_real_escape_string($conn, $category);
}

$error = "";
if(isset($_POST["submit"])){
	$c1 = isset($_POST["Računalništvo"]) ? isCategorySet($_POST["Računalništvo"]) : "";
	$c2 = isset($_POST["Avto-moto"]) ? isCategorySet($_POST["Avto-moto"]) : "";
	$c3 = isset($_POST["Šport"]) ? isCategorySet($_POST["Šport"]) : "";
	$c4 = isset($_POST["Dom"]) ? isCategorySet($_POST["Dom"]) : "";
	$c5 = isset($_POST["Telefonija"]) ? isCategorySet($_POST["Telefonija"]) : "";
	$c6 = isset($_POST["Gradnja"]) ? isCategorySet($_POST["Gradnja"]) : "";
	$c7 = isset($_POST["Oblačila-pobutev"]) ? isCategorySet($_POST["Oblačila-pobutev"]) : "";
	$c8 = isset($_POST["Fotografija"]) ? isCategorySet($_POST["Fotografija"]) : "";
	$c9 = isset($_POST["Knjige"]) ? isCategorySet($_POST["Knjige"]) : "";

	$categoryPost = array($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9);
	if(strlen($_POST["title"]) == 0) {
		$error = "Prišlo je do napake pri objavi oglasa. Ni naslova.";
	}
	else if(strlen($_POST["description"]) == 0) {
		$error = "Prišlo je do napake pri objavi oglasa. Ni opisa.";
	}
	else if(strlen($_POST["price"]) == 0) {
		$error = "Prišlo je do napake pri objavi oglasa. Ni cene.";
	}
	else if(strlen($_FILES['file']['name'][0]) == 0) {
		$error = "Prišlo je do napake pri objavi oglasa. Ni slik.";
	}	
	else if(publish($_POST["title"], $_POST["description"], $_FILES['file'], $categoryPost, $_POST["price"])){
		header("Location: index.php");
		die();
	}
	else{
		$error = "Prišlo je do napake pri objavi oglasa.";
	}
}
?>
<div class="row justify-content-center p-2 m-4 text-center text-uppercase">
  <div class="col-md-6 col-lg-4">
    <div class="card bg-primary bg-gradient text-white">
      <div class="card-body">
        <h2 class="card-title">Objavi oglas</h2>
        <form action="publish.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" name="title" id="title">
          </div>
          <?php foreach($category as $cat) { ?>
            <div class="form-check d-flex align-items-center justify-content-center">
              <input class="form-check-input" type="checkbox" name="<?php echo $cat['name']; ?>" id="<?php echo $cat['name']; ?>" value="<?php echo $cat['name']; ?>">
              <label class="form-check-label" for="<?php echo $cat['name']; ?>">
                <?php echo $cat['name']; ?>
              </label>
            </div>
          <?php } ?>
          <div class="mb-3">
            <label for="description" class="form-label">Vsebina</label>
            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
          </div>
		  <div class="mb-3">
            <label for="price" class="form-label">Cena €</label>
            <input type="number" class="form-control" name="price" id="price" min=0>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Slika</label>
            <input class="form-control" type="file" name="file[]" id="file" multiple>
          </div>
          <div class="mb-3">
            <input class="btn btn-light" type="submit" name="submit" value="OBJAVI">
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