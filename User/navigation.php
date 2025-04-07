<?php
if (session_status() === PHP_SESSION_NONE) {
  // Only start the session if it's not already started
  session_start();
}
if (!isset($_SESSION["username"])) {
  header("location:index.html");
} else {
  $username = $_SESSION["username"];
}
?>
<!doctype html>
<html lang="en">

<head>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenfinity</title>
    <link rel="icon" href="Zenfinity Logo.ico" type="image/x-icon">
    <link rel="shortcut icon" href="Zenfinity Logo.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <style>
    .icon-image {
      width: 24px;
      /* Adjust the width as needed */
      height: 24px;
      /* Adjust the height as needed */
      margin-right: 10px;
      /* Add spacing between icon and text */
    }
  </style>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <div class="p-4 pt-5">
        <h1><a href="HomePage.php" class="logo"><img src="Zenfinity Logo.jpg" alt="Logo"></a></h1>
        <ul class="list-unstyled components mb-5">
          <li>
            <a href="product_list.php">
              <img src="LOGO/Product.png" alt="Product Icon" class="icon-image">
              Product
            </a>
          </li>
          <li>
            <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <img src="LOGO/Transaction.png" alt="Transaction Icon" class="icon-image">
              Orders
            </a>
            <ul class="collapse list-unstyled" id="transactionSubmenu">
              <li>
                <a href="transaction.php">Orders Transactions </a>
              </li>
              <li>
                <a href="TransactionHistory.php">Orders Transactions History</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="logout.php">
              <img src="LOGO/SignOut.png" alt="SignOut Icon" class="icon-image">
              Sign Out</a>
          </li>
        </ul>
      </div>
    </nav>