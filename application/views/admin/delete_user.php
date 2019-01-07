<div class="alert alert-danger" role="alert">
  Wollen Sie den Benutzer mit der E-Mail "<?php echo $email?>" wirklich löschen?
</div>
<div class="form-group">
    <a href="<?php echo base_url().'admin/search_user'?>" class="btn btn-primary" role="button">Abbrechen</a>
    <a href="<?php echo base_url();?>admin/delete_user/<?php echo $email;?>" class="btn btn-primary" role="button">Benutzer Löschen</a>
</div>
