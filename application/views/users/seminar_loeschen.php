<h4>Angelegte Seminare</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminarname</th>
      <th scope="col">Seminar-ID</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Löschen</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['SeminarName']; ?> </th>
      <td><?php echo $seminare['SeminarID']; ?></td>
      <td><?php echo $seminare['Beschreibung']; ?></td>

      <td>
      <?php echo form_open('lehrstuhl/seminar_loeschen'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Löschen</button>
      <?php echo form_close(); ?>
      </td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
