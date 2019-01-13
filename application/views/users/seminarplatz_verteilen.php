<?php // var_dump($lehrstuhl); ?>


<h4>Bewerbungen</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail-Adresse des Studenten</th>
      <th scope="col">Seminar-ID</th>
      <th scope="col">Motivationsschreiben</th>
      <th scope="col">Fachsemester</th>
      <th scope="col">BA/MA</th>
      <th scope="col">ECTS</th>
      <th scope="col">HisQis</th>
      <th scope="col">Zuweisen</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminarbewerbung as $seminarbewerbungen) : ?>
    <tr>
      <th scope="row"> <?php echo $seminarbewerbungen['E-Mail']; ?> </th>
      <td><?php echo $seminarbewerbungen['SeminarID']; ?></td>
      <td><?php echo $seminarbewerbungen['MS']; ?></td>
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
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>





