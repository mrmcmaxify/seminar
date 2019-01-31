<h4>Anzulegendes Seminar:</h4>

</br>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminarname</th>
      <th scope="col">Lehrstuhlname</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Soll-Teilnehmerzahl</th>
      <th scope="col">Semester</th>
      <th scope="col">BA/MA</th>
      <th scope="col">Motivationsschreiben notwendig</th>
      

    </tr>
  </thead>
  <tbody>

 

    
    <tr>
      <th scope="row"> <?php echo $seminarname; ?> </th>
      <td><?php echo $lehrstuhlname; ?></td>
      <td><?php echo $beschreibung; ?></td>
      <td><?php echo $sollteilnehmerzahl; ?></td>
      <td><?php echo $semester; ?></td>
      <td><?php echo $BAMA; ?></td>
      <td><?php echo $msnotwendig; ?></td>
      
    </tr>

  </tbody>
</table>
</br>
<?php echo "Das ausgewählte Semester, in dem das Seminar stattfinden soll, befindet sich mehr als zwei Semester in der Zukunft. Trotzdem fortfahren?" ?>
</br>
</br>
<?php echo form_open('lehrstuhl/seminaranlegen2'); ?>
    <input type="hidden" name="seminarname" value="<?php echo $seminarname; ?>">
    <input type="hidden" name="lehrstuhlname" value="<?php echo $lehrstuhlname; ?>">
    <input type="hidden" name="beschreibung" value="<?php echo $beschreibung; ?>">
    <input type="hidden" name="soll-teilnehmerzahl" value="<?php echo $sollteilnehmerzahl; ?>">
    <input type="hidden" name="semester" value="<?php echo $semester; ?>">
    <input type="hidden" name="BA/MA" value="<?php echo $BAMA; ?>">
    <input type="hidden" name="msnotwendig" value="<?php echo $msnotwendig; ?>">
     <button type="submit" class="btn btn-primary">Trotzdem fortfahren</button>
<?php echo form_close(); ?>
      <a href="<?php echo base_url(); ?>lehrstuhl/startseite_anzeigen" class="btn btn-primary" role="button">Abbrechen</a>