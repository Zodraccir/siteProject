<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$creatorName = $articleText = $articleTitle = "";
$creatorName_err = $articleText_err = $articleTitle_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_creatorName = trim($_POST["creatorName"]);
    if(empty($input_creatorName)){
        $creatorName_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["creatorName"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $creatorName_err = 'Please enter a valid creator name.';
    } else{
        $creatorName = $input_creatorName;
    }
    
    // Validate address
    $input_articleText = trim($_POST["address"]);
    if(empty($input_articleText)){
        $articleText_err = 'Please enter an article text.';     
    } else{
        $articleText = $input_articleText;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $articleTitle_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $articleTitle_err = 'Please enter a positive integer value.';
    } else{
        $articleTitle = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($creatorName_err) && empty($articleText_err) && empty($articleTitle_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO articles (name, address, salary) VALUES (?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_name, $param_address, $param_salary);
            
            // Set parameters
            $param_name = $creatorName;
            $param_address = $articleText;
            $param_salary = $articleTitle;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>