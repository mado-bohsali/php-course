<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
  if(!isset($_GET['email']) && !isset($_GET['token'])) {
    redirect('index');
  }

  

 /*  $email = 'lars.lillo@gmail.com';
  $token = "f49dd3aab492b9d452eef30adda13e26c42e5b67f402689cd291d2f196344b1ed4ef9b98bb14a84c8aa45cd408e52671b87f"; */

  if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token = ?')) {
    mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

/*     if($_GET['token'] !== $token || $_GET['email'] !== $email) {
      redirect('index');
    } */


    if(isset($_POST['password']) && isset($_POST['confirmPassword'])) {
      if ($_POST['password'] === $_POST['confirmPassword']) {
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
        if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email = ?"));
          mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
          mysqli_stmt_execute($stmt);
          if(mysqli_stmt_affected_rows($stmt) >= 1) {
            redirect('login.php');
          }
          mysqli_stmt_close($stmt);
      }
    }


  }
?>

<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
  <div class="form-gap"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="text-center">

              <h3>
                <i class="fa fa-lock fa-4x"></i>
              </h3>
              <h2 class="text-center">Forgot Password?</h2>
              <p>You can reset your password here.</p>
              <div class="panel-body">

                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

<!--                   <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-envelope color-blue"></i>
                      </span>
                      <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user color-blue"></i>
                      </span>
                      <input type="password" name="password" id="password" placeholder="Confirm Password" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-ok color-blue"></i>
                      </span>
                      <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                  </div>

                  <input type="hidden" class="hide" name="token" id="token" value="">
                </form>

              </div>
              <!-- Body-->

              <h2>Please check your email</h2>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php redirect('login.php') ?>

  <hr>

  <?php include "includes/footer.php"; ?>

</div>
<!-- /.container -->