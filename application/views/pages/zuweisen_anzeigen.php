<h2>Seminarplatz zuweisen</h2>



<h4> Seminar zuweisen, auf das sich <b><?php echo "$vorname".","."$name" ?></b>  beworben hat: </h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminar</th>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Zuweisen</th>
    </tr>
  </thead>
  <tbody>


    <?php foreach ($beworben as $seminare) : ?>
    <tr>
    <?php echo($seminare['SeminarID']);?>
      <th scope="row"> <?php echo $seminare['SeminarName']; ?> </th>
      <td><?php echo $seminare['LehrstuhlName']; ?></td>
      <td>
      <?php echo form_open('dekan/zuweisen'); ?>
      <input type="hidden" name="E-Mail" value="<?php echo $email; ?>">
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Zuweisen</button>
      <?php echo form_close(); ?>
      </td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<h4><b><?php echo "$vorname".","."$name" ?></b> einen beliebigen Seminarplatz zuweisen: </h4>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminar</th>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Zuweisen</th>
    </tr>
  </thead>
  <tbody>


    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['SeminarName']; ?> </th>
      <td><?php echo $seminare['LehrstuhlName']; ?></td>
      <td>
      <?php echo form_open('dekan/zuweisen'); ?>
      <input type="hidden" name="E-Mail" value="<?php echo $email; ?>">
      <input type="hidden" name="Name" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-primary">Zuweisen</button>
      <?php echo form_close(); ?>
      </td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>