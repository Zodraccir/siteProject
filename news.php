<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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

                    <?php
                    // Include config file
                    require_once 'config.php';
                    
                    $i=0;

                    // Attempt select query execution
                    $sql = "SELECT * FROM articles ORDER BY articleDate DESC";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            while($row = $result->fetch_array()){

                                echo '<article class="entry-news' . (($i%2 == 0) ? " entry-news__left" : " entry-news__right") . '">';
                                
                                echo '<header class="entry-header"><h2 class="entry-title"><a href="read.php?id=' . $row['id'] . '" rel="bookmark">' . $row['articleTitle'] . '</a></h2>
                                        <p class="entry-meta">
                                            ' . date('jS F, Y' , strtotime($row['articleDate'])) . '
                                            by <span class="entry-meta__author">' . $row['creatorName'] . '</span> 
                                        </p>
                                    </header>
                                    <div class="entry-content" itemprop="text">
                                        <p>' . $row['articleText'] . '</p>
                                    </div>

                                </article>';
                                $i++;
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
        <script src="files/scrips.js"></script>
    </body>
</html>