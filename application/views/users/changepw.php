<h2>Passwort ändern</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/changepw'); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center"><?php echo "Einloggen"; ?></h1>
            <div class="form-group">
                <input type="email" name="e-mail" class="form-control" placeholder="E-Mail" required autofocus>
            
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Passwort" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
        </div>
    </div>
<?php echo form_close(); ?>