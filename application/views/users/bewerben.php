<h2>Bewerben</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/bewerben'); ?>
    
    <div class="row">
        
            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>E-Mail:</label>
                    <input type="email" class="form-control" name="e-mail" placeholder="E-Mail-Adresse">
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
                    <label>Matrikelnummer</label>
                    <input type="text" class="form-control" name="name" placeholder="Matrikelnummer">
                </div>
                <div class="form group">
                    <label>Fachsemester</label>
                    <input type="text" class="form-control" name="fachsemester" placeholder="Fachsemester">
                </div>
                <div class="form group">
                    <label>ECTS</label>
                    <input type="text" class="form-control" name="ects" placeholder="ECTS">
                </div>
                <div class="form group">
                    <label>HisQis-Auszug</label>
                    <input type="text" class="form-control" name="hisqis" placeholder="HisQis">
                </div>
                <div class="form group">
                    <label>Motivationsschreiben</label>
                    <input type="text" class="form-control" name="hisqis" placeholder="Motivationsschreiben">
                </div>
                </br>
                <button type="submit" class="btn btn-primary">Bewerben</button>
                

            </div>
        
        </div>
    <?php echo form_close(); ?>
