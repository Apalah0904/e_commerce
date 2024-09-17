<?php 

  session_start();

  @include 'config.php';
  @include 'functions.php';
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/style1.css" />
  <title>Document</title>
</head>

<body>
  <div class="wrapper">
    <form  method="post">
      <h1>login</h1>
      <div class="input-box">
        <input type="text" placeholder="username" name="username" required />
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="password" name="password" required />
        <i class='bx bxs-lock-alt'></i>
      </div>
      <button type="submit" class="btn" name="login">login</button>
    </form>
  </div>
</body>

</html>