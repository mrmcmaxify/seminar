<div class="alert alert-danger" role="alert">
  Wollen Sie den Benutzer mit der E-Mail "<?php echo $email?>" wirklich löschen?
</div>
<div class="form-group">
    <a href="<?php echo base_url().'admin/search_user'?>" class="btn btn-primary" role="button">Abbrechen</a>
    <a>
    <?php echo form_open('admin/delete_user'); ?>
      <input type="hidden" name="email" value="<?php echo $email; ?>">
      <button type="submit" class="btn btn-primary">Benutzer Löschen</button>
      <?php echo form_close(); ?>
      </a>
</div>
