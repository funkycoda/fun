<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Flearch : Flickr Search : Home</title>
	
	<meta name="description" content="flickr search, flearch">
	<meta name="author" content="Ajay Ranipeta">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
	<link href="http://fonts.googleapis.com/css?family=Coda&subset=latin" rel="stylesheet" type="text/css">
	<?php echo $this->Html->css('styles'); ?>
</head>
<body>
	<div id="container">
		<header id="header">
			<h1>Flearch : Flickr Search</h1>
		</header>
		
		<section id="content">
			<?php echo $content_for_layout; ?>
			<div class="clear"></div>
		</section>
		
		<footer id="footer">
        <div id="copyr">Copyright &copy; <a href="http://aggregatedsolutions.com/">Aggregated Solutions</a> 2012.</div>
    </footer>
	
	</div> <!--! end of #container -->
	
</body>
</html>