<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$creatorName = $articleText = $articleTitle = $articleDate = "";
$creatorName_err = $articleText_err = $articleTitle_err = $articleDate_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_creatorName = trim($_POST["creatorName"]);
    if(empty($input_creatorName)){
        $creatorName_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["creatorName"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $creatorName_err = 'Please enter a valid name.';
    } else{
        $creatorName = $input_creatorName;
    }

    // Validate text
    $input_articleText = trim($_POST["address"]);
    if(empty($input_articleText)){
        $articleText_err = 'Please enter an address.';     
    } else{
        $articleText = $input_articleText;
    }

    // Validate title
    $input_articleTitle = trim($_POST["salary"]);
    if(empty($input_articleTitle)){
        $articleTitle_err = "Please enter the salary amount.";     
    } else{
        $articleTitle = $input_articleTitle;
    }
    
    // Validate date
    $input_articleDate = trim($_POST["articleDate"]);
    if(empty($input_articleDate)){
        $articleDate_err = "Please enter the articleDate.";     
    } else{
        $articleDate = $input_articleDate;
    }

    // Check input errors before inserting in database
    if(empty($creatorName_err) && empty($articleText_err) && empty($articleTitle_err) && empty($articleDate_err)){
        // Prepare an insert statement
        $sql = "UPDATE articles SET creatorName=?, articleText=?, articleTitle=?, articleDate=? WHERE id=?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssi", $param_creatorName, $param_articleText, $param_articleTitle, $param_articleDate, $param_id);

            // Set parameters
            $param_creatorName = $creatorName;
            $param_articleText = $articleText;
            $param_articleTitle = $articleTitle;
            $param_articleDate = $articleDate;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: protectedArea.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM articles WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $id;

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
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: protectedArea.php");
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
    }  else{
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


        <link rel="stylesheet" href="./files/style.css" type="text/css" media="all">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="./files/font-awesome.min.css" type="text/css" media="all">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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

    </head>
    <body>
        <div class="site-container">
            <div id="header"></div>

            <div class="site-inner separated-content">     

                <main class="content">

                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h2>Update Record</h2>
                                    </div>
                                    <p>Please edit the input values and submit to update the record.</p>
                                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                        <div class="form-group <?php echo (!empty($creatorName_err)) ? 'has-error' : ''; ?>">
                                            <label>Creator Name</label>
                                            <input type="text" name="creatorName" class="form-control" value="<?php echo $creatorName; ?>">
                                            <span class="help-block"><?php echo $creatorName_err;?></span>
                                        </div>
                                        <div class="form-group <?php echo (!empty($articleText_err)) ? 'has-error' : ''; ?>">
                                            <label>Article Text</label>
                                            <textarea name="address" class="form-control"><?php echo $articleText; ?></textarea>
                                            <span class="help-block"><?php echo $articleText_err;?></span>
                                        </div>
                                        <div class="form-group <?php echo (!empty($articleTitle_err)) ? 'has-error' : ''; ?>">
                                            <label>Article title</label>
                                            <input type="text" name="salary" class="form-control" value="<?php echo $articleTitle; ?>">
                                            <span class="help-block"><?php echo $articleTitle_err;?></span>
                                        </div>
                                        <div class="form-group <?php echo (!empty($articleDate_err)) ? 'has-error' : ''; ?>">
                                            <label>Article Date</label>
                                            <input type="date" name="articleDate" class="form-control" min="2000-01-02" value="<?php echo $articleDate; ?>"> 
                                            <span class="help-block"><?php echo $articleDate_err;?></span>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                        <a href="protectedArea.php" class="btn btn-default">Cancel</a>
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

