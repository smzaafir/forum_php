<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

</head>
<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup"true" aria-expanded="false">
            Top Categories
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

$sql="SELECT category_name, cat_id FROM `categories` LIMIT 3";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
        echo '<a class="dropdown-item" href="threadlist.php?catid='.$row['cat_id'].'">'. $row['category_name'] .'</a>';

}
        echo'  </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
      <div class="row mx-2">';
			if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			  echo '<form class="d-flex my-2 my-lg-0" method="get" action="search.php" role="search">
			    <input class="form-control mr-sm-2" name="search" type="search" placeholder="search" aria-label="search">
			    <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
			    <p class="text-light my-0 mx-2">Welcome ' . $_SESSION['useremail'] . '</p>
			    <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
			  </form>';
			}

      

      else {
        echo'
    <div class="col-md-6">
          <form class="d-flex my-2 my-lg-0" role="search">
            <input class="form-control  mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success  my-2 my-sm-0 mx-2" type="submit">Search</button>
          </form>
        </div>

        <div class="col-md-2 ">
          <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
        <div class="col-md-1">
          <button class="btn btn-outline-success mx-1" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
        </div>
      </div>';
          }
      echo '</div>
           </div>
           </nav>';

include "partials/_loginModal.php";
include "partials/_signupModal.php";
if(isset($_GET['signupsuccess']) && $signupsuccess="true"){
  echo '<div class="alert alert-success my-0" role="alert">
  <h5 class="alert-heading">You can now login!</h5>
</div>';
}


?>
