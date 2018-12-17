<html>
    <head>
        <title>Seminarplatzvergabe</title>

        <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/bootstrap.css">

        <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/bootstrap.js"></script>

    </head>
    <body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo base_url(); ?>">Seminarplatzvergabe</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="<?php echo base_url(); ?>">Allgemeine Informationen <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>">Login</a>
      <a class="nav-item nav-link" href="<?php echo base_url(); ?>users/register">Register</a>
    
    </div>
  </div>
</nav>




<div class="container">

<!--Flash messages -->
<?php if($this->session->flashdata('user_registered')): ?>
  <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
<?php endif; ?>