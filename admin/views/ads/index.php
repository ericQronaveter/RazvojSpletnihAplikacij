<h3 class="text-uppercase text-primary text-center">Seznam vseh uporabnikov</h3>
<div class="d-flex justify-content-center">
  <a href="?controller=users&action=create"><button class="btn btn-primary text-uppercase mb-3">Dodaj</button></a>
</div>
<div class="mx-5">
<table class="table table-bordered bg-primary bg-gradient text-white text-center border-light">
  <thead>
    <tr>
      <th class="p-2">ID</th>
      <th class="p-2">IME</th>
      <th class="p-2">GESLO</th>
      <th class="p-2">E-NASLOV</th>
      <th class="p-2">NASLOV</th>
      <th class="p-2">POŠTA</th>
      <th class="p-2">TELEFON</th>
      <th class="p-2">ADMIN</th>
    </tr>
  </thead>
  <tbody>
    <!-- tukaj se sprehodimo čez array oglasov in izpisujemo vrstico posameznega oglasa-->
    <?php foreach ($users as $user) { ?>
      <tr>
        <td class="p-2"><?php echo $user->id; ?></td>
        <td class="p-2"><?php echo $user->username; ?></td>
        <td class="p-2"><?php echo $user->password; ?></td>
        <td class="p-2"><?php echo $user->email; ?></td>
        <td class="p-2"><?php echo $user->address; ?></td>
        <td class="p-2"><?php echo $user->postNumber; ?></td>
        <td class="p-2"><?php echo $user->phoneNumber; ?></td>
        <td class="p-2"><?php echo $user->isAdmin; ?></td>

        <td>
          <!-- pri vsakem oglasu dodamo povezavo na akcije show, edit in delete, z idjem oglasa. Uporabnik lahko tako proži novo akcijo s pritiskom na gumb.-->
          <a class="p-2 btn" href='?controller=users&action=show&id=<?php echo $user->id; ?>'><button class="btn btn-light">PRIKAŽI</button></a>
          <a class="p-2" href='?controller=users&action=edit&id=<?php echo $user->id; ?>'><button class="btn btn-light">UREDI</button></a>
          <a class="p-2" href='?controller=users&action=delete&id=<?php echo $user->id; ?>'><button class="btn btn-light">IZBRIŠI</button></a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</div>