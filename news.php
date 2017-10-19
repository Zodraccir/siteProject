<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Riccardo WebSite</title>

        <link rel="stylesheet" id="parallax-pro-theme-css" href="./files/header.css" type="text/css" media="all">

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

                    <?php
                    // Include config file
                    require_once 'config.php';

                    // Attempt select query execution
                    $sql = "SELECT * FROM articles ORDER BY articleDate DESC";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            while($row = $result->fetch_array()){


                                echo '<article class="post type-post status-publish format-standard category-articles entry" itemscope="">';

                                echo '<header class="entry-header"><h2 class="entry-title" itemprop="headline">' . $row['articleTitle'] . '</h2>
                                        <p class="entry-meta">
                                            ' . date('jS F, Y' , strtotime($row['articleDate'])) . '
                                            by ' . $row['creatorName'] . ' 
                                        </p>
                                    </header>
                                    <div class="entry-content" itemprop="text">
                                        <p>' . $row['articleText'] . '</p>
                                    </div>

                                </article>';
                            }

                            // Free result set
                            $result->free();
                        } else{

                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }

                    // Close connection
                    $mysqli->close();
                    ?>

                </main>

            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>