<h4>Benutzeraccounts</h4>
<form class="form-inline" action="<?php echo base_url() . 'admin/search_log'; ?>" method="post">
        <input class="form-control" type="text" name="search" value="" placeholder="Suche E-Mail...">
        <input class="btn btn-default" type="submit" name="filter" value="Go">
    </form>
    </br></br>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail Adresse</th>
      <th scope="col">Event-ID</th>
      <th scope="col">Aktion</th>
      <th scope="col">Seminar</th>
      <th scope="col">Zeitstempel</th>

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($log as $logs) : ?>
    <tr>
      <th scope="row"> <?php echo $logs['E-Mail']; ?> </th>
      <td><?php echo $logs['Event-id']; ?></td>
      <td><?php echo $logs['Aktion'];?></td>
      <td><?php echo $logs['Seminargit'];?></td>
      <td><?php echo $logs['Zeitpunkt'];?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>