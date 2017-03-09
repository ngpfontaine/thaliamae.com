<!doctype html>
<html>
	<head>
		<title>Thalia Mae</title>
		<meta charset="utf-8">
		<meta name='theme-color' content='#333'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<meta name='description' content='A damn good pup'>
		<link rel='canonical' href='https://thaliamae.com'>
		<!-- <link rel='stylesheet' href='./css/main.min.css'> -->
		<!-- <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lora:400,400i,700|Open+Sans:400,600'> -->
		<!-- <link href="./css/lightbox.min.css" rel="stylesheet"> -->


	</head>

<body>


	<section id='modal-upload'>
		<div class='modal-bg-blur'></div>
		<div class='modal-inner'>
			<p>
				Please compress and/or resize images before uploading to prevent excess data useage and keep load time down. Thanks!
			</p>
			<p>
				<a href='https://tinypng.com' target='_blank'>tinypng</a><span class='text-aside'>(best compression, use if file size is under 5MB)</span><br>
				<a href='https://compressor.io/compress' target='_blank'>compressor.io</a><span class='text-aside'>(will allow file sizes > 5MB)</span>
			</p>
			<form id='form-upload' action='upload2.php' enctype='multipart/form-data' method='post'>

				<input type='file' id='ul-i-file' name='files[]' class='input-file' data-multiple-caption='{count} files selected' multiple='multiple' accept='image/*''>
				<label for='ul-i-file' class='input-file-label'><i class="fa fa-file-image-o"></i>
					<div id='ul-i-file-text'>Choose file(s)</div>
				</label>

				<div id='ul-i-btn'>Upload <i class="fa fa-paw"></i></div>

			</form>
		</div>
	</section>

</body>

</html>
