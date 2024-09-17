<?php

@include 'config.php';

$grand_total = 0;


if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">checkout baju</h1>

   <table>

      <thead>
         <th>gambar</th>
         <th>nama baju</th>
         <th>harga</th>
         <th>jumlah baju</th>
         <th>total harga</th>
         <th>perintah</th>
      </thead>

      <tbody>

      <?php 
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
   $grand_total = 0;
   if(mysqli_num_rows($select_cart) > 0){
      while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         // Calculate subtotal for each item
         $sub_total = $fetch_cart['quantity'] * $fetch_cart['price'];
         $grand_total += $sub_total;
?>
         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>RP.<?php echo number_format($fetch_cart['price']); ?>/1</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                  <input type="submit" value="ubah" name="update_update_btn">
               </form>   
            </td>
            <td><?php echo ' ' . number_format($sub_total, 0, ',', '.'); ?></td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> hapus</a></td>
         </tr>
<?php
      }
   }
?>

         <tr class="table-bottom">
            <td><a href="user.php" class="option-btn" style="margin-top: 0;">lanjutkan mencari</a></td>
            <td colspan="3">total keseluruhan</td>
            <td><?php echo $grand_total; ?></td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> hapus semua </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">checkout</a>
   </div>

</section>

</div>

</body>
</html>