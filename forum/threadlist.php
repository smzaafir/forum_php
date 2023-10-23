<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss- Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
        <?php include 'partials/_dbconnect.php';?>
  <?php include 'partials/_header.php';?>

<?php
  $id = $_GET['catid'];
  $sql = "SELECT * FROM `categories` WHERE cat_id=$id;";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
      $catname = $row['category_name'];
      $catdesc = $row['category_description'];
  }
  ?>
<?php
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];
  //  echo $method;
  if($method == 'POST') {
      //Insert thread
      $th_title = $_POST['title'];
      $th_desc =  $_POST['desc'];

      $th_title = str_replace("<","&lt;", $th_title);
      $th_title = str_replace(">","&gt;", $th_title);

      $th_desc = str_replace("<","&lt;", $th_desc);
      $th_desc = str_replace(">","&gt;", $th_desc);

      $sno= $_POST['sno'];
      $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
      $result = mysqli_query($conn, $sql);
      $showAlert = true;
      if($showAlert) {
          echo '<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Success!</h4>
  <p>Your thread has been added.</p>

</div>';
      }
  }


  ?>

    <div class="container my-4">
    <div class="jumbotron">
      <h1 class="display-4">Welcome to <?php echo $catname;  ?>  forums</h1>
      <p class="lead">
        <?php echo $catdesc;  ?>
      </p>
      <hr class="my-4">
      <p>This is a peer-to-peer forum for sharing knowledge with each other. Self promotion is not allowed.
Keep posts courteous.
Use respectful language when posting.
Edit and delete posts as necessary using the tools provided by the forum.</p>
      <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
    </div>
  </div>
<?php
  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      echo '<div class="container">
    <h1 class="py-2">Start a discussion</h1>
       <form action=" '. $_SERVER["REQUEST_URI"].'" method="post">
         <div class="mb-3">
           <label for="exampleInputEmail1" class="form-label">Problem title</label>
           <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
           <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible</div>
         </div>
         <div class="form-group">
            <label for="floatingTextarea">Ellaborate your concern</label>
           <textarea class="form-control"  id="desc" name="desc" rows="3"></textarea>
         </div>
      <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">

         <button type="submit" class="btn btn-success">Submit</button>
       </form>
  </div>';
  } else {
      echo '<div class="container">
      <h1 class="py-2">Start a discussion</h1>
  <p class ="lead">
You are not logged in. Please login to start a discussion
  </p>
  </div>';
  }

  ?>

  <div class="container mb-5" >
    <h1 class="py-2">Browse Questions</h1>
    <?php
        $id = $_GET['catid'];
  $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id;";
  $result = mysqli_query($conn, $sql);
  $noResult = true;
  while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $id = $row['thread_id'];
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];
      $thread_time = $row['timestamp'];
      $thread_user_id = $row['thread_user_id'];
      $sql2 = "SELECT user_email FROM `users`WHERE sno='$thread_user_id'";
      $result2 = mysqli_query($conn, $sql2);
      $row2 =  mysqli_fetch_assoc($result2);

      echo '<div class="media my-3">
      <img src="userdefault.png" width="54px" class="mr-3" alt="...">
      <div class="media-body">'.
      '<h5 class="mt-0"> <a class="text-dark" href="thread.php?threadid=' .$id .'">'. $title  .' </a></h5>
'.$desc .' </div>'.' <div class= "font-weight-bold my-0"> Asked by: '.   $row2['user_email'] .' at '. $thread_time.'
</div>'.

  '  </div>';
  }
  //echo var_dump($noResult);
  if($noResult) {
      echo '<div class="jumbotron jumbotron-fluid">
<div class= "container">
<p class="display-4"> No Threads Found</p>
<p class ="lead">
 be the first person to ask a question
</p>
</div>
</div>';
  }


  ?>




    <!-- Add more questions here if needed -->
  </div>



  <?php include 'partials/_footer.php';?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>
