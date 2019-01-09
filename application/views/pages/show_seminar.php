<h3> <b><?php echo $seminar[0]['SeminarName']?></b> </h3>
<p><b>Lehrstuhl:</b><?php echo $seminar[0]['LehrstuhlName']?></p>
<p><b>Seminarname:</b><?php echo $seminar[0]['SeminarName']?></p>
<p><b>Detailbeschreibung:</b><?php echo $seminar[0]['Beschreibung']?></p>
<p><b>Bisherige Teilnehmerzahl:</b><?php echo $seminar[0]['Ist-Teilnehmerzahl']?>/<?php echo $seminar[0]['Soll-Teilnehmerzahl']?></p>


<button type="button" class="btn btn-primary" onClick="history.go(-1);return true;">Zurück</button>
