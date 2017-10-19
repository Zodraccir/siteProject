<?php


$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once 'config.php';

    $sql = "SELECT * FROM articles WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $param_id);

        $param_id = trim($_GET["id"]);

        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $creatorName = $row["creatorName"];
                $articleText = $row["articleText"];
                $articleTitle = $row["articleTitle"];
                $articleDate = $row["articleDate"];
            } else{
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
        <title>Riccardo WebSite</title>
        <link rel="stylesheet" id="parallax-pro-theme-css" href="./files/style.css" type="text/css" media="all">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="./files/font-awesome.min.css" type="text/css" media="all">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">



        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script> 
            $(function(){
                $("#header").load("header.html"); 
                $("#footer").load("footer.html"); 
            });
        </script> 
    
        
    </head>
    <body>
        <div class="site-container">
            <div id="header"></div>
            <div class="site-inner separated-content">     

                <main class="content">
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row read-record">
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
                                    <p><a href="<?= $previous?>" class="button">Back</a></p>
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