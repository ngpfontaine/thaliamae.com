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
		<link href="./css/lightbox.min.css" rel="stylesheet">

		<script>
		  var cb = function() {
		  var l01 = document.createElement('link');
		  l01.rel = 'stylesheet';
		  l01.href = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css';
		  // var l02 = document.createElement('link');
		  // l02.rel = 'stylesheet';
		  // l02.href = './css/lightbox.min.css';
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
			<div class='nav-mid'>
				<h1><a href='./'>Thalia Mae</a></h1>
				<h4>August 2012 - Feb. 18 2017</h4>
			</div><div class='nav-right clear-fix'>
				<span id='btn-about' class='link'>ABOUT</span>
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
		// ADD A PAGE IF ANY ORPHANS
		if (($total % $per_page) > 0) {
			$last_page += 1;
		}
		if (isset($_GET["page"])  && ($_GET["page"] <=$last_page) && ($_GET["page"] > 0) ) {
	    $page = $_GET["page"];
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

		show_pagination($page, $last_page);        
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
	    echo '<div class="container-pagin">';
		    if( $current_page > 1 ){
		      echo " <a href='?page=".($current_page-1)."' class='pagin-ctrl show' id='pagin-prev'><i class='fa fa-chevron-left'></i></a> ";
		    }
		    if( $current_page < $last_page ){
		      echo " <a href='?page=".($current_page+1)."' class='pagin-ctrl show' id='pagin-next'><i class='fa fa-chevron-right'></i></a> ";
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

		<h3>Heading</h3>
		
		<p>
			Ea quaerat ipsam maiores enim provident. Ut cupiditate iusto ut in dignissimos aliquam et. Doloremque facilis autem quo pariatur molestiae fugiat distinctio perspiciatis.
		</p>

		<p>
			Odio non et sapiente in nesciunt voluptatem. Quam deserunt quasi est aut sit sed. Ab voluptatem nulla voluptatem voluptate fugit.
		</p>

		<p>
			Enim minus cumque ducimus velit ducimus. Ut voluptas rerum voluptate iure modi dignissimos. Aut quos rem nisi sequi minima. Quas eos voluptas mollitia. Sunt rerum et eius rerum nihil sint qui qui. Mollitia expedita nostrum consequatur itaque itaque est accusamus aliquid.
		</p>

		<p>
			Rerum eaque aliquid fugiat. Porro culpa ducimus velit aut eum voluptates ipsa qui. Incidunt ut et occaecati non velit voluptas facere ex. Modi accusantium cum rem aut in quasi et dolorum. Rerum ullam eum impedit nulla aut rem.
		</p>

		<p>
			Laudantium ut quo unde saepe est dolor. Est asperiores quia facilis. Tempore soluta voluptatem ex. Autem delectus voluptas consequuntur distinctio ipsum perspiciatis iure. Repellat impedit voluptates illum quisquam.
		</p>

		<p>
			Enim minus cumque ducimus velit ducimus. Ut voluptas rerum voluptate iure modi dignissimos. Aut quos rem nisi sequi minima. Quas eos voluptas mollitia. Sunt rerum et eius rerum nihil sint qui qui. Mollitia expedita nostrum consequatur itaque itaque est accusamus aliquid.
		</p>

		<p>
			Rerum eaque aliquid fugiat. Porro culpa ducimus velit aut eum voluptates ipsa qui. Incidunt ut et occaecati non velit voluptas facere ex. Modi accusantium cum rem aut in quasi et dolorum. Rerum ullam eum impedit nulla aut rem.
		</p>

		<p>
			Laudantium ut quo unde saepe est dolor. Est asperiores quia facilis. Tempore soluta voluptatem ex. Autem delectus voluptas consequuntur distinctio ipsum perspiciatis iure. Repellat impedit voluptates illum quisquam.
		</p>
	</div>
	</aside>

	</div>

	<section id='modal-upload'>
		<div class='modal-bg-blur'></div>
		<div class='modal-inner'>
			<form id='form-upload' action='upload.php' enctype='multipart/form-data' method='post'>

				<input type='file' id='ul-i-file' name='file' class='input-file' data-multiple-caption="{count} files selected" multiple>
				<label for='ul-i-file' class='input-file-label'><i class="fa fa-file-image-o"></i>
					<div id='ul-i-file-text'>Choose file(s)</div>
				</label>

				<div id='ul-i-btn'>Upload <i class="fa fa-paw"></i></div>

			</form>
		</div>
	</section>

</body>

<script async src='./js/main.min.js'></script>
<script async src="./js/lightbox-plus-jquery.min.js"></script>

</html>
