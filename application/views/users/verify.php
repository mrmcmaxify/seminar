<?php
$data['title']= 'verify';
            $email=$_GET['email'];
            $hash=$_GET['hash'];

            
?>

<strong>Sie können nun ihre E-Mail Adresse verifizieren:</strong> 

<?php echo form_open_multipart('users/verify1'); ?>
<input type="hidden" name="Hash" value="<?php echo $hash; ?>">
<input type="hidden" name="Email" value="<?php echo $email; ?>">
        <div class="col-md-4 col-md-offset-4">
</br>
        <button type="submit" class="btn btn-primary">Verifizieren</button>
    </div>

<?php echo form_close(); ?>