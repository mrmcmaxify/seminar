<h4>Statistiken</h4>
<a href="<?php echo base_url(); ?>dekan/csv_seminare" class="btn btn-primary" role="button">Download Statistik Seminare </a>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminar-ID</th>
      <th scope="col">Seminarname</th>
      <th scope="col">Lehrstuhlname</th>
      <th scope="col">Ist-Teilnehmerzahl</th>
      <th scope="col">Soll-Teilnehmerzahl</th>
      <th scope="col">Semester</th>
      <th scope="col">BA/MA</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($statistiken as $statistik) : ?>
    <tr>
      <th scope="row"> <?php echo $statistik['SeminarID']; ?> </th>
      <td><?php echo $statistik['SeminarName']; ?></td>
      <td><?php echo $statistik['LehrstuhlName']; ?></td>
      <td><?php echo $statistik['Ist_Teilnehmerzahl']; ?></td>
      <td><?php echo $statistik['Soll_Teilnehmerzahl']; ?></td>
      <td><?php echo $statistik['Semester']; ?></td>
      <td><?php echo $statistik['BA/MA']; ?></td>
     

     
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<br/>
<h4>Statistiken Master-Studenten ohne Seminarplatz</h4>
<a href="<?php echo base_url(); ?>dekan/csv_studenten_ma" class="btn btn-primary" role="button">Download Statistik Masterstudenten </a>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Semester</th>
      <th scope="col">Anzahl Masterstudenten ohne Seminar</th>

      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($statistiken_ma as $statistik_ma) : ?>
    <tr>
      <th scope="row"> <?php echo $statistik_ma['semester']; ?> </th>
      <td><?php echo $statistik_ma['kein_seminar']; ?></td>

     

     
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<br/>
<br/>
<h4>Statistiken Master-Studenten ohne Seminarplatz</h4>
<a href="<?php echo base_url(); ?>dekan/csv_studenten_ba" class="btn btn-primary" role="button">Download Statistik Bachelorstudenten </a>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Semester</th>
      <th scope="col">Anzahl Bachelorstudenten ohne Seminar</th>

      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($statistiken_ba as $statistik_ba) : ?>
    <tr>
      <th scope="row"> <?php echo $statistik_ba['semester']; ?> </th>
      <td><?php echo $statistik_ba['kein_seminar']; ?></td>

     

     
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

