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
    $id = $_GET['threadid'];
  $sql = "SELECT * FROM `threads` WHERE thread_id=$id;";
  $result = mysqli_query($conn, $sql);
  $noResult = true;
  while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];
      $thread_user_id = $row['thread_user_id'];

      //Query the users table to find name of OP
      $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
      $result2 = mysqli_query($conn, $sql2);
      $row2 =  mysqli_fetch_assoc($result2);
      $posted_by =  $row2['user_email'];
  }

  if ($noResult) {
      echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
        <p class="display-4"> No Threads Found</p>
        <p class="lead">
        Be the first person to ask a question
        </p>
        </div>
        </div>';
  }
  ?>

    <?php
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];

  if ($method == 'POST') {
      // Insert comment into the database
      $comment = $_POST['comment'];
      //saving from attack
      $comment = str_replace("<","&lt;", $comment);
      $comment = str_replace(">","&gt;", $comment);
      $sno = $_POST['sno'];
      $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
      $result = mysqli_query($conn, $sql);
      $showAlert = true;

      if ($showAlert) {
          echo '<div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Success!</h4>
            <p>Your comment has been added.</p>
            </div>';
      }
  }
  ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title; ?> </h1>
            <p class="lead">
                <?php echo $desc; ?>
            </p>
            <hr class="my-4">
            <p>This is a peer-to-peer forum for sharing knowledge with each other. Self-promotion is not allowed. Keep posts courteous. Use respectful language when posting. Edit and delete posts as necessary using the tools provided by the forum.</p>
            <p>Posted by: <em><?php echo $posted_by; ?></em></p>
        </div>
    </div>


    <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
            <div class="form-group">
                <label for="comment">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
  } else {
      echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <p class="lead">You are not logged in. Please login to be able to post a comment.</p>
    </div>';
  }
  ?>

    <div class="container">
        <h1 class="py-2">Discussions</h1>
        <?php
      $id = $_GET['threadid'];
  $sql = "SELECT * FROM `comments` WHERE thread_id=$id;";
  $result = mysqli_query($conn, $sql);
  $noResult = true;
  while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $id = $row['comment_id'];
      $content = $row['comment_content'];
      $comment_time = $row['comment_time'];
      $thread_user_id = $row['comment_by'];

      $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
      $result2 = mysqli_query($conn, $sql2);
      $row2 =  mysqli_fetch_assoc($result2);

      echo '<div class="media my-3">
            <img src="userdefault.png" width="54px" class="mr-3" alt="...">
            <div class="media-body">
                <p class="font-weight-bold my-0">
                    ' . $row2['user_email'] . ' at ' . $comment_time . '
                </p>
                ' . $content . '
            </div>
        </div>';
  }

  if ($noResult) {
      echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
            <p class="display-4">No Comments Found</p>
            <p class="lead">Be the first person to comment</p>
            </div>
            </div>';
  }
  ?>
    </div>

  <?php include 'partials/_footer.php';?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>
