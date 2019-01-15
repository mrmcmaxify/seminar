<h4>Aktuell angelegte Semester</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Semester</th>
      <th scope="col">Anfang</th>
      <th scope="col">Ende</th>
      <th scope="col">Funktion</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($semester as $semes) : ?>
    <tr>
      <th scope="row"> <?php echo $semes['bezeichnung']; ?> </th>
      <td><?php echo $semes['anfang']; ?></td>
      <td><?php echo $semes['ende']; ?></td>
      <td>
      <?php echo form_open('admin/delete_semester_index'); ?>
      <input type="hidden" name="bezeichnung" value="<?php echo $semes['bezeichnung']; ?>">
      <button type="submit" class="btn btn-primary">Löschen</button>
      <?php echo form_close(); ?>
      </td>
      
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<h4>Neues Semester anlegen:</h4>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('admin/semester_edit'); ?>      
    
        <label>Semester</label>
        <input type="text" name="bezeichnung" value="<?php echo set_value('Bezeichnung'); ?>">
        <input type="date" name="anfang" value="<?php echo set_value('Anfang'); ?>">
        <input type="date" name="ende" value="<?php echo set_value('Ende'); ?>">
        <br>
        
       
   

    <button type="submit" class="btn btn-primary">Anlegen</button>
   
<?php echo form_close(); ?>


