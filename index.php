<?php

session_start();

if (isset( $_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	echo "You are logged in";
}

require_once('includes\db.php'); 
$db = new db();
$posts = $db->getAllPosts();

//melyik oldalon vagyunk jelenleg      
if(!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
        
//beállítja az sql LIMIT kezdőszámát
$thisPageFirstResult = ($page - 1) * $db->resultsPerPage;

//limitált találatok az adatbázisból
$limitedPosts = $db->limitTheResults($thisPageFirstResult, $db->resultsPerPage);
?>


<!DOCTYPE HTML>


<html>
	<head>
		<title>Szállás.hu Blog</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
        
      
		<!-- Header -->
			<header id="header">
				<div class="inner">
					<nav id="nav">
						<a href="index.php">Home</a>
                        <a href="login.php">Login</a>
                        <a href="editor.php">Editor</a>
                        <a href="logout.php">Logout</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>

		<!-- Banner -->
			<section id="banner">
				<h1>Szállás.hu Blog</h1>
				<p>Built with PHP</p>
			</section>

		<!-- One -->
			<section id="one" class="wrapper">
				<div class="inner">
					<div class="flex flex-3">
                    <?php foreach($limitedPosts as $i) { ?>
						<article>
							<header>
								<h3><?php echo $i['title'] ?></h3>
                            </header>
                            <p><?php echo '<img height="150" width="150" src="data:image;base64,'. $i['image'] .' "> ' ?></p>
							<p><?php echo $i['posted_at'] ?></p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
                        </article>
                        <?php } ?>
					</div>
				</div>
			</section>

        <!-- Three -->
        <!--
			<section id="three" class="wrapper special">
				<div class="inner">
					<header class="align-center">
						<h2>Nunc Dignissim</h2>
						<p>Aliquam erat volutpat nam dui </p>
					</header>
					<div class="flex flex-2">
						<article>
							<div class="image fit">
								<img src="images/pic01.jpg" alt="Pic 01" />
							</div>
							<header>
								<h3>Praesent placerat magna</h3>
							</header>
							<p>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor lorem ipsum.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
						<article>
							<div class="image fit">
								<img src="images/pic02.jpg" alt="Pic 02" />
							</div>
							<header>
								<h3>Fusce pellentesque tempus</h3>
							</header>
							<p>Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna non comodo sodales tempus.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
					</div>
				</div>
            </section>
        -->
            <!-- megjeleníti a linket az oldalakhoz -->
            <?php
            for($page = 1; $page <= $db->numberOfPages(); $page++) {
                echo '<a href="index.php?page=' . $page . '" class="button special">' . $page . '</a>';
            }
            ?>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<div class="flex">
						<ul class="icons">
							<li><a href="https://hu-hu.facebook.com/www.szallas.hu" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						</ul>
					</div>
				</div>
			</footer>
	</body>
</html>