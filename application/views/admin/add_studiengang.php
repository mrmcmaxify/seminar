<h4>Aktuell angelegte Studiengänge</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Studiengang</th>
      <th scope="col">Aktionen</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($studiengang as $stud) : ?>
    <tr>
      <th scope="row"> <?php echo $stud['Name']; ?> </th>
      <th>
      <?php echo form_open('admin/delete_studiengang_index'); ?>
      <input type="hidden" name="bezeichnung" value="<?php echo $stud['Name']; ?>">
      <button type="submit" class="btn btn-primary">Löschen</button>
      <?php echo form_close(); ?>
      </th>
      
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<h4>Neuen Studiengang anlegen:</h4>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('admin/studiengang_edit'); ?>      
    
        <label>Semester</label>
        <input type="text" name="bezeichnung" value="<?php echo set_value('Bezeichnung'); ?>">
        
        
        <br>
        
       
   

    <button type="submit" class="btn btn-primary">Anlegen</button>
   
<?php echo form_close(); ?>


