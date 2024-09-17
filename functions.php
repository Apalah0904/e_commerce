<?php

session_start();

include @'config.php';

if (isset($_POST['login'])) {
   $username = $_POST['username'];
   $password = $_POST['password'];

   $cekuser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
   $hitung = mysqli_num_rows($cekuser);

   if ($hitung > 0) {
       $ambildatarole = mysqli_fetch_array($cekuser);
       $role = $ambildatarole['role'];

       if ($role == 'admin') {
           $_SESSION['log'] = 'logged';
           $_SESSION['admin'] = 'admin';
           header('Location: admin.php');
       } else {
           $_SESSION['log'] = 'logged';
           $_SESSION['user'] = 'user';
           header('Location: user.php');
       }
   }
};

?>