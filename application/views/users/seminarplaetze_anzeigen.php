<h4>Alle zugewiesenen Studenten</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail-Adresse des Studenten</th>
      <th scope="col">Seminar-ID</th>

      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminarzuteilung as $seminarzuteilungen) : ?>
    <tr>
      <th scope="row"> <?php echo $seminarzuteilungen['E-Mail']; ?> </th>
      <td><?php echo $seminarzuteilungen['SeminarID']; ?></td>

   
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
