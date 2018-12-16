<h2><?= $title ?></h2>

<p>Willkommen!</p>

<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Email-Adresse</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E-Mail">
    <small id="emailHelp" class="form-text text-muted">Bitte universitäre E-Mail-Adresse eingeben.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Passwort</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Passwort">
  </div>
  
  <button type="submit" class="btn btn-primary">Anmelden</button>
</form>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Frist</th>
      <th scope="col">Von</th>
      <th scope="col">Bis</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($fristen as $frist) : ?>
    <tr>
      <th scope="row"> <?php echo $frist['Name']; ?> </th>
      <td><?php echo $frist['Datum']; ?></td>
      
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>



<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Lehrstuhl</th>
      <th scope="col">Seminar</th>
      <th scope="col">Teilnehmer</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($seminar as $seminare) : ?>
    <tr>
      <th scope="row"> <?php echo $seminare['LehrstuhlName']; ?> </th>
      <td><?php echo $seminare['SeminarName']; ?></td>
      <td><?php echo $seminare['Ist-Teilnehmerzahl']." / ".$seminare['Soll-Teilnehmerzahl']; ?></td>
      
    </tr>
<?php endforeach; ?>
  </tbody>
</table>



