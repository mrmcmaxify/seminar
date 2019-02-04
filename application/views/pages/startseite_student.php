
 <?php $zeiten = $this->Fristen_model->get_fristen(); ?>


<h4>Verfügbare Seminare: </h4>
<p>Anmeldung von <?php echo $zeiten[0]['Von'] ?> bis <?php echo $zeiten[0]['Bis']; ?> möglich</p>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Bewerbung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
      $test = $this->seminar_model->get_bama($this->session->userdata('user_email'));
    
      $data = $this->seminar_model->get_seminare_beworben1($this->session->userdata('user_email'),$test[0]['BA/MA']);
      //var_dump($data);
      $data1 = $this->seminar_model->get_seminare_not_beworben($this->session->userdata('user_email'),$test[0]['BA/MA']);
      //var_dump($data1);
      $data2 = $this->seminar_model->get_seminare_angemeldet($this->session->userdata('user_email'),$test[0]['BA/MA']);    
      //var_dump($data2);
      $data3 = $this->seminar_model->get_seminare_zugesagt($this->session->userdata('user_email'),$test[0]['BA/MA']);    
      //var_dump($data);
     foreach ($data1 as $seminare) :
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td>
      <?php echo form_open('student/show_seminar'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-success">Beschreibung</button>
      <?php echo form_close(); ?>
      </td>
      <td>
      <?php echo form_open('student/bewerbung_hinzufuegen2'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <input type="hidden" name="Beschreibung" value="<?php echo $seminare['Beschreibung']; ?>">
      <input type="hidden" name="MSNotwendig" value="<?php echo $seminare['MSNotwendig']; ?>">
      <button type="submit" class="btn btn-success">Bewerbung</button>
      <?php echo form_close(); ?>
      </td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>

</br></br>



<h4>Seminarbewerbungen:</h4>
<p>Rücktritt von <?php echo $zeiten[0]['Von'] ?> bis <?php echo $zeiten[0]['Bis']; ?> möglich</p>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Abmeldung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
     foreach ($data as $seminare) : 
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td>
        <?php echo form_open('student/show_seminar'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-success">Beschreibung</button>
      <?php echo form_close(); ?>
        </td>
        <td>
      <?php echo form_open('student/bewerbung_loeschen'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <input type="hidden" name="Beschreibung" value="<?php echo $seminare['Beschreibung']; ?>">
      <input type="hidden" name="MSNotwendig" value="<?php echo $seminare['MSNotwendig']; ?>">
      <button type="submit" class="btn btn-success">Abmeldung</button>
      <?php echo form_close(); ?>
      </td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>

</br></br>

<h4>Angemeldete Seminare: </h4>
<p>  Annahme/Ablehnung in der 1. Annahmephase von <?php echo $zeiten[2]['Von'] ?> bis <?php echo $zeiten[2]['Bis']; ?>, sowie in der 2.Annahmephase von <?php echo $zeiten[4]['Von'] ?> bis <?php echo $zeiten[4]['Bis']; ?> möglich </p>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Zusage</th>
      <th scope="col">Ablehnung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
     foreach ($data2 as $seminare) : 
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td>
        <?php echo form_open('student/seminar_zusagen'); ?>
          <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
          <button type="submit" class="btn btn-success">Zusage</button>
        <?php echo form_close(); ?>
      </td>
      <td>
      <?php echo form_open('student/seminar_ablehnen'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-success">Ablehnung</button>
      <?php echo form_close(); ?>
      </td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>

</br></br>



<h4>Zugesagte Seminare:</h4>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Beschreibung</th>
      
    </tr>
  </thead>
  <tbody>
    <?php 
     foreach ($data3 as $seminare) : 
      ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td>
        <?php echo form_open('student/show_seminar'); ?>
      <input type="hidden" name="SeminarID" value="<?php echo $seminare['SeminarID']; ?>">
      <button type="submit" class="btn btn-success">Beschreibung</button>
      <?php echo form_close(); ?>
        </td>
    </tr>
<?php endforeach; ?>

  </tbody>
</table>






          



