    <?php
    include ("security.php");
function insert_Comment($comment_username, $comment){
    $servername = "localhost";
    $username = "admin";
    $password = "P@ssw0rd";
    $db_name = 'challenge';

    $conn = new mysqli($servername, $username, $password, $db_name);

    $stmt = $conn->prepare("INSERT INTO comments (username, comment, article_id) VALUES (?,?,2)");
    $stmt->bind_param("ss",$comment_username , $comment);
    $stmt->execute();
    if($stmt->affected_rows == 0) echo 'No rows updated';
    $stmt->close();
    $conn->close();
}
if (isset($_POST["comment"]))
{
    insert_Comment($_SESSION["username"],$_POST["comment"]);
}

$servername = "localhost";
$username = "admin";
$password = "P@ssw0rd";
$db_name = 'challenge';

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}


$sql_articles = "SELECT id, article_name, article_writer, article_date, content FROM articles WHERE id = 2";
$stmt_articles = $conn->prepare($sql_articles);


$stmt_articles->execute();

$stmt_articles->bind_result($artice_id, $article_name, $article_writer, $article_date, $article_content);
$stmt_articles->store_result();


?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>HTML Education Template</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>
        <link type="text/css" rel="stylesheet" href="css/google.css"/>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>

		<!-- Header -->
        <header id="header">
            <div class="container">

                <div class="navbar-header">
                    <!-- Logo -->
                    <div class="navbar-brand">
                        Welcome <?php echo htmlspecialchars($_SESSION["username"]);?>
                    </div>
                    <!-- /Logo -->

                    <!-- Mobile toggle -->
                    <button class="navbar-toggle">
                        <span></span>
                    </button>
                    <!-- /Mobile toggle -->
                </div>
            <?php

                if ($_SESSION["username"] == 'IMAdministrator'){


                ?>
                <nav id="nav">
                    <ul class="main-menu nav navbar-nav navbar-right">
                        <li><a href="UploadFilesToServer123.php">Upload</a></li>

                    </ul>
                </nav>
                <!-- /Navigation -->
                <?php }?>
                <!-- /Navigation -->

            </div>
        </header>
		<!-- /Header -->

		<!-- Hero-area -->
		<div class="hero-area section">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(./img/blog-post-background.jpg)"></div>
			<!-- /Backgound Image -->
            <?php
            if ($stmt_articles->num_rows >= 1){
            $stmt_articles->fetch();

            ?>
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center">
						<ul class="hero-area-tree">
							<li><a href="index.php">Home</a></li>
							<li><a href="blog.php">Blog</a></li>
							<li><?php printf("%s", $article_name) ;?></li>
						</ul>
						<h1 class="white-text"><?php printf("%s", $article_name); ?></h1>
						<ul class="blog-post-meta">
							<li class="blog-meta-author">By : <?php printf("%s", $article_writer); ?></li>
							<li><?php printf("%s", $article_date) ;?></li>
<!--							<li class="blog-meta-comments"><a href="#"><i class="fa fa-comments"></i> 35</a></li>-->
						</ul>
					</div>
				</div>
			</div>

		</div>

		<!-- /Hero-area -->

		<!-- Blog -->
		<div id="blog" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<!-- main blog -->
					<div id="main" class="col-md-9">

						<!-- blog post -->
						<div class="blog-post">

                            Some Text


						</div>
                        <?php
                        $conn = new mysqli($servername, $username, $password, $db_name);
                        $sql_comments = "SELECT id, username, comment FROM comments WHERE article_id = ?";
                        $stmt_comments = $conn->prepare($sql_comments);
                        $stmt_comments->bind_param("s", $artice_id);

                        $stmt_comments->execute();

                        $stmt_comments->bind_result($comment_id, $comment_username, $comment_content);
                        $stmt_comments->store_result();

                        if ($stmt_comments->num_rows >= 1){
                            echo "<div class=\"blog-comments\">";
                            echo "<h3>". $stmt_comments->num_rows ." Comments</h3>";
                            while ($row = $stmt_comments->fetch()){

                        ?>
						<!-- /blog post -->


                            <!-- single comment -->
                            <div class="media">
                                <div class="media-left">
                                    <img src="./img/avatar.png" alt="">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $comment_username; ?></h4>
                                    <p><?php echo htmlspecialchars($comment_content, ENT_QUOTES, 'UTF-8');;?></p>

                                    <div class="date-reply"><a href="#" class="reply">Reply</a></div>
                                </div>
                            </div>

                        <?php

                            }
                            echo "</div>";
                        }

                        ?>
                        <div class="blog-reply-form">
                            <h3>Leave Comment</h3>
                            <form action="blog.php" method="POST">

                                <textarea class="input" name="comment" placeholder="Enter your Message"></textarea>

                                <button class="main-button icon-button" id="submit">Submit</button>
                            </form>

                        </div>

						<!-- /blog share -->

						<!-- blog comments -->

						<!-- /blog comments -->
					</div>
					<!-- /main blog -->

					<!-- aside blog -->
                </div>

					<!-- /aside blog -->

				</div>
				<!-- row -->

			</div>
			<!-- container -->

		</div>
		<!-- /Blog -->
        <?php }
        else{

            ?>
            <script type="text/javascript">location.href = 'blog.php';</script>

            <?php
        }

        ?>

                <!-- row -->

		<!-- /Footer -->

		<!-- preloader -->
		<div id='preloader'><div class='preloader'></div></div>
		<!-- /preloader -->


		<!-- jQuery Plugins -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>

        <script>
            includeHTML();
        </script>
	</body>
</html>
