<?php
if (session_status() === PHP_SESSION_NONE) {
    // Only start the session if it's not already started
    session_start();
}
if(!isset($_SESSION["username"])){ header("location:index.html");}else{ $username = $_SESSION["username"];}
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
    width: 24px; /* Adjust the width as needed */
    height: 24px; /* Adjust the height as needed */
    margin-right: 10px; /* Add spacing between icon and text */
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
             <a href="Dashboard.php">
			<img src="LOGO/Dashboard.png" alt="Dashboard Icon" class="icon-image"> <!-- Icon image -->
						Dashboard </a>
            </li>
			
			
			<li>
				<a href="#productSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
				<img src="LOGO/Product.png" alt="Product Icon" class="icon-image">
				Product
					</a>
					<ul class="collapse list-unstyled" id="productSubmenu">
					<li>
					<a href="Product.php">Product List</a>
					</li>
					<li>
					<a href="AddProduct.php">Add Product</a>
					</li>
					<li>
					<a href="ArchiveProduct.php">Archive Product</a>
					</li>
					</ul>
					</li>
					
					
			<li>
              <a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <img src="LOGO/Inventory.png" alt="Inventory Icon" class="icon-image">
                Inventory
              </a>
              <ul class="collapse list-unstyled" id="inventorySubmenu">
                <li>
                  <a href="Inventory.php">Add to Inventory</a>
                </li>
				<li>
                  <a href="ProductInv.php">Inventory History</a>
                </li>
              </ul>
            </li>
			
			<li>
              <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <img src="LOGO/Transaction.png" alt="Transaction Icon" class="icon-image">
                Transaction
              </a>
              <ul class="collapse list-unstyled" id="transactionSubmenu">
                <li>
				<a href="transaction.php">Transaction</a>
                </li>
                <li>
                  <a href="TransactionHistory.php">Transaction History</a>
                </li>
              </ul>
            </li>
			
            <li>
            <a href="sales.php">
			<img src="LOGO/Sales.png" alt="Sales Icon" class="icon-image"> 
						Sales Report </a>
            </li>
			<li>
                         <a href="Locator.php">
			<img src="LOGO/Locator.png" alt="Locator Icon" class="icon-image"> 
						Locator </a>
            </li>
			<li>
              <a href="logout.php">
			  <img src="LOGO/SignOut.png" alt="SignOut Icon" class="icon-image">
			  Sign Out</a>
            </li>
          </ul>
        </div>
      </nav>