<?php
//I removed the zip entry as you don't have any code to handle them here.
$valid_formats = array("jpg", "JPG", "jpeg", "png", "gif");
//Edit: compress_image doesn't handle bmp files either, though it would
//easy enough to add with another elseif.
$max_file_size = 1500000; //300 kb
$path = "./img/upload/"; // Upload directory
$count = 0;

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
  echo 'resizeImage() ';
  // Obtain image from given source file.
	if (!$imageb = @imagecreatefromjpeg($sourceImage)) {
		echo 'false';
    return false;
  }
	echo 'pre list ';
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

  $newImage  = str_replace(' ','_',$newImage);

	imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
	echo 'post resampled ';
	imagejpeg($newImage, $targetImage, $quality);
	echo 'post imagejpeg ';

  // Free up the memory.
  imagedestroy($image);
  imagedestroy($newImage);

  return true;
}

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
// Loop $_FILES to execute all files
  foreach ($_FILES['files']['name'] as $f => $name) {     
    echo 'foreach ';
    if ($_FILES['files']['error'][$f] != 0) {
      echo 'error found';
      continue; // Skip file if any error found
    }
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

        $filename = str_replace(" ", "_", $_FILES['files']['tmp_name'][$f]);

        // if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name));

        //All smaller files to be compressed.
        if(is_uploaded_file($_FILES["files"]["tmp_name"][$f])) {
          //Add a '.jpg' to the name because I'm lazy.
          // compress_image($_FILES["files"]["tmp_name"][$f], $path.basename($name).'.jpg', 90);
          echo 'pre-resize ';

          // echo $_FILES["files"]["tmp_name"][$f];
          // $name = str_replace(" ", "_", $name);
          echo $name;

					resizeImage($filename, $path.$name, 1200, 1200);
					// resize_image('max',$_FILES["files"]["tmp_name"][$f],$path.$name.'.jpg',1200,1200);

          echo 'post-resize ';
          $count ++; // Number of successfully uploaded files
        }
      }
    }
  }
  // REDIRECT
  header("HTTP/1.1 303 See Other");
  header("Location: https://$_SERVER[HTTP_HOST]/");
}

?>
