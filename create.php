<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$creatorName = $articleText = $articleTitle = $articleDate = "";
$creatorName_err = $articleText_err = $articleTitle_err = $articleDate_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_creatorName = trim($_POST["creatorName"]);
    if(empty($input_creatorName)){
        $creatorName_err = "Please enter a name.";
    } else{
        $creatorName = $input_creatorName;
    }

    // Validate articleText
    $input_articleText = trim($_POST["articleText"]);
    if(empty($input_articleText)){
        $articleText_err = 'Please enter an article text.';     
    } else{
        $articleText = $input_articleText;
    }

    // Validate artticleTitle
    $input_articleTitle = trim($_POST["articleTitle"]);
    if(empty($input_articleTitle)){
        $articleTitle_err = "Please enter the article title.";     
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

    
    error_log(print_r($articleDate,TRUE));

    // Check input errors before inserting in database
    if(empty($creatorName_err) && empty($articleText_err) && empty($articleTitle_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO articles (creatorName, articleText, articleTitle, articleDate) VALUES (?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_creatorName, $param_articleText, $param_articleTitle, $param_articleDate);

            // Set parameters
            $param_creatorName = $creatorName;
            $param_articleText = $articleText;
            $param_articleTitle = $articleTitle;
            $param_articleDate = $articleDate;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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


        <link rel="stylesheet" href="./files/header.css" type="text/css" media="all">

       

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

        

    </head>
    <body class="full-width-content parallax-pro-green">
        <div class="site-container">
            <div id="header"></div>

            <div class="site-inner">     

                <main class="content">

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
                                            <label>Creator Name</label>
                                            <input type="text" name="creatorName" class="form-control" value="<?php echo $creatorName; ?>">
                                            <span class="help-block"><?php echo $creatorName_err;?></span>
                                        </div>
                                        <div class="form-group <?php echo (!empty($articleText_err)) ? 'has-error' : ''; ?>">
                                            <label>Article Text</label>
                                            <textarea name="articleText" class="form-control"><?php echo $articleText; ?></textarea>
                                            <span class="help-block"><?php echo $articleText_err;?></span>
                                        </div>
                                        <div class="form-group <?php echo (!empty($articleTitle_err)) ? 'has-error' : ''; ?>">
                                            <label>Article Title</label>
                                            <input type="text" name="articleTitle" class="form-control" value="<?php echo $articleTitle; ?>">
                                            <span class="help-block"><?php echo $articleTitle_err;?></span>
                                        </div>
                                        <div class="form-group <?php echo (!empty($articleDate_err)) ? 'has-error' : ''; ?>">
                                            <label>Article Date</label>
                                            <input type="date" name="articleDate" class="form-control" min="2000-01-02" value="<?php echo empty($articleDate)?  date("Y-m-d"): $articleDate ; ?>"> 
                                            <span class="help-block"><?php echo $articleDate_err;?></span>
                                        </div>
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

