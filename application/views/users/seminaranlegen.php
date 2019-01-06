<h2>Seminar anlegen</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/seminaranlegen'); ?>
    
    <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>Name des Seminars</label>
                    <input type="text" class="form-control" name="seminarname" placeholder="Seminarname">
                </div>
                </br>
                <div class="form group">
                    <label>Name des Lehrstuhls</label>
                    <input type="text" class="form-control" name="lehrstuhlname" placeholder="Lehrstuhlname">
                </div>
                </br>
                <div class="form group">
                    <label>Seminarbeschreibung</label>
                    <input type="text" class="form-control" name="beschreibung" placeholder="Seminarbeschreibung">
                </div>
                </br>
                <div class="form group">
                    <label>Teilnehmeranzahl</label>
                    <input type="text" class="form-control" name="soll-teilnehmerzahl" placeholder="Teilnehmeranzahl">
                </div>
                </br>
                <div class="form group">
                    <label>Motivationsschreiben notwendig?</label>
                <input type="radio" id="ja" name="msnotwendig" value="ja" checked>
                <label for="ja"> Ja</label> 
                <input type="radio" id="nein" name="msnotwendig" value="nein">
                <label for="nein"> Nein</label>
                </div>
                </br>
                <div class="form group">
                    <label>Angebotenes Semester</label>
                    <input type="text" class="form-control" name="semester" placeholder="Semester">
                </div>
                </br>
                <div class="form group">
                <input type="radio" id="BA" name="BA/MA" value="BA" checked>
                <label for="BA"> Bachelorseminar</label> 
                <input type="radio" id="MA" name="BA/MA" value="MA">
                <label for="MA"> Masterseminar</label>
                </div>
                
                
                </br>
                <button type="submit" class="btn btn-primary">Seminar anlegen</button>


            </div>
        
    </div>
<?php echo form_close(); ?>