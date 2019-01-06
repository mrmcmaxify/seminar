<h2>Seminar anlegen</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/addseminar'); ?>
    
    <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>Name des Seminars</label>
                    <input type="text" class="form-control" name="seminarname" placeholder="Seminarname">
                </div>
                <div class="form group">
                    <label>Name des Lehrstuhls</label>
                    <input type="text" class="form-control" name="lehrstuhlname" placeholder="Lehrstuhlname">
                </div>
                <div class="form group">
                    <label>Seminarbeschreibung</label>
                    <input type="text" class="form-control" name="beschreibung" placeholder="Seminarbeschreibung">
                </div>
                <div class="form group">
                    <label>Teilnehmeranzahl</label>
                    <input type="number" class="form-control" name="soll-teilnehmeranzahl" placeholder="Teilnehmeranzahl">
                </div>
                <div class="form group">
                    <label>Motivationsschreiben notwendig</label>
                    <input type="text" class="form-control" name="msnotwendig" placeholder="Motivationsschreiben">
                    
                </div>
                <div class="form group">
                    <label>Angebotenes Semester</label>
                    <input type="text" class="form-control" name="semester" placeholder="Semester">
                </div>
                <div class="form group">
                    <label>Bachelor/Master</label>
                    <input type="text" class="form-control" name="BA/MA" placeholder="Bachelor/Master">
                    
                </div>
                
                
                </br>
                <button type="submit" class="btn btn-primary">Seminar anlegen</button>


            </div>
        
    </div>
<?php echo form_close(); ?>