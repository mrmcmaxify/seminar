<h2>Passwort ändern</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/changepw'); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center"><?php echo "Passwort ändern"; ?></h1>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Aktuelles Passwort" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="newpassword" class="form-control" placeholder="Neues Passwort" required>
            </div>
            <div class="form-group">
                <input type="password" name="confpassword" class="form-control" placeholder="Neues Passwort wiederholen" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Passwort ändern</button>
        </div>
    </div>
<?php echo form_close(); ?>