
<h3> <b><?php echo $seminar[0]['SeminarName']?></b> </h3>
<p><b>Lehrstuhl:</b><?php echo $seminar[0]['LehrstuhlName']?></p>
<p><b>Seminarname:</b><?php echo $seminar[0]['SeminarName']?></p>
<p><b>Detailbeschreibung:</b><?php echo $seminar[0]['Beschreibung']?></p>
<p><b>Bisherige Teilnehmerzahl:</b><?php echo $seminar[0]['Ist-Teilnehmerzahl']?>/<?php echo $seminar[0]['Soll-Teilnehmerzahl']?></p>

</br>

<?php echo validation_errors(); ?>

<?php echo form_open('student/bewerbung_hinzufuegen1'); ?>
    
    <div class="row">
        
            <div class="col-md-4 col-md-offset-4">


                <?php if ($seminar[0]['MSNotwendig'] === '1'): ?>
                <div class="form group">
                    <label>Motivationsschreiben</label>
                    <input type="file"  name="ms" size="20">
                </div>
                <?php endif; ?>
                </br>
                <input type="hidden" name="SeminarID" value="<?php echo $seminar[0]['SeminarID']; ?>">
                <input type="hidden" name="MSNotwendig" value="<?php echo $seminar[0]['MSNotwendig']; ?>">
                <input type="hidden" name="Beschreibung" value="<?php echo $seminar[0]['Beschreibung']; ?>">

                <button type="submit" class="btn btn-primary">Bewerben</button>
                


            </div>
        
        </div>
    <?php echo form_close(); ?>

    <?php echo form_open_multipart('student/startseite_student'); ?>
                <button type="submit" class="btn btn-primary" >Zurück</button>
                <?php echo form_close(); ?>
