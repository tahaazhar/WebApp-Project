<?php

if(isset($_POST["reset-request-submit"])){

  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);
/*url = our own url/page on our site*/
  $url = "www.course-diary.com/forgottenpwd/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

  /*expiry date*/
  $expires = date("U") + 1800;

  /*CONNECT DATABASE*/
  require 'dbh.inc.php';
/*get email*/
  $userEmail = $_POST["email"];
/*delete old token*/
  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
/*prep stmt*/
  $stmt = mysqli_stmt_init($conn);
  /*ready prep stmt*/
  if(!mysqli_stmt_prepare($stmt, $sql)){
    echo "There was an error!";
    exit();

  }
  else{
      /*replace ? with what user wrote*/
    mysqli_stmt_bind_param($stmt, "s" , $userEmail);
    /*execute statement*/
    mysqli_stmt_execute($stmt);


  }
  /*insert token into database */
  $sql = "INSERT INTO pwdReset(pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES(?,?,?,?);";
  /*prep stmt*/
    $stmt = mysqli_stmt_init($conn);
    /*ready prep stmt*/
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo "There was an error!";
      exit();

    }
    else{
      /*decrypt*/
      $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        /*replace ? with what user wrote*/
      mysqli_stmt_bind_param($stmt, "ssss" , $userEmail,$selector,$hashedToken, $expires);
      /*execute statement*/
      mysqli_stmt_execute($stmt);


    }
    /*close statement $stmt*/
    mysqli_stmt_close($stmt);

    /*close sql*/
    mysqli_close($conn);

    /*send email*/
    $to =$userEmail;
    $subject= "Reset your password for Course Diary";
    $message = "<p>We receiced a passowrd reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>";
    $message .= "<p>Here is your password reset link:</br>";
    $message .='<a href="' . $url .'">' . $url . '</a></p>';

    $headers ="From: CourseDiary <coursediary@gmail.com>\r\n";
    $headers .= "Reply-To: coursediary@gmail.com\r\n";
/*enable html*/
    $headers .= "Content-type: text/html\r\n";


    mail($to, $subject, $message, $headers);
/*get user back to*/
    header("Location: ../reset-password.php?reset=success");



}
else{
    header("Location: ../index.php");
}
