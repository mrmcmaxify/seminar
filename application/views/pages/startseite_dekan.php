<h4>Angebotene Seminare:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Teilnehmer</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['Beschreibung']; ?></td>
      <td><?php echo $seminare['Ist-Teilnehmerzahl']." / ".$seminare['Soll-Teilnehmerzahl']; ?></td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<h4>Bachelor Studenten ohne Seminarplatz:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail</th>
      <th scope="col">Fachsemester</th>
      <th scope="col">HisQis</th>
      <th scope="col">ECTS</th>
      <th scope="col">Zuteilen1</th>
      <th scope="col">Zuteilen2</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($ba_ohne as $studenten) : ?>
    <tr>
      <th scope="row"> <?php echo $studenten['E-Mail']; ?> </th>
      <td><?php echo $studenten['Fachsemester']; ?></td>
      <td><?php echo $studenten['HisQis']; ?></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<h4>Master Studenten ohne Seminarplatz:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail</th>
      <th scope="col">Fachsemester</th>
      <th scope="col">HisQis</th>
      <th scope="col">ECTS</th>
      <th scope="col">Zuteilen1</th>
      <th scope="col">Zuteilen2</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($ma_ohne as $studenten) : ?>
    <tr>
      <th scope="row"> <?php echo $studenten['E-Mail']; ?> </th>
      <td><?php echo $studenten['Fachsemester']; ?></td>
      <td><a class="btn btn-default pull-left" href="<?php echo base_url(); ?>posts/edit/<?php echo $studenten['HisQis']; ?>">Download</a></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>