<h2>Seminar anlegen</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('lehrstuhl/seminaranlegen'); ?>   
    <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>Name des Seminars</label>
                    <input type="text" class="form-control" name="seminarname" placeholder="Seminarname">
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
                <input type="radio" id="1" name="msnotwendig" value="1" checked>
                <label for="1"> Ja</label> 
                <input type="radio" id="2" name="msnotwendig" value="2">
                <label for="2"> Nein</label>
                </div>
                </br>
                <select class="form-control" name="semester">
                    <label>Angebotenes Semester</label>
                        <?php foreach($semester as $semes){ ?>
                            <option value="<?php echo $semes->bezeichnung; ?>"><?php echo $semes->bezeichnung; ?></option>';
                        <?php } ?>
                 </select>
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