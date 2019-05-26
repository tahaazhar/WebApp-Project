<?php
    require "header.php";
?>

    <main>
        <div class="wrapper-main">
            <section class="section-default">
/*grab token from url*/
                <?php
                  $selector = $_GET["selector"];
                  $validator = $_GET["validator"];
                  /*check whether token exist on url?*/
                  if(empty($selecor) || empty($validator)){
                    echo "Could not validate your request!";
                  }else{/*check token is hex?*/
                    if(ctype_xdigit($selecor) !== false && ctype_xdigit($validator) !== false){
                      ?>

                      <form action="includes/reset-password-inc.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector ?>;">/ERROR= * ";or;"????*/
                        <input type="hidden" name="validator" value="<?php echo $alidator ?>;">

                        <input type ="password" name="pwd" placeholder="Enter a new password...">
                        <input type ="password" name="pwd-repeat" placeholder="Repeat new password...">
                        <button type ='submit' name='Reset-password-submit'>Reset password</button>
                      </form>


                      <?php



                    }
                  }


                ?>



            </section>

        </div>
    </main>



<?php
    require "footer.php"

?>
