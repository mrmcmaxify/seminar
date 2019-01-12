<h2>Bewerben</h2>


<?php echo $beschreibung; ?>
<?php echo $seminarid; ?>


</br>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('student/bewerbung_hinzufuegen'); ?>
    
    <div class="row">
        
            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>E-Mail:</label>
                    <input type="email" class="form-control" name="e-mail" placeholder="E-Mail-Adresse" value="<?php echo set_value('e-mail'); ?>">
                </div>
                <?php if ($msnotwendig === 1): ?>
                <div class="form group">
                    <label>Motivationsschreiben</label>
                    <input type="file"  name="ms" size="20">
                </div>
                <?php endif; ?>
                </br>
                <button type="submit" class="btn btn-primary">Bewerben</button>
                

            </div>
        
        </div>
    <?php echo form_close(); ?>
