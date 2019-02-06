
<h4>In aktueller Phase zugewiesene Studenten</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail-Adresse des Studenten</th>
      <th scope="col">Seminar-ID</th>
      <th scope="col">Löschen</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminarzuteilung as $seminarzuteilungen) : ?>
    <tr>
      <th scope="row"> <?php echo $seminarzuteilungen['E-Mail']; ?> </th>
      <td><?php echo $seminarzuteilungen['SeminarID']; ?></td>

      <td>
      <?php echo form_open('lehrstuhl/loeschen'); ?>
      <input type="hidden" name="E-Mail" value="<?php echo $seminarzuteilungen['E-Mail'] ?>">
      <input type="hidden" name="SeminarID" value="<?php echo $seminarzuteilungen['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Löschen</button>
      <?php echo form_close(); ?>
      </td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
