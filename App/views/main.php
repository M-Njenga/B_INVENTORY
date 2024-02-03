<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>B_Inventory</title>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <link rel="stylesheet" href="\B_INVENTORY\style.css">

  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>

</head>
<?php
 session_start();
 if(!$_SESSION["username"]){
  header("location:/B_inventory/");
 }
?>
<body>
  <div class="grid-container">


    <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
      <div class="header-left"></div>
      <div class="header-right">
        <ul class="list">
         
            <li>
              <span class="material-icons-outlined"><i class="fas fa-user-circle"></i></span>
              
              <p>
              <span id="role">
                <?php
                echo $_SESSION["username"] ?></span><br>
                
                <span id="role">
                  <?php echo $_SESSION["role"] ?>
                </span>
              
              </p>
             
              
               
          <div class="dropdown">
            <ul>
              <li><a href="#change_pass">Change password</a></li>
              <li><a href="logout.php">Log out</a></li>
              
            </ul>
          </div>
            </li>
        

        </ul>


      </div>
    </header>

    <aside id="sidebar">
    <div class="sidebar-title">
          <div class="sidebar-brand">
            <span class="material-icons-outlined">inventory</span> B_Inventory
          </div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

      <ul class="list">
        <li class="sidebar-list-item">
          <a href="#dashboard"><span class="material-icons-outlined">dashboard</span> Dashboard</a>
        </li>

        <li class="sidebar-list-item">
          <a href="#products"><span class="material-icons-outlined">inventory_2</span> Products</a>
        </li>
        <li class="sidebar-list-item">
          <a href="#users"><span class="material-icons-outlined"><i class="fas fa-users"></i></span> Users </a>

        </li>
        <li class="sidebar-list-item">
          <a href="#expenses"><span class="material-icons-outlined"><i class="fa fa-calculator" aria-hidden="true"></i></span> Expenses </a>
        </li>
        <li class="sidebar-list-item">
          <a href="#debts"> <span class="material-icons-outlined"><i class="fas fa-hand-holding-usd"></i></span> Debtors</a>
        <li class="sidebar-list-item">
          <a href="#credits"> <span class="material-icons-outlined"><i class="fa-solid fa-handshake"></i></span> Creditors </a>
        </li>
        <li class="sidebar-list-item">
          <a href="#stock"> <span class="material-icons-outlined"><i class="fa fa-cubes" aria-hidden="true"></i></span> Stock</a>
        </li>
        <li class="sidebar-list-item">
          <a href="#sales"> <span class="material-icons-outlined">fact_check</span> Sales </a>
        </li>
        <li class="sidebar-list-item">
          <a href="#report"> <span class="material-icons-outlined">poll</span> Reports</a>
        </li>

      </ul>
    </aside>

    <main class="main-container">

      <div id="content"></div>



    </main>


  </div>

  <script src="script.js"></script>
</body>

</html>