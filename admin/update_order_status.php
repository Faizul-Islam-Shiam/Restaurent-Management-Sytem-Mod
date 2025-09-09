<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status   = mysqli_real_escape_string($db, $_POST['status']);

    $sql = "UPDATE users_orders SET status='$status' WHERE o_id='$order_id'";
    if(mysqli_query($db, $sql)) {
        header("Location: all_orders.php?msg=Status updated successfully");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($db);
    }
} else {
    header("Location: all_orders.php?msg=Invalid request");
    exit();
}
?>