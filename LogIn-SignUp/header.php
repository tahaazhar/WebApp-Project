<?php
    session_start()

?>


<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="main.js"></script>
</head>
<body>
    <header>
        <nav class="nav-header-main">
        <div class="login-box">     
        <a class="header-logo" href="#">
                <img src="img/logo4.png" alt="logo">
            </a> 
            <ul>
                <li><a href="../wanderlust.html">Home</a></li>
                <li><a href="#">Portfolio</a></li>
                <li><a href="#">About me</a></li>
                <li><a href="#">Contact</a></li>
            </ul>  
            <div class="header-login">
                <?php
                    if(isset($_SESSION['userId'])){
                        echo '<form action="includes/logout.inc.php" method="post">
                   
                        <button type="submit" name="logout-submit">Logout</button>
                    
                                </form>';

                    }
                    else{
                        echo '<form action="includes/login.inc.php" method="post">
                        <input type="text" name="mailuid" placeholder="Username/E-mail...">
                        <input type="password" name="pwd" placeholder="Password">
                        <button type="submit" name="login-submit">Login</button>
                    
                        </form>
                        <a href="signup.php">Signup</a>';

                    }


                ?>
                
                
                

            
            
            </div>
                </div>
        </nav>
    
    </header>
</body>
</html>