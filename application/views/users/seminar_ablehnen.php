<?php echo "Wollen Sie dieses Seminar wirklich ablehnen? " ?>
<h3> <b><?php// echo $beschreibung;?></b> </h3>
</br>
</br>


<?php echo form_open('student/seminar_ablehnen1'); ?>
    
    
        
            <div class="col-md-4 col-md-offset-4">
            <input type="hidden" name="SeminarID" value="<?php echo $seminarid; ?>">
            <input type="hidden" name="MSNotwendig" value="<?php echo $msnotwendig; ?>">
            <input type="hidden" name="Beschreibung" value="<?php echo $beschreibung; ?>">
            <button type="submit" class="btn btn-primary">Ja</button>
            </div>
        
        
    <?php echo form_close(); ?>




<a href="<?php echo base_url(); ?>student/startseite_student" class="btn btn-primary" role="button">Zurück</a>