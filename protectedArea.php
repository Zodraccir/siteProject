<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Riccardo WebSite</title>
        <meta name="description" content="We&#39;re a Sydney web design and development business that specialises in responsive websites and applications with a strong focus on usability, accessibility and standards.">
        <meta name="robots" content="noodp,noydir">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" id="parallax-pro-theme-css" href="./files/header.css" type="text/css" media="all">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <style type="text/css">
            .wrapper{
                width: 650px;
                margin: 0 auto;
            }
            .page-header h2{
                margin-top: 0;
            }
            table tr td:last-child a{
                margin-right: 15px;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
        </script>


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
            <div class="site-inner">     

                <main class="content">


                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header clearfix">
                                        <h2 class="pull-left">articles Details</h2>
                                        <a href="create.php" class="button pull-right">Add New Employee</a>
                                    </div>
                                    <?php
                                    // Include config file
                                    require_once 'config.php';

                                    // Attempt select query execution
                                    $sql = "SELECT * FROM articles";
                                    if($result = $mysqli->query($sql)){
                                        if($result->num_rows > 0){
                                            echo "<table class='table table-bordered table-striped'>";
                                            echo "<thead>";
                                            echo "<tr>";
                                            echo "<th>#</th>";
                                            echo "<th>Creator Name</th>";
                                            echo "<th>Article Text</th>";
                                            echo "<th>Article Title</th>";
                                            echo "<th>Article Date</th>";
                                            echo "<th>Action</th>";
                                            echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            while($row = $result->fetch_array()){
                                                echo "<tr>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['creatorName'] . "</td>";
                                                echo "<td>" . substr($row['articleText'],0,10) . (strlen($row['articleText'])>10? "..." : "") . "</td>";
                                                echo "<td>" . $row['articleTitle'] . "</td>";
                                                echo "<td>" . $row['articleDate'] . "</td>";
                                                echo "<td>";
                                                echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                                echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                                echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                            echo "</tbody>";                            
                                            echo "</table>";
                                            // Free result set
                                            $result->free();
                                        } else{
                                            echo "<p class='lead'><em>No records were found.</em></p>";
                                        }
                                    } else{
                                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                                    }

                                    // Close connection
                                    $mysqli->close();
                                    ?>
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