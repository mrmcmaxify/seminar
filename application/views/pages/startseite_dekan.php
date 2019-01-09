<h4>Angebotene Seminare:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">BA/MA</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Teilnehmer</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['BA/MA']; ?></td>
      <td>
      <?php echo form_open('dekan/show_seminar'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Beschreibung</button>
      <?php echo form_close(); ?>
      </td>
      <td><?php echo $seminare['Ist-Teilnehmerzahl']." / ".$seminare['Soll-Teilnehmerzahl']; ?></td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<!-- Zeigt Einträge aus Student mit BA/MA=ba und #Annahmen=0 -->

<h4>Bachelor Studenten ohne Seminarplatz:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail</th>
      <th scope="col">Name</th>
      <th scope="col">Vorname</th>
      <th scope="col">Fachsemester</th>
      <th scope="col">HisQis</th>
      <th scope="col">ECTS</th>
      <th scope="col">Seminarplatz zuweisen</th>
      
      

    </tr>
  </thead>
  <tbody>


    <?php foreach ($ba_ohne as $studenten) : ?>
    <tr>
      <th scope="row"> <?php echo $studenten['E-Mail']; ?> </th>
      <td><?php echo $studenten['Name']; ?></td>
      <td><?php echo $studenten['Vorname']; ?></td>
      <td><?php echo $studenten['Fachsemester']; ?></td>
      <td><a class="btn btn-default pull-left" href="<?php echo base_url(); ?>users/download/<?php echo $studenten['HisQis']; ?>">Download</a></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      <td>
      <?php echo form_open('dekan/zuweisen_anzeigen'); ?>
      <input type="hidden" name="E-Mail" value="<?php echo $studenten['E-Mail']; ?>">
      <input type="hidden" name="Name" value="<?php echo $studenten['Name']; ?>">
      <input type="hidden" name="Vorname" value="<?php echo $studenten['Vorname']; ?>">
      <input type="hidden" name="BA/MA" value="<?php echo $studenten['BA/MA']; ?>">
      <button type="submit" class="btn btn-primary">Seminar auswählen</button>
      <?php echo form_close(); ?>
      </td>
      
      
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Zeigt Einträge aus Student mit BA/MA=ma und #Annahmen=0 -->

<h4>Master Studenten ohne Seminarplatz:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">E-Mail</th>
      <th scope="col">Name</th>
      <th scope="col">Vorname</th>
      <th scope="col">Fachsemester</th>
      <th scope="col">HisQis</th>
      <th scope="col">ECTS</th>
      <th scope="col">Seminarplatz zuweisen</th>
      
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($ma_ohne as $studenten) : ?>
    <tr>
      <th scope="row"> <?php echo $studenten['E-Mail']; ?> </th>
      <td><?php echo $studenten['Name']; ?></td>
      <td><?php echo $studenten['Vorname']; ?></td>
      <td><?php echo $studenten['Fachsemester']; ?></td>
     
      <td><a class="btn btn-default pull-left" href="<?php echo base_url(); ?>users/download/<?php echo $studenten['HisQis']; ?>">Download</a></td>
      <td><?php echo $studenten['ECTS']; ?></td>
      <td>
      <?php echo form_open('dekan/zuweisen_anzeigen'); ?>
      <input type="hidden" name="E-Mail" value="<?php echo $studenten['E-Mail']; ?>">
      <input type="hidden" name="Name" value="<?php echo $studenten['Name']; ?>">
      <input type="hidden" name="Vorname" value="<?php echo $studenten['Vorname']; ?>">
      <input type="hidden" name="BA/MA" value="<?php echo $studenten['BA/MA']; ?>">
      <button type="submit" class="btn btn-primary">Seminar auswählen</button>
      <?php echo form_close(); ?>
      </td>      
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>