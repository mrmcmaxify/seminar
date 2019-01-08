<h4>Benutzeraccounts</h4>
<form class="form-inline" action="<?php echo base_url() . 'admin/search_user'; ?>" method="post">
        <input class="form-control" type="text" name="search" value="" placeholder="Suche E-Mail...">
        <input class="btn btn-default" type="submit" name="filter" value="Go">
    </form>
    </br></br>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail Adresse</th>
      <th scope="col">Benutzerrolle</th>
      <th scope="col">Loginsperre</th>
      <th scope="col">Registriert seit</th>
      <th scope="col">Funktionen</th>

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($user as $users) : ?>
    <tr>
      <th scope="row"> <?php echo $users['E-Mail']; ?> </th>
      <td><?php echo $users['Rolle']; ?></td>
      <td><?php if($users['Loginsperre']=='1'){
        echo 'Nicht gesperrt';
      }
      elseif($users['Loginsperre']=='2'){
        echo 'Gesperrt';
      }
      else{
        echo 'Error';
      }?></td>
      <td><?php echo $users['registriert_am'];?></td>
      <td><a href="<?php echo base_url();?>admin/delete_user_index/<?php echo $users['E-Mail'];?>" class="btn btn-primary" role="button">Löschen</a>
      <a href="<?php echo base_url();?>admin/lock_user/<?php echo $users['E-Mail'];?>" class="btn btn-primary" role="button">Sperren</a>
      <a href="<?php echo base_url();?>admin/unlock_user/<?php echo $users['E-Mail'];?>" class="btn btn-primary" role="button">Entsperren</a></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>