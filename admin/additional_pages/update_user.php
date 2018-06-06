<?php include("../includes/header.php"); ?>
<?php 
$update_form_string =  '

<form method="POST" action="" >
  Old password:<br>
  <input type="password" name="old_password">
  <br>
  New password:<br>
  <input type="password" name="new_password">
  <br>
   New e-mail:<br>
  <input type="email" name="new_email">
  <br>    <br>
  <input type="submit" value="Submit" name="update_submit">
</form>

';

$welcome_string = "<h4>Zdravo, " . $user->username() .", molimo unesite stare i nove podatke. Popunite samo polja koja zelite da promjenite.</h4>"

?>







<?php if (!isset($_POST['update_submit'])){
    $text = $welcome_string . $update_form_string;
    echo $text;
} else {
    if ($_POST['old_password'] == $user->password()){
        $user->update_user();
    } else {
        echo '<h3>Unesena je pogresna lozinka! Pokusajte ponovo.</h3>' . $update_form_string;
    }
}




?>

  <?php include("../includes/footer.php"); ?>