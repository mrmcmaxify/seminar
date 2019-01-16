<h2>Startseite Lehrstuhl</h2>
<h4>Angelegte Seminare</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminarname</th>
      <th scope="col">Seminar-ID</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Teilnehmer</th>
      <th scope="col">maximale Teilnehmeranzahl</th>
      <th scope="col"></th>
      <th scope="col"></th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['SeminarName']; ?> </th>
      <td><?php echo $seminare['SeminarID']; ?></td>
      <td><?php echo $seminare['Beschreibung']; ?></td>
      <td><?php echo $seminare['Ist-Teilnehmerzahl']; ?></td>
      <td><?php echo $seminare['Soll-Teilnehmerzahl']; ?></td>

      <td>
      <?php echo form_open('lehrstuhl/seminarpflege_anzeigen'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Seminar pflegen</button>
      <?php echo form_close(); ?>
      </td>
      <td>
      <?php echo form_open('lehrstuhl/verteilen_anzeigen'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Teilnehmer verwalten</button>
      <?php echo form_close(); ?>
      </td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
