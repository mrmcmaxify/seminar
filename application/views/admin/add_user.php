<h2>Benutzer hinzufügen</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('admin/add_user'); ?>    
    <div class="row">
        
            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>E-Mail:</label>
                    <input type="email" class="form-control" name="e-mail" placeholder="E-Mail-Adresse" value="<?php echo set_value('e-mail'); ?>">
                </div>
                <div class="form group">
                    <label>Passwort</label>
                    <input type="password" class="form-control" name="password" placeholder="Passwort" value="<?php echo set_value('password'); ?>">
                </div>
                <div class="form group">
                    <label>Passwort wiederholen</label>
                    <input type="password" class="form-control" name="password2" placeholder="Passwort wiederholen" value="<?php echo set_value('password2'); ?>">
                </div>
                <div class="form group">
                    <label>Vorname</label>
                    <input type="text" class="form-control" name="vorname" placeholder="Vorname" value="<?php echo set_value('vorname'); ?>">
                </div>
                <div class="form group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo set_value('name'); ?>">
                </div>
                </br>
                <div class="form group">
                <input type="radio" id="dekan" name="rolle" value="dekan" checked>
                <label for="dekan"> Dekan-Benutzer</label> 
                <input type="radio" id="lehrstuhl" name="rolle" value="lehrstuhl">
                <label for="ma"> Lehrstuhl-Benutzer</label>
                </div>
                </br>
                <div class="form group">
                <input type="radio" id="noinhaber" name="inhaber" value="2" checked>
                <label for="noinhaber"> Mitarbeiter</label> 
                <input type="radio" id="inhaber" name="inhaber" value="1">
                <label for="ma"> Inhaber</label>
                </div>
                </br>
                <div class="form group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="lehrstuhlname" placeholder="Lehrstuhlname (Wenn Lehrstuhl-Benutzer)" value="<?php echo set_value('lehrstuhlname'); ?>">
                </div>
                </br>
                <button type="submit" class="btn btn-primary">Benutzer anlegen</button>


            </div>
        
    </div>
<?php echo form_close(); ?>