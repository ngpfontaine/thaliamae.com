<!doctype html>
<html>
	<head>
		<title>Thalia Mae</title>
		<meta charset="utf-8">
		<meta name='theme-color' content='#333'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<meta name='description' content='A damn good pup'>
		<link rel='canonical' href='https://thaliamae.com'>
		<link rel='stylesheet' href='./css/main.min.css'>
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lora:400,400i,700|Open+Sans:400,600'>
		<link href="./css/lightbox.min.css" rel="stylesheet">

		<script>
		  // var cb = function() {
		  // var l01 = document.createElement('link');
		  // l01.rel = 'stylesheet';
		  // l01.href = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css';
		  // var l02 = document.createElement('link');
		  // l02.rel = 'stylesheet';
		  // l02.href = './css/lightbox.min.css';
		  // var l03 = document.createElement('link');
		  // l03.rel = 'stylesheet';
		  // l03.href = 'https://fonts.googleapis.com/css?family=Lora:400,400i,700|Open+Sans:400,600';

		  // var h = document.getElementsByTagName('head')[0];
		  // h.appendChild(l01);
		  // };
		  // var raf = requestAnimationFrame || mozRequestAnimationFrame ||
		  // webkitRequestAnimationFrame || msRequestAnimationFrame;
		  // if (raf) raf(cb);
		  // else window.addEventListener('load', cb);
		</script>


	</head>

<body>

	<div class='body-bg-tile'></div>

	<div id='loader'>
		<i class="fa fa-spinner loader-spin"></i>
		<div class='load-msg'>loading cuteness..<span class='dot-blinking'>.</span></div>
	</div>

	<div id='container-blur'>

	<header>
		<div class='header-bg-tile'></div>
		<nav>
			<div class='nav-mid'>
				<h1><a href='./'>Thalia Mae</a></h1>
				<!-- <h1><a href='./'>Heading</a></h1> -->
				<h4>August 2012 - Feb. 18 2017</h4>
				<!-- <h4>Heading</h4> -->
			</div><div class='nav-right clear-fix'>
				<span id='btn-about' class='link noselect'>ABOUT</span>
				<span class='btn' id='btn-upload'>UPLOAD <i class="fa fa-upload"></i></span>
			</div>
			<div class='clear-fix'></div>
		</nav>
	</header>

	<article id='fig-container'>

		<?php
		$lbNo = 0;
		$folder = './img/upload/';
		$filetype = '*.*';    
		$files = glob($folder.$filetype);    
		$total = count($files);
		$per_page = 9;
		$last_page = (int)($total / $per_page);
		echo '<script>var pagesNo = ' . $last_page . ';</script>';
		// ADD A PAGE IF ANY ORPHANS
		if (($total % $per_page) > 0) {
			$last_page += 1;
		}
		if (isset($_GET["p"])  && ($_GET["p"] <=$last_page) && ($_GET["p"] > 0) ) {
	    $page = $_GET["p"];
	    // $offset = ($per_page + 1)*($page - 1);
	    $offset = ($per_page)*($page - 1);
	    // INCs ONE TOO MANY TIMES BETWEEN PAGES FOR SOME REASON
	    // if ($_GET["page"] > 1) {
	    // 	$offset = $offset - ($_GET['page'] - 1);
	    // 	echo $_GET['page'];
	    // }
		}
		else {
	    echo " <script>console.log('php - page out of range showing results for page one');</script> ";
	    $page=1;
	    $offset=0;      
		}    
		$max = $offset + $per_page;    
		if ($max>$total) {
		  $max = $total;
		}

		// LOG PAGIN INFO
		echo "<script>console.log('php - processsing page : $page offset: $offset max: $max total: $total last_page: $last_page');</script>";        

		// show_pagination($page, $last_page);        
		for ($i = $offset; $i< $max; $i++) {
	    $file = $files[$i];
	    $path_parts = pathinfo($file);
	    $filename = $path_parts['filename'];        
	    // echo ' <figure class="fake">'. $filename . '</figure> ';

	  	$lbNo++;

	  	// FIGURES
	    echo "<figure><a class='img' style='background-image:url(\"" . $file . "\");' href=\"" . $file . "\" data-lightbox='image-" . $lbNo . "' alt='".$filename."'' ></a></figure>";

		} 

		// PAGINATION CONTROLS
		show_pagination($page, $last_page);

		function show_pagination($current_page, $last_page){
	    echo '<div id="container-pagin"><div id="container-pagin-paw"></div>';
		    if( $current_page > 1 ){
		      echo " <a href='?p=".($current_page-1)."' class='pagin-ctrl show' id='pagin-prev'><i class='fa fa-chevron-left'></i></a> ";
		    }
		    if( $current_page < $last_page ){
		      echo " <a href='?p=".($current_page+1)."' class='pagin-ctrl show' id='pagin-next'><i class='fa fa-chevron-right'></i></a> ";
		    }
	    echo '</div>';
		}

		?>

	</article>

	<aside id='modal-about'>

		<div id='about-close' class='btn-close'>
			<i class="fa fa-times-circle-o"></i>
		</div>

	<div class='aside-inner'>

		<h3>Sweet, Nervous Little Dingus</h3>
		
		<p>
			Thalia was dopey, awkward, growled at her own reflection, walked around when she pooped, and ate mail sometimes. It took her time to come around to a new person, but she was iteratively improving each time. She was skittish on walks in-town, regularly had an upset stomach, and took up an unreasonable amount of room in the bed; but we wouldn't have her any other way.
		</p>
		<p>
			She was the best climbing, trail-running, napping, tv-watching, coding, even bathing (one weird time) - partner. We're just thankful we could give the "abandoned litter-runt who no one wanted to adopt" a warm home, smelly food, and some great memories.
		</p>

		<hr>

		<h3>Thank You</h3>

		<p>
			During the quick onset of Thalia's condition we made the decision to not get carried away trying to explore every possible option that may or may not produce any diagnostic information while her suffering and time spent scared and alone was extended. We received amazing support from family and friends to help with the medical costs accrued in easing her comfort and gaining enough information to make a decision, and are forever grateful to the following:
		</p>

		<p class='text-italic'>
			Robin Alexix, Art Bendixen, Briana Buss, Mark Fontaine, Nancy Fontaine, Ryan Fontaine &amp; Erick Ortiz, Jennifer Hoehne, Cecile Parker, Mike &amp; Sarah Powers, Nancy Powers-Kirsch, Frank Rohter, Kim Rohter, Megan Skop, Nathan Skop, Carolyn Stalvey, Haley Stewart Carson, Rachel Tutwiler.
		</p>

		<hr>

		<h3>Website</h3>
		<p>
			I (Nic) made this site to give myself something productive to do as a distraction, to collect and showcase some memories of our pup, and as a excuse to learn a little php. The site code is available at this <a href='https://github.com/ngpfontaine/thaliamae.com' target="_blank">github repo</a>.
		</p>
	</div>
	</aside>

	</div>

	<section id='modal-upload'>
		<div id='upload-close' class='btn-close'>
			<i class="fa fa-times-circle-o"></i>
		</div>
		<div class='modal-bg-blur'></div>
		<div class='modal-inner'>
			<p>
				Images compress and resize automatically now. Processing time may take a few moments if multiple large images are uploaded.
			</p>
			<!-- <p>
				<a href='https://tinypng.com' target='_blank'>tinypng</a><span class='text-aside'>(best compression, use if file size is under 5MB)</span><br>
				<a href='https://compressor.io/compress' target='_blank'>compressor.io</a><span class='text-aside'>(will allow file sizes > 5MB)</span>
			</p> -->
			<form id='form-upload' action='upload.php' enctype='multipart/form-data' method='post'>

				<input type='file' id='ul-i-file' name='files[]' class='input-file' data-multiple-caption='{count} files selected' multiple='multiple' accept='image/*''>
				<label for='ul-i-file' class='input-file-label'><i class="fa fa-file-image-o"></i>
					<div id='ul-i-file-text'>Choose file(s)</div>
				</label>

				<div id='ul-i-btn' class='disabled'>Upload <i class="fa fa-paw"></i></div>

			</form>
		</div>
	</section>

	<div id='page-paw-source'><a><i class="fa fa-paw page-paw"></i></a></div>

</body>

<script async src='./js/main.min.js'></script>
<script async src="./js/lightbox-plus-jquery.min.js"></script>

</html>
