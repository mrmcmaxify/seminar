<h2>Seminar pflegen</h2>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Seminarname</th>
      <th scope="col">Seminar-ID</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Soll-Teilnehmerzahl</th>
      <th scope="col">Semester</th>
      

    </tr>
  </thead>
  <tbody>

 

    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['SeminarName']; ?> </th>
      <td><?php echo $seminare['SeminarID']; ?></td>
      <td><?php echo $seminare['Beschreibung']; ?></td>
      <td><?php echo $seminare['Soll-Teilnehmerzahl']; ?></td>
      <td><?php echo $seminare['Semester']; ?></td>

      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<?php echo validation_errors(); ?>

<?php echo form_open('lehrstuhl/seminar_pflegen'); ?>
    
    <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <div class="form group">
                    <label>Name des Seminars ändern</label>
                    <input type="text" class="form-control" name="seminarname" placeholder="Seminarname">
                </div>
                </br>
                <div class="form group">
                    <label>Seminarbeschreibung ändern</label>
                    <input type="text" class="form-control" name="beschreibung" placeholder="Seminarbeschreibung">
                </div>
                </br>
                <div class="form group">
                    <label>Teilnehmeranzahl</label>
                    <input type="text" class="form-control" name="soll-teilnehmerzahl" placeholder="Teilnehmeranzahl">
                </div>
                </br>
                
                <div class="form group">
                    <label>Angebotenes Semester</label>
                    <input type="text" class="form-control" name="semester" placeholder="Semester">
                </div>
                </br>
               
                
                
                </br>
                <button type="submit" class="btn btn-primary">Änderungen speichern</button>


            </div>
        
    </div>
<?php echo form_close(); ?>