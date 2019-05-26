<?php
/*check whether user clicked the button: validation*/
if (isset($_POST["reset-password-submit"])) {
  /*grab data*/
  $selecor=$_POST["selector"];
  $validator=$_POST["validator"];
  $password=$_POST["pwd"];
  $passwordRepeat=$_POST["pwd-repeat"];

   /*errors?*/
   if(empty($password) || empty($passwordRepeat)){
     header("Location: ../signup.php?newpwd=empty");
     exit();

   }elseif($password != $passwordRepeat){
     header("Location: ../create-new-password.php?newpwd=pwdnotsane");
     exit();
   }

/*get current date*/
  $currentDate = date("U");

  require 'dbh.inc.php';

  $sql = "SELECT  * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires>=?";
  $stmt = mysqli_stmt_init($conn);
  /*ready prep stmt*/
  if(!mysqli_stmt_prepare($stmt, $sql)){
    echo "There was an error!";
    exit();

  }
  else{

    mysqli_stmt_bind_param($stmt, "s" , $selector);
    /*execute statement*/
    mysqli_stmt_execute($stmt);
    /*FORGOT CURRENT DATE HERE*/
    $result = mysqli_stmt_get_result($stmt);

    if(!$row = mysqli_fetch_assoc($result)){
      /*no rows = error*/
      echo "You need to re-submit your reset request.";
      exit();
    }else{
      /*match token */
      /*convert hex to bin*/
      $tokenBin - hex2bin($validator);
      $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

      if ($tokenCheck === false) {
        echo "You need to re-submit your reset request.";
        exit();
      }elseif ($tokenCheck === true){

        $tokenEmail = $row['pwdResetEmail'];

        $sql = "SELECT * FROM users WHERE emailUsers=?;";
        if(!mysqli_stmt_prepare($stmt, $sql)){
          echo "There was an error!";
          exit();

        }else{
          mysqli_stmt_bind_param($stmt, "s" , $tokenEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          if(!$row = mysqli_fetch_assoc($result)){
            /*no rows = error*/
            echo "There was an error!";
            exit();
          }else{/*update user info*/

            $sql = "UPDATE users SET pwdUsers=? WHERE emailUsers=?";
            $stmt = mysqli_stmt_init($conn);
            /*ready prep stmt*/
            if(!mysqli_stmt_prepare($stmt, $sql)){
              echo "There was an error!";
              exit();

            }
            else{
              $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss" , $newPwdHash, $tokenEmail);
              /*execute statement*/
              mysqli_stmt_execute($stmt);


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
                  mysqli_stmt_bind_param($stmt, "s" , $tokenEmail);
                  /*execute statement*/
                  mysqli_stmt_execute($stmt);
                  header("Location: ../signup.php?newpwd=passwordupdated");


                }


            }

          }


        }

      }
    }


  }


}else{
    header("Location: ../index.php");
}
