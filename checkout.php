<?php

@include 'config.php';

if (isset($_POST['order_btn'])) {

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if (mysqli_num_rows($cart_query) > 0) {
      while ($product_item = mysqli_fetch_assoc($cart_query)) {
         $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ') ';
         $product_price = ($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      }
      ;
   }
   ;

   $total_product = implode(', ', $product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')") or die('query failed');

   if ($cart_query && $detail_query) {
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>terima kasih telah memesan!</h3>
         <div class='order-detail'>
            <span>" . $total_product . "</span>
            <span class='total'> total : Rp" . $price_total . "  </span>
         </div>
         <div class='customer-details'>
            <p> nama : <span>" . $name . "</span> </p>
            <p> no hp : <span>" . $number . "</span> </p>
            <p>  email : <span>" . $email . "</span> </p>
            <p> alamat : <span>" . $flat . ", " . $street . ", " . $city . ", " . $state . ", " . $country . " - " . $pin_code . "</span> </p>
            <p> metode pembayaran : <span>" . $method . "</span> </p>
         </div>
            <a href='user.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="container">

      <section class="checkout-form">

         <h1 class="heading">selesaikan pesanan</h1>

         <form action="" method="post">

            <div class="display-order">
               <?php
               $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
               $total = 0;
               $grand_total = 0;
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $total_price = floatval($fetch_cart['price'] * $fetch_cart['quantity']);
                     $grand_total = $total += $total_price;

                     ?>
                     <span>
                        <?= $fetch_cart['name']; ?>(
                        <?= $fetch_cart['quantity']; ?>)
                     </span>
                     <?php
                  }
               } else {
                  echo "<div class='display-order'><span>your cart is empty!</span></div>";
               }
               ?>
               <span class="grand-total"> total keseluruhan : rp
                  <?= $grand_total; ?>
               </span>
            </div>

            <div class="flex">
               <div class="inputBox">
                  <span>nama</span>
                  <input type="text" placeholder="masukan nama" name="name" required>
               </div>
               <div class="inputBox">
                  <span>no hp</span>
                  <input type="number" placeholder="masukan no hp" name="number" required>
               </div>
               <div class="inputBox">
                  <span>email</span>
                  <input type="email" placeholder="masukan email" name="email" required>
               </div>
               <div class="inputBox">
                  <span>metode pembayaran</span>
                  <select name="method">
                     <option value="cash on delivery" selected>bayar di tempat</option>
                  </select>
               </div>
               <div class="inputBox">
                  <span>alamat jalan 1</span>
                  <input type="text" placeholder="cth. jln silaberanti" name="flat" required>
               </div>
               <div class="inputBox">
                  <span>alamat jalan 2</span>
                  <input type="text" placeholder="cth. gang taqwa/lorong jambu" name="street" required>
               </div>
               <div class="inputBox">
                  <span>kota</span>
                  <input type="text" placeholder="cth. palembang" name="city" required>
               </div>
               <div class="inputBox">
                  <span>kecamatan</span>
                  <input type="text" placeholder="cth. kemuning" name="state" required>
               </div>
               <div class="inputBox">
                  <span>negara</span>
                  <input type="text" placeholder="cth. indonesia" name="country" required>
               </div>
               <div class="inputBox">
                  <span>kode rumah </span>
                  <input type="text" placeholder="cth. 123456" name="pin_code" required>
               </div>
            </div>
            <input type="submit" value="order now" name="order_btn" class="btn">
         </form>

      </section>

   </div>

</body>

</html>