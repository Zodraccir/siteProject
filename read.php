<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once 'config.php';

    // Prepare a select statement
    $sql = "SELECT * FROM articles WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $creatorName = $row["creatorName"];
                $articleText = $row["articleText"];
                $articleTitle = $row["articleTitle"];
                $articleDate = $row["articleDate"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>View Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" id="parallax-pro-theme-css" href="./files/style.css" type="text/css" media="all">
        <link rel="stylesheet" id="simple-social-icons-font-css" href="./files/style(1).css" type="text/css" media="all">


        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script> 
            $(function(){
                $("#header").load("header.html"); 
                $("#footer").load("footer.html"); 
            });
        </script> 
        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>
        <style type="text/css" media="screen"> .simple-social-icons ul li a, .simple-social-icons ul li a:hover, .simple-social-icons ul li a:focus { background-color: #ffffff !important; border-radius: 60px; color: #000000 !important; border: 0px #ffffff solid !important; font-size: 30px; padding: 15px; }  .simple-social-icons ul li a:hover, .simple-social-icons ul li a:focus { background-color: #f04848 !important; border-color: #ffffff !important; color: #ffffff !important; }  .simple-social-icons ul li a:focus { outline: 1px dotted #f04848 !important; }</style>
    
    </head>
    <body class="full-width-content parallax-pro-green parallax-home">
        <div class="site-container">
            <div id="header"></div>
            <div class="site-inner">     

                <main class="content">
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h1>View Article</h1>
                                    </div>
                                    <div class="form-group">
                                        <label>Creator Name</label>
                                        <p class="form-control-static"><?php echo $row["creatorName"]; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Article Text</label>
                                        <p class="form-control-static"><?php echo $row["articleText"]; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Article Title</label>
                                        <p class="form-control-static"><?php echo $row["articleTitle"]; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Article Date</label>
                                        <p class="form-control-static"><?php echo $row["articleDate"]; ?></p>
                                    </div>
                                    <p><a href="protectedArea.php" class="button">Back</a></p>
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