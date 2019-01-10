<h4>Aktuelle Zeiträume:</h4>
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

<h4>Zeiträume aktualisieren/festlegen:</h4>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('users/register'); ?>      
    
        <label>Anmeldephase</label>
        <input type="date" name="Von1" value="<?php echo set_value('Von1'); ?>">
        <input type="date" name="Bis1" value="<?php echo set_value('Bis1'); ?>">
        <br>
        <label>1. Auswahlphase</label>
        <input type="date" name="Von2" value="<?php echo set_value('Von2'); ?>">
        <input type="date" name="Bis2" value="<?php echo set_value('Bis2'); ?>">
        <br>
        <label>1. Annahme-/Rücktrittsphase</label>
        <input type="date" name="Von3" value="<?php echo set_value('Von3'); ?>">
        <input type="date" name="Bis3" value="<?php echo set_value('Bis3'); ?>">
        <br>
        <label>2. Auswahlphase</label>
        <input type="date" name="Von4" value="<?php echo set_value('Von4'); ?>">
        <input type="date" name="Bis4" value="<?php echo set_value('Bis4'); ?>">
        <br>
        <label>2. Annahme-/Rücktrittsphase</label>
        <input type="date" name="Von5" value="<?php echo set_value('Von5'); ?>">
        <input type="date" name="Bis5" value="<?php echo set_value('Bis5'); ?>">
        <br>
        <label>Zuteilungsphase</label>
        <input type="date" name="Von6" value="<?php echo set_value('Von6'); ?>">
        <input type="date" name="Bis6" value="<?php echo set_value('Bis6'); ?>">
        <br>
       
   

    <button type="submit" class="btn btn-primary">Festlegen</button>
   
<?php echo form_close(); ?>


