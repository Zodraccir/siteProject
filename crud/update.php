<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$creatorName = $articleText = $articleTitle = "";
$creatorName_err = $articleText_err = $articleTitle_err = "";
 
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
    
    // Validate address address
    $input_articleText = trim($_POST["address"]);
    if(empty($input_articleText)){
        $articleText_err = 'Please enter an address.';     
    } else{
        $articleText = $input_articleText;
    }
    
    // Validate salary
    $input_articleTitle = trim($_POST["salary"]);
    if(empty($input_articleTitle)){
        $articleTitle_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_articleTitle)){
        $articleTitle_err = 'Please enter a positive integer value.';
    } else{
        $articleTitle = $input_articleTitle;
    }
    
    // Check input errors before inserting in database
    if(empty($creatorName_err) && empty($articleText_err) && empty($articleTitle_err)){
        // Prepare an insert statement
        $sql = "UPDATE articles SET name=?, address=?, salary=? WHERE id=?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssi", $param_creatorName, $param_articleText, $param_articleTitle, $param_id);
            
            // Set parameters
            $param_creatorName = $creatorName;
            $param_articleText = $articleText;
            $param_articleTitle = $articleTitle;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
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
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
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
                            <label>Name</label>
                            <input type="text" name="creatorName" class="form-control" value="<?php echo $creatorName; ?>">
                            <span class="help-block"><?php echo $creatorName_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($articleText_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $articleText; ?></textarea>
                            <span class="help-block"><?php echo $articleText_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($articleTitle_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $articleTitle; ?>">
                            <span class="help-block"><?php echo $articleTitle_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>