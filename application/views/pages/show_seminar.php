<h3> <b><?php echo $seminar[0]['SeminarName']?></b> </h3>
<p><b>Lehrstuhl:</b><?php echo $seminar[0]['LehrstuhlName']?></p>
<p><b>Seminarname:</b><?php echo $seminar[0]['SeminarName']?></p>
<p><b>Detailbeschreibung:</b><?php echo $seminar[0]['Beschreibung']?></p>
<p><b>Bisherige Teilnehmerzahl:</b><?php echo $seminar[0]['Ist-Teilnehmerzahl']?>/<?php echo $seminar[0]['Soll-Teilnehmerzahl']?></p>




<?php echo form_open_multipart('users/goback'); ?>
<button type="submit" class="btn btn-primary" >Zurück</button>
<?php echo form_close(); ?>