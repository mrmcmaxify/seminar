<h2>Registrierungsdaten ändern</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('student/abschluss_aendern'); ?>
    
        <div class="col-md-4 col-md-offset-4">
            
        <div class="form group">
            <input type="radio" id="ba" name="ba/ma" value="BA" checked>
            <label for="ba"> Bachelor</label> 
            <input type="radio" id="ma" name="ba/ma" value="MA">
            <label for="ma"> Master</label>
        </div>

        <button type="submit" class="btn btn-primary"> Abschluss ändern</button>
    </div>

<?php echo form_close(); ?>

<br>
<?php echo form_open('student/vorname_aendern'); ?>
    
        <div class="col-md-4 col-md-offset-4">
        <div class="form group">
            <label>Vorname</label>
            <input type="text" class="form-control" name="vorname" placeholder="Vorname" value="<?php echo set_value('vorname'); ?>">
        </div>
</br>
        <button type="submit" class="btn btn-primary">Vorname ändern</button>
    </div>
<?php echo form_close(); ?>


<?php echo form_open('student/nachname_aendern'); ?>
    
        <div class="col-md-4 col-md-offset-4">
        <div class="form group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo set_value('name'); ?>">
        </div>
        </br>
        <button type="submit" class="btn btn-primary">Nachname ändern</button>


    </div>
<?php echo form_close(); ?>

