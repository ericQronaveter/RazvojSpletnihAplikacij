<!-- pogled za pregeld vseh oglasov-->
<!-- na vrhu damu uporabniku gumb, s katerim proži akcijo create, da lahko dodaja nove uporabnike -->
<div class="container bg-primary mt-5 text-center mx-auto">
    <h3>Ustvari oglas:</h3>
    Naslov: <input type="text" name="title" id="create_ad_title" />
    <button id="create_ad_btn">Dodaj</button>
    <hr />
</div>
<div class="bg-primary text-white">
    <h1 class="text-uppercase text-center">Komentarji</h>
        <table class="table table-bordered bg-primary bg-gradient text-white text-center border-light">
            <thead>
                <tr>
                <th>Komentar</th>
                <th>Objavil</th>
                </tr>
            </thead>
        <tbody id="ads_tbody">
        </tbody>
        </table>
</div>
<script>
  $(document).ready(async function() {
    await loadAds();
    $("#create_ad_btn").click(createAd);
    $(".edit_ad_btn").click(editClickHandler);
    $(".delete_ad_btn").click(deleteClickHandler);
  });

  async function loadAds() {
    await $.get("/RazvojSpletnihAplikacij/api/index.php/ads", renderAds);
  }

  function renderAds(ads) {
    ads.forEach(function(ad) {
      var row = document.createElement("tr");
      row.id = ad.id;
      row.innerHTML = "<td>" + ad.title + "</td>";
      row.innerHTML += "<td><button class='edit_ad_btn'>Uredi</button><button class='delete_ad_btn'>Izbriši</button></td>";
      $("#ads_tbody").append(row);
    });
  }

  function createAd() {
    var data = {
      title: $("#create_ad_title").val()
    };

    $("#create_ad_title").val("");
    $.post('/RazvojSpletnihAplikacij/api/index.php/ads/', data, function(data) {
      var row = document.createElement("tr");
      row.id = data.id;
      row.innerHTML = "<td>" + data.title + "</td>";
      row.innerHTML += "<td><button class='edit_ad_btn'>Uredi</button><button class='delete_ad_btn'>Izbriši</button></td>";
      $(".edit_ad_btn", row).click(editClickHandler);
      $(".delete_ad_btn", row).click(deleteClickHandler);
      $("#ads_tbody").append(row);
    });
  }

  function editClickHandler() {
    var row = $(this).closest("tr");

    if ($(this).text() == "Uredi") {
      $(this).text("Shrani");
      row.find('td:not(:nth-last-child(-n+2)').attr('contenteditable', true);
    } else {
      $(this).text("Uredi");
      row.find('td:not(:nth-last-child(-n+2))').attr('contenteditable', false);
      updateAd(row);
    }
  }

  function updateAd(row) {
    var id = row.attr("id");
    var data = {
      title: row.find('td:nth-child(1)').text(),
      description: row.find('td:nth-child(2)').text()
    };

    $.ajax({
      url: '/RazvojSpletnihAplikacij/api/index.php/ads/' + id,
      method: 'PUT',
      data: JSON.stringify(data),
      contentType: 'application/json'
    });
  }

  function deleteClickHandler() {
    var row = $(this).closest("tr");
    deleteAd(row);
    row.remove();
  }

  function deleteAd(row) {
    var id = row.attr("id");
    $.ajax({
      url: '/RazvojSpletnihAplikacij/api/index.php/ads/' + id,
      method: 'DELETE'
    });
  }
</script>