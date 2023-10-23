<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss- Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      #maincontainer{
        min-height:80vh;
      }
    </style>

  </head>
  <body>
  <?php include 'partials/_dbconnect.php';?>
  <?php include 'partials/_header.php';?>



<div class="container my-3" id="maincontainer">
      <h1 class="py-2">Search results for <em>"<?php echo $_GET['search'] ?>"</em></h1>

      <?php
      $query = $_GET["search"];
  $sql = "SELECT * FROM `threads` where match(thread_title, thread_desc) against('$query')";
  $result = mysqli_query($conn, $sql);
  $noResult = true;
  while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];
      $thread_id= $row['thread_id'];
      $url="thread.php?threadid=". $thread_id;

      echo '  <div class="result">
<h3> <a href="'.$url.'" class="text-dark">'. $title. '</a>
</h3>
<p>'. $desc . '</p>

  </div>';
  }
  if ($noResult) {
      echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
        <p class="display-4"> No Results Found</p>
        <p class="lead">
        Make sure all words are spelled correctly.
        </p>
        </div>
        </div>';
  }
  ?>


  <?php include 'partials/_footer.php';?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>
