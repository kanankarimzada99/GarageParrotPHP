<?php
require_once __DIR__."/../templates/header-admin.php";
?>
<div class="wrapper">
  <!-- connection  -->
  <section class="connection">
    <div class="connection-header">
      <h2 class="header-titles">Liste Employés</h2>
      <a href="add-employee.php" class="btn  btn-fill">Ajouter</a>
    </div>

    <div class="connection-wrapper wrapper">
      <div class="connection-table">
        <table>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Password</th>
            <th>Action</th>
          </tr>
          <tr>
            <td>Alfred</td>
            <td>Anders</td>
            <td>andresd@sdf.ff</td>
            <td>asdf234sdf</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfred</td>
            <td>Anders</td>
            <td>andresd@sdf.ff</td>
            <td>asdf234sdf</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfred</td>
            <td>Anders</td>
            <td>andresd@sdf.ff</td>
            <td>asdf234sdf</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfred</td>
            <td>Anders</td>
            <td>andresd@sdf.ff</td>
            <td>asdf234sdf</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
          <tr>
            <td>Alfred</td>
            <td>Anders</td>
            <td>andresd@sdf.ff</td>
            <td>asdf234sdf</td>
            <td>
              <a href=""><i class="fa-solid fa-pencil"></i></a>
              <a href="#"><i class="fa-solid fa-trash-can"></i></a>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </section>
  <!-- END connection  -->
</div>
<?php
require_once __DIR__."/../templates/footer-admin.php";
?>