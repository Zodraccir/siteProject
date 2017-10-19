<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once 'config.php';

    // Prepare a select statement
    $sql = "DELETE FROM articles WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            header("location: protectedArea.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Riccardo WebSite</title>
        <meta name="description" content="We&#39;re a Sydney web design and development business that specialises in responsive websites and applications with a strong focus on usability, accessibility and standards.">
        <meta name="robots" content="noodp,noydir">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" id="parallax-pro-theme-css" href="./files/style.css" type="text/css" media="all">

        <link rel="stylesheet" id="simple-social-icons-font-css" href="./files/style(1).css" type="text/css" media="all">


        <style type="text/css">
            .site-title a { 
                background: url(http://maxdesign.com.au/maxdesign/wp-content/uploads/2016/04/cropped-logo7-1.png) no-repeat !important; 
            }
        </style>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>


        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script> 
            $(function(){
                $("#header").load("header.html"); 
                $("#footer").load("footer.html"); 
            });
        </script> 

        <style type="text/css" media="screen"> .simple-social-icons ul li a, .simple-social-icons ul li a:hover, .simple-social-icons ul li a:focus { background-color: #ffffff !important; border-radius: 60px; color: #000000 !important; border: 0px #ffffff solid !important; font-size: 30px; padding: 15px; }  .simple-social-icons ul li a:hover, .simple-social-icons ul li a:focus { background-color: #f04848 !important; border-color: #ffffff !important; color: #ffffff !important; }  .simple-social-icons ul li a:focus { outline: 1px dotted #f04848 !important; }</style>

    </head>
    <body class="header-image full-width-content parallax-pro-green">
        <div class="site-container">
            <div id="header"></div>

            <div class="site-inner">     

                <main class="content">

                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h1>Delete Record</h1>
                                    </div>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="alert alert-danger fade in">
                                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                                            <p>Are you sure you want to delete this record?</p><br>
                                            <p>
                                                <input type="submit" value="Yes" class="btn btn-danger">
                                                <a href="protectedArea.php" class="btn btn-default">No</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>        
                        </div>
                    </div>
                </main>

            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>