
<h4>Verfügbare Seminare:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Bachelor/Master</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Bewerbung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
     foreach ($seminar as $seminare) : 
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['BA/MA']; ?></td>
        <td>
        <?php echo form_open('student/seminar_info'); ?>
      <input type="hidden" name="Beschreibung" value="<?php echo $seminare['Beschreibung']; ?>">
      <button type="submit" class="btn btn-success">Beschreibung</button>
      <?php echo form_close(); ?>
        </td>
      <td>
      <?php echo form_open('student/bewerbung_hinzufuegen'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <input type="hidden" name="Beschreibung" value="<?php echo $seminare['Beschreibung']; ?>">
      <input type="hidden" name="MSNotwendig" value="<?php echo $seminare['MSNotwendig']; ?>">
      <button type="submit" class="btn btn-success">Bewerbung</button>
      <?php echo form_close(); ?>
      </td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>

</br></br>



<h4>Angemeldete Seminare:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Bachelor/Master</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Abmeldung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
     foreach ($seminar as $seminare) : 
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['BA/MA']; ?></td>
        <td>
          <form action="" method="post">
            <input type="submit" class="btn btn-success" name="ausfuehren" value="Beschreibung"/>
         </form> 
        </td>
      <td><a href="users/bewerben"><button type="button" class="btn btn-success">Abmeldung</button></a></td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>

</br></br>

<h4>Zusagen:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Bachelor/Master</th>
      <th scope="col">Zusage</th>
      <th scope="col">Ablehnung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
     foreach ($seminar as $seminare) : 
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['BA/MA']; ?></td>
        <td>
          <form action="" method="post">
            <input type="submit" class="btn btn-success" name="ausfuehren" value="Zusage"/>
         </form> 
        </td>
      <td><a href="users/bewerben"><button type="button" class="btn btn-success">Ablehnung</button></a></td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>

</br></br>





          



