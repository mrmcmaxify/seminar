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
    <form>
    <select>
        <option selected="selected">Auswählen</option>
        
        
        
        <?php foreach ($frist as $item) : ?>
        <option value="1"><?php echo "1"; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Submit">
    </form>
<?php echo form_close(); ?>

<?php var_dump($frist); ?>
