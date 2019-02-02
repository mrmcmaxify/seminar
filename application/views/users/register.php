<h2>Registrieren</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('users/register'); ?>    
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
                <label>Studiengang</label>
                <select class="form-control" name="studiengang">
                        <?php foreach($studiengang as $studie){ ?>
                            <option value="<?php echo $studie['Name']; ?>"><?php echo $studie['Name']; ?></option>';
                        <?php } ?>
                 </select>
                </br>
                <div class="form group">
                    <label>Fachsemester</label>
                    <input type="text" class="form-control" name="fachsemester" placeholder="Fachsemester" value="<?php echo set_value('fachsemester'); ?>">
                </div>
                </br>
                <div class="form group">
                <input type="radio" id="ba" name="ba/ma" value="BA" checked>
                <label for="ba"> Bachelor</label> 
                <input type="radio" id="ma" name="ba/ma" value="MA">
                <label for="ma"> Master</label>
                </div>
                <div class="form group">
                    <label>ECTS</label>
                    <input type="text" class="form-control" name="ects" placeholder="ECTS" value="<?php echo set_value('ects'); ?>">
                </div>
                <div class="form group">
                    <label>HisQis-Auszug (max. 2MB)</label>
                    <input type="file"  name="hisqis" size="20">
                </div>
                </br>
                <button type="submit" class="btn btn-primary">Registrieren</button>


            </div>
        
    </div>
<?php echo form_close(); ?>