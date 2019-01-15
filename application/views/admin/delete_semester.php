<div class="alert alert-danger" role="alert">
  Wollen Sie das Semester "<?php echo $bezeichnung;?>" wirklich löschen?
</div>
<div class="form-group">
    <a href="<?php echo base_url().'admin/semesterzeiten_anzeigen'?>" class="btn btn-primary" role="button">Abbrechen</a>
    <a>
      <?php echo form_open('admin/delete_semester'); ?>
      <input type="hidden" name="bezeichnung" value="<?php echo $bezeichnung; ?>">
      <button type="submit" class="btn btn-primary">Semester Löschen</button>
      <?php echo form_close(); ?>
      </a>
</div>