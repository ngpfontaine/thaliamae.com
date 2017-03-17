<?php
echo 'pre require';
require_once("/home/nic/vendor/autoload.php");
echo 'post require';
Tinify\setKey("ZrEIGd3xqQWhLG6n1wlPGnOdsvETz4-M");
echo 'post setKey';

//I removed the zip entry as you don't have any code to handle them here.
$valid_formats = array("jpg", "JPG", "JPEG", "jpeg", "png", "gif");
//Edit: compress_image doesn't handle bmp files either, though it would
//easy enough to add with another elseif.
$max_file_size = 1500000; //300 kb
$path = "./img/upload/"; // Upload directory
$count = 0;

$name_array = $_FILES['files']['name'];
$tmp_name_array = $_FILES['files']['tmp_name'];
// Number of files
$count_tmp_name_array = count($tmp_name_array);


// We define the static final name for uploaded files (in the loop we will add an number to the end)
$static_final_name = "name";

// for($i = 0; $i < $count_tmp_name_array; $i++){
  // $extension = pathinfo($name_array[$i] , PATHINFO_EXTENSION);
  // $name_array[$i] = str_replace(" ","_",$name_array[$i]);
  // echo 'tmp_name_array';
  // echo $name_array[0];
// }

function tin($sourceImg,$targetImg,$maxWidth,$maxHeight) {
  echo 'tin()';
  $source = \Tinify\fromFile($sourceImg);
  $source->toFile($targetImg);

  // $resized = $source->resize(array(
  //   "method" => "fit",
  //   "width" => $maxWidth,
  //   "heigth" => $maxHeight
  // ));
  // $resized->toFile($targetImg);

  return true;
}

/**
 * Resize image - preserve ratio of width and height.
 * @param string $sourceImage path to source JPEG image
 * @param string $targetImage path to final JPEG image file
 * @param int $maxWidth maximum width of final image (value 0 - width is optional)
 * @param int $maxHeight maximum height of final image (value 0 - height is optional)
 * @param int $quality quality of final image (0-100)
 * @return bool
 * Example:
 * resizeImage('image.jpg', 'resized.jpg', 200, 200);
*/
function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 80) {
  echo 'sourceImage ';
  echo $sourceImage;
  echo ' targetImage ';
  echo $targetImage;
  // Obtain image from given source file.
	if (!$image = @imagecreatefromjpeg($sourceImage)) {
		echo 'false';
    return false;
  }
	echo ' pre list ';
  // Get dimensions of source image.
  list($origWidth, $origHeight) = getimagesize($sourceImage);

  if ($maxWidth == 0) {
    $maxWidth  = $origWidth;
  }

  if ($maxHeight == 0) {
    $maxHeight = $origHeight;
  }

  // Calculate ratio of desired maximum sizes and original sizes.
  $widthRatio = $maxWidth / $origWidth;
  $heightRatio = $maxHeight / $origHeight;

  // Ratio used for calculating new image dimensions.
  $ratio = min($widthRatio, $heightRatio);

  // Calculate new image dimensions.
  $newWidth  = (int)$origWidth  * $ratio;
  $newHeight = (int)$origHeight * $ratio;
	echo 'pre true color ';
  // Create final image with new dimensions.
	$newImage = imagecreatetruecolor($newWidth, $newHeight);
	echo 'post true color ';

  // $image  = str_replace(' ','_',$image);

	imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
	echo 'post resampled ';

  // CREATE PROGRESSIVE IMG INSTANCE
  // $imageProg = imagecreatefromjpeg($image);
  // imageinterlace($imageProg, true);
  // echo 'post progressive';

	imagejpeg($newImage, $targetImage, $quality);
  // imagejpeg($imageProg, $targetImage, $quality);
	echo 'post imagejpeg ';

  // FREE UP MEMORY
  imagedestroy($image);
  imagedestroy($newImage);
  // imagedestroy($imageProg);

  return true;
}

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
  
  // TRIM SPACES INTO FILES ARRAY
  // (NOTE) THIS SOLVES FOR RESIZING FILES W/ SPACES IN NAME,
  // BUT DOESN'T REMOVE SPACES FROM DESTINATION FILE NAME
  $filesTrimmed = array_map('trim',$_FILES['files']['name']);
  // $filesTrimmed = array_map(function($el) { return str_replace(' ','-',$el); }, $_FILES['files']['name'];

  // LOOP $_FILES TO EXECUTE ALL FILES
  // foreach ($_FILES['files']['name'] as $f => $name) {     
  foreach ($filesTrimmed as $f => $name) {
    echo 'foreach ';
    // if ($_FILES['files']['error'][$f] != 0) {
    //   echo 'error found';
    //   continue; // Skip file if any error found
    // }
    if ($_FILES['files']['error'][$f] == 0) {
      echo 'no error ';
      if ($_FILES['files']['size'][$f] > $max_file_size ) {
        $message[] = "$name is too large!";
        echo 'too large ';
        continue; // Skip large files.
      }
      elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
        $message[] = "$name is not a valid format";
        echo 'not valid format ';
        continue; // Skip invalid file formats
      }
      else { // No error found! Move uploaded files 
        echo 'no error2 ';

        $filename = str_replace(" ", "-", $_FILES['files']['name'][$f]);
        // $res = copy($_FILES['files']['tmp_name'][$f], $path.$filename);

        // JUST CREATE AN IMAGE FOR EACH
        // move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$filename);

        //All smaller files to be resized
        if(is_uploaded_file($_FILES["files"]["tmp_name"][$f])) {
          echo 'path . name ';

          echo $path.$name;

					// resizeImage($_FILES["files"]["tmp_name"][$f], $path.$name, 1200, 1200);
          // resize_image('max',$_FILES["files"]["tmp_name"][$f],$path.$name.'.jpg',1200,1200);

          // REPLACE DESTINATION PATH NAME " " W/ - char
          // resizeImage($_FILES["files"]["tmp_name"][$f], str_replace(" ","-",$path.$name), 1200, 1200, 80);

          // TINIFY FILE
          tin($_FILES["files"]["tmp_name"][$f], str_replace(" ","-",$path.$name), 1200, 1200);

          echo 'post-resize ';
          $count ++; // Number of successfully uploaded files
        }
      }
    }
  }

  // REDIRECT
  // header("HTTP/1.1 303 See Other");
  // header("Location: https://$_SERVER[HTTP_HOST]/");
}

?>
