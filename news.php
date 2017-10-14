<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Riccardo WebSite</title>
        <meta name="description" content="We&#39;re a Sydney web design and development business that specialises in responsive websites and applications with a strong focus on usability, accessibility and standards.">
        <meta name="robots" content="noodp,noydir">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" id="parallax-pro-theme-css" href="./files/style.css" type="text/css" media="all">

        <link rel="stylesheet" id="simple-social-icons-font-css" href="./files/style(1).css" type="text/css" media="all">


        <style type="text/css">
            .site-title a { 
                background: url(http://maxdesign.com.au/maxdesign/wp-content/uploads/2016/04/cropped-logo7-1.png) no-repeat !important; 
            }
        </style>


        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script> 
            $(function(){
                $("#header").load("header.html"); 
                $("#footer").load("footer.html"); 
            });
        </script> 

        <style type="text/css" media="screen"> .simple-social-icons ul li a, .simple-social-icons ul li a:hover, .simple-social-icons ul li a:focus { background-color: #ffffff !important; border-radius: 60px; color: #000000 !important; border: 0px #ffffff solid !important; font-size: 30px; padding: 15px; }  .simple-social-icons ul li a:hover, .simple-social-icons ul li a:focus { background-color: #f04848 !important; border-color: #ffffff !important; color: #ffffff !important; }  .simple-social-icons ul li a:focus { outline: 1px dotted #f04848 !important; }</style>

    </head>
    <body class="header-image full-width-content parallax-pro-green">
        <div class="site-container">
            <div id="header"></div>
            <div class="site-inner">     

                <main class="content">

                    <?php
                    // Include config file
                    require_once 'config.php';

                    // Attempt select query execution
                    $sql = "SELECT * FROM articles";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            while($row = $result->fetch_array()){


                                echo '<article class="post-3831 post type-post status-publish format-standard category-articles entry" itemscope="" itemtype="https://schema.org/CreativeWork">';

                                echo '<header class="entry-header"><h2 class="entry-title" itemprop="headline"><a href="http://maxdesign.com.au/articles/specialise-or-cross-skill/" rel="bookmark">' . $row['articleTitle'] . '</a></h2>
                                        <p class="entry-meta">
                                            <time class="entry-time" itemprop="datePublished" datetime="2015-02-03T21:01:27+00:00">February 3, 2015</time>
                                            by <span class="entry-author" itemprop="author" itemscope="" itemtype="https://schema.org/Person"><a href="http://maxdesign.com.au/author/m74qg8x7mwuhu/" class="entry-author-link" itemprop="url" rel="author"><span class="entry-author-name" itemprop="name">' . $row['creatorName'] . '</span></a></span>  
                                        </p>
                                    </header>
                                    <div class="entry-content" itemprop="text">
                                        <p>' . $row['articleText'] . '</p>
                                    </div>

                                </article>                            
                            </main>';
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