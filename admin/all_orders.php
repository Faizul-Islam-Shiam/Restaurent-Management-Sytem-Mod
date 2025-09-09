<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Orders</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <div id="main-wrapper">
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="images/food-mania-logo.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0"></ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/3.png" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-label">Home</li>
                        <li><a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                        <li class="nav-label">Log</li>
                        <li><a href="all_users.php"><i class="fa fa-user f-s-20"></i><span>Users</span></a></li>
                        <li><a class="has-arrow" href="#"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Restaurant</span></a>
                            <ul class="collapse">
                                <li><a href="all_restaurant.php">All Restaurants</a></li>
                                <li><a href="add_category.php">Add Category</a></li>
                                <li><a href="add_restaurant.php">Add Restaurant</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="#"><i class="fa fa-cutlery"></i><span class="hide-menu">Menu</span></a>
                            <ul class="collapse">
                                <li><a href="all_menu.php">All Menus</a></li>
                                <li><a href="add_menu.php">Add Menu</a></li>
                            </ul>
                        </li>
                        <li><a href="all_orders.php"><i class="fa fa-shopping-cart"></i><span>Orders</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">All Orders</h4>
                                </div>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Reg-Date</th>
                                                <th>Action</th>
                                                <th>Update Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id";
                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="9"><center>No Orders</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    echo '<tr>
                                                        <td>' . $rows['username'] . '</td>
                                                        <td>' . $rows['title'] . '</td>
                                                        <td>' . $rows['quantity'] . '</td>
                                                        <td>৳' . $rows['price'] . '</td>
                                                        <td>' . $rows['address'] . '</td>';

                                                    $status = $rows['status'];
                                                    if ($status == "" || $status == "NULL") {
                                                        echo '<td><button type="button" class="btn btn-info"><span class="fa fa-bars"></span> Dispatch</button></td>';
                                                    } elseif ($status == "in process") {
                                                        echo '<td><button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"></span> On The Way!</button></td>';
                                                    } elseif ($status == "closed") {
                                                        echo '<td><button type="button" class="btn btn-success"><span class="fa fa-check-circle"></span> Delivered</button></td>';
                                                    } elseif ($status == "rejected") {
                                                        echo '<td><button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button></td>';
                                                    }

                                                    echo '<td>' . $rows['date'] . '</td>
                                                        <td>
                                                            <a href="delete_orders.php?order_del=' . $rows['o_id'] . '" onclick="return confirm(\'Are you sure?\');" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                                            <a href="view_order.php?user_upd=' . $rows['o_id'] . '" class="btn btn-info btn-sm"><i class="ti-settings"></i></a>
                                                        </td>
                                                        <td>
                                                            <form method="post" action="update_order_status.php">
                                                                <input type="hidden" name="order_id" value="' . $rows['o_id'] . '">
                                                                <select name="status" class="form-control">
                                                                    <option value="Pending"   ' . ($rows['status'] == "Pending" ? "selected" : "") . '>Pending</option>
                                                                    <option value="Preparing" ' . ($rows['status'] == "Preparing" ? "selected" : "") . '>Preparing</option>
                                                                    <option value="Picked"    ' . ($rows['status'] == "Picked" ? "selected" : "") . '>Picked</option>
                                                                    <option value="Delivered" ' . ($rows['status'] == "Delivered" ? "selected" : "") . '>Delivered</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                                                            </form>
                                                        </td>
                                                    </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">© 2025 All rights reserved.</footer>
        </div>
    </div>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
</body>
</html>
