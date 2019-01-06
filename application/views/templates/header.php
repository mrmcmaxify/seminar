<html>
    <head>
        <title>Seminarplatzvergabe</title>

        <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.css">

        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.js"></script>

    </head>
    <body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?php echo base_url(); ?>">Seminarplatzvergabe</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="<?php echo base_url(); ?>">Allgemeine Informationen <span class="sr-only">(current)</span></a>
      
      <!-- Rollennavbar Dekan -->
      <?php if($this->session->userdata('rolle')==='dekan') : ?>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>dekan/startseite_dekan">Startseite</a>
      <?php endif; ?>
      <!-- Rollennavbar Admin -->
      <?php if($this->session->userdata('rolle')==='admin') : ?>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>admin/startseite_admin">Startseite Admin</a>
      <?php endif; ?>
       <!-- Rollennavbar Lehrstuhl -->
       <?php if($this->session->userdata('rolle')==='lehrstuhl') : ?>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/addstaff">Mitarbeiter anlegen</a>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/seminaranlegen">Seminar anlegen</a>
      <?php endif; ?>


      

    </div>
    <div class="navbar-nav navbar-right">
    <!-- Navbar nicht eingeloggt -->
    <?php if(empty($this->session->userdata('logged_in'))) : ?>
        <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/login">Login</a>
        <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/register">Registrieren</a>
      <?php endif; ?>
    <!-- Navbar eingeloggt -->
    <?php if($this->session->userdata('logged_in')) : ?>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/changepw">Passwort ändern</a>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/logout">Logout</a>
    <?php endif; ?>
      
    </div>
  </div>
</nav>
</br>



<div class="container">

<!--Flash messages -->
<?php if($this->session->flashdata('user_registered')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('login_failed')): ?>
  <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('user_loggedin')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('user_loggedout')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('pw_changed')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('pw_changed').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('pw_nomatch')): ?>
  <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('pw_nomatch').'</p>'; ?>
  <?php endif; ?>
<?php if($this->session->flashdata('upload')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('upload').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('testing')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('testing').'</p>'; ?>
<?php endif; ?>