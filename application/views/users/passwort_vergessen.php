<?php echo form_open('users/passwort_vergessen'); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center"><?php echo "Passwort vergessen"; ?></h1>
            <div class="form-group">
                <input type="email" name="e-mail" class="form-control" placeholder="E-Mail" required autofocus>
            
            </div>
            <button type="submit" class="btn btn-primary btn-block">Passwort anfordern</button>
        </div>
    </div>


<?php echo form_close(); ?>