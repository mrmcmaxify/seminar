
<h4>Verfügbare Seminare:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Teilnehmer</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['Ist-Teilnehmerzahl']." / ".$seminare['Soll-Teilnehmerzahl']; ?></td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

</br></br>



<h4>Fristen der Seminarvergabe:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Frist</th>
      <th scope="col">Von</th>
      <th scope="col">Bis</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($fristen as $frist) : ?>
    <tr>
      <th scope="row"> <?php echo $frist['Name']; ?> </th>
      <td><?php echo $frist['Von']; ?></td>
      <td><?php echo $frist['Bis']; ?></td>
      
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

