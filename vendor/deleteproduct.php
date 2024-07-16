<?php
include "../connection/connect.php";

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    // Fetching product image path
    $fetch_delete_image_query = "SELECT * FROM `products` WHERE id = '$delete_id'";
    $fetch_delete_image_result = mysqli_query($conn, $fetch_delete_image_query);
    $fetch_delete_image = mysqli_fetch_assoc($fetch_delete_image_result);

    // Deleting product image file
    unlink($fetch_delete_image['product_image']);

    // Deleting product from database
    $delete_product_query = "DELETE FROM `products` WHERE id = '$delete_id'";
    mysqli_query($conn, $delete_product_query);

    header('location:productlist.php');
}
?>
