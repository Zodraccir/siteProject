<?php


$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Error</title>
        <style type="text/css">
            .wrapper{
                width: 750px;
                margin: 0 auto;
            }
        </style>

        <link rel="stylesheet" href="./files/style.css" type="text/css" media="all">

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
        <div id="header"></div>

        <div class="site-inner separated-content">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h1>Invalid Request</h1>
                            </div>
                            <div class="alert alert-danger fade in">
                                <p>Sorry, you've made an invalid request. Please <a href="<?= $previous?>" class="alert-link">go back</a> and try again.</p>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
        <div id="footer"></div>

    </body>
</html>