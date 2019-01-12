<h2>Lehrstuhl-Mitarbeiter hinzufügen</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('lehrstuhl/addstaff'); ?>
    
    <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>E-Mail:</label>
                    <input type="email" class="form-control" name="e-mail" placeholder="E-Mail-Adresse">
                </div>
                <div class="form group">
                    <label>Passwort</label>
                    <input type="password" class="form-control" name="password" placeholder="Passwort">
                </div>
                <div class="form group">
                    <label>Passwort wiederholen</label>
                    <input type="password" class="form-control" name="password2" placeholder="Passwort wiederholen">
                </div>
                <div class="form group">
                    <label>Vorname</label>
                    <input type="text" class="form-control" name="vorname" placeholder="Vorname">
                </div>
                <div class="form group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name">
                </div>
                <div class="form group">
                    <label>Name des Lehrstuhls</label>
                    <input type="text" class="form-control" name="lehrstuhlname" placeholder="LehrstuhlName">
                </div>
                
                </br>
                <button type="submit" class="btn btn-primary">Mitarbeiter hinzufügen</button>


            </div>
        
    </div>
<?php echo form_close(); ?>