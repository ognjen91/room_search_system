<?php include("../includes/header.php"); ?>

<h4>Ulogovani korisnik: <?php echo $user->username(); ?></h4>
<h3>Email: <?php echo $user->email(); ?></h3>

<h5><a href="update_user.php">IZMJENA KORISNICKIH PODATAKA</a></h5>
<h5><a href="../index.php">POVRATAK NA ADMIN PANEL</a></h5>

  <?php include("../includes/footer.php"); ?>