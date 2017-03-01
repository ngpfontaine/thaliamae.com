<!doctype html>
<html>
	<head>
		<title>Thalia Mae</title>
		<meta charset="utf-8">
		<meta name='theme-color' content='#333'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' href='./css/main.css'>
		<link href="./css/lightbox.min.css" rel="stylesheet">

		<script>
		  var cb = function() {
		  var l01 = document.createElement('link');
		  l01.rel = 'stylesheet';
		  l01.href = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css';
		  // var l02 = document.createElement('link');
		  // l02.rel = 'stylesheet';
		  // l02.href = 'https://fonts.googleapis.com/css?family=Source+Code+Pro:400,600';
		  var l03 = document.createElement('link');
		  l03.rel = 'stylesheet';
		  l03.href = 'https://fonts.googleapis.com/css?family=Lora:400,400i,700|Open+Sans:400,600';

		  var h = document.getElementsByTagName('head')[0];
		  // h.parentNode.insertBefore(l, h);
		  h.appendChild(l01);h.appendChild(l03);
		  };
		  var raf = requestAnimationFrame || mozRequestAnimationFrame ||
		  webkitRequestAnimationFrame || msRequestAnimationFrame;
		  if (raf) raf(cb);
		  else window.addEventListener('load', cb);
		</script>


	</head>

<body>

	<div class='body-bg-tile'></div>
	<div id='loader'>
		<i class="fa fa-spinner"></i>
	</div>

	<div id='container-blur'>

	<header>
		<div class='header-bg-tile'></div>
		<nav>
			<!-- <div class='nav-left'></div> --><div class='nav-mid'>
				<!-- <h1>Thalia Mae</h1> -->
				<h1>Heading</h1>
				<!-- <h4>2012 - Feb. 18 2017</h4> -->
				<h4>Subheading</h4>
			</div><div class='nav-right clear-fix'>
				<a href='' class='link'>ABOUT</a>
				<span class='btn' id='btn-upload'>UPLOAD <i class="fa fa-upload"></i></span>
			</div>
			<div class='clear-fix'></div>
		</nav>
	</header>

	<article id='fig-container'>

	<?php 

		$dir = "./img/upload/*.jpg";
		$images = glob( $dir );
		$lbNo = 1;

		foreach( $images as $image ):
		  echo "<figure><a class='img' style='background-image:url(\"" . $image . "\");' href=\"" . $image . "\" data-lightbox='image-" . $lbNo . "' ></a></figure>";
			$lbNo++;

		endforeach;

	?>

	</article>

	</div>

	<section id='modal-upload'>
		<div class='modal-bg-blur'></div>
		<div class='modal-inner'>
			<form id='form-upload'>

				<input type='file' id='ul-i-file' name='file' class='input-file' data-multiple-caption="{count} files selected" multiple>
				<label for='ul-i-file' class='input-file-label'><i class="fa fa-file-image-o"></i>
					<div id='ul-i-file-text'>Choose file(s)</div>
				</label>

				<div id='ul-i-btn'>Upload <i class="fa fa-paw"></i></div>

			</form>
		</div>
	</section>

</body>

<script src='./js/main.js'></script>
<script async src="./js/lightbox-plus-jquery.min.js"></script>

</html>
