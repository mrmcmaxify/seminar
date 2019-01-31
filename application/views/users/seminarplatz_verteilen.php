
<h4>Bewerbungen</h4>
<a href="<?php echo base_url(); ?>lehrstuhl/csv" class="btn btn-primary" role="button">Download Teilnehmerliste aller Seminare</a>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail-Adresse</th>
      <th scope="col">Name des Studenten</th>
      <th scope="col">SeminarID</th>
      <th scope="col">Seminarname</th>
      <th scope="col">Fachsemester</th>
      <th scope="col">BA/MA</th>
      <th scope="col">ECTS</th>
      <th scope="col">HisQis</th>
      <th scope="col">Zuweisen</th>
      <th scope="col">MS (falls gefordert)</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminarbewerbung as $seminarbewerbungen) : ?>
    <tr>
      <th scope="row"> <?php echo $seminarbewerbungen['E-Mail']; ?> </th>
      <td><?php echo $seminarbewerbungen['Name'];
      echo " ";
      echo $seminarbewerbungen['Vorname']; ?></td>
      <td><?php echo $seminarbewerbungen['SeminarID']; ?></td>
      <td><?php echo $seminarbewerbungen['SeminarName']; ?></td>
      <td><?php echo $seminarbewerbungen['Fachsemester']; ?></td>
      <td><?php echo $seminarbewerbungen['BA/MA']; ?></td>
      <td><?php echo $seminarbewerbungen['ECTS']; ?></td>
      <td><a class="btn btn-default pull-left" href="<?php echo base_url(); ?>users/download/<?php echo $seminarbewerbungen['HisQis']; ?>">Download</a></td>
      <td>
      <?php echo form_open('lehrstuhl/verteilen'); ?>
      <input type="hidden" name="E-Mail" value="<?php echo $seminarbewerbungen['E-Mail'] ?>">
      <input type="hidden" name="SeminarID" value="<?php echo $seminarbewerbungen['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Zuweisen</button>
      <?php echo form_close(); ?>
      </td>
      <?php if ($seminarbewerbungen['MSnotwendig'] == 1) {?>
      <td><a class="btn btn-default pull-left" href="<?php echo base_url(); ?>users/download/<?php echo $seminarbewerbungen['MS']; ?>">Download</a></td> <?php } ?>
  
     
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>





