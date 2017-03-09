<?php
//I removed the zip entry as you don't have any code to handle them here.
$valid_formats = array("jpg", "JPG", "jpeg", "png", "gif");
//Edit: compress_image doesn't handle bmp files either, though it would
//easy enough to add with another elseif.
$max_file_size = 1500000; //300 kb
$path = "./img/upload/"; // Upload directory
$count = 0;

// Compress the image files
function compress_image($source_url, $destination_url, $quality) {
  echo $destination_url . ' ';
  $info = getimagesize($source_url);

  if ($info['mime'] == 'image/jpeg') {
    echo 'image is a jpeg ';
    $image = imagecreatefromjpeg($source_url);
  }
  elseif ($info['mime'] == 'image/gif') {
    $image = imagecreatefromgif($source_url);
  }
  elseif ($info['mime'] == 'image/png') {
    $image = imagecreatefrompng($source_url);
  }
  echo 'foo ';
  // save file
  imagejpeg($image, $destination_url, $quality);
  echo 'bar ';
  // return destination file
  return $destination_url;
}

/**
 * Resize image - preserve ratio of width and height.
 * @param string $sourceImage path to source JPEG image
 * @param string $targetImage path to final JPEG image file
 * @param int $maxWidth maximum width of final image (value 0 - width is optional)
 * @param int $maxHeight maximum height of final image (value 0 - height is optional)
 * @param int $quality quality of final image (0-100)
 * @return bool
 */
function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 80) {
  echo 'resizeImage() ';
  // Obtain image from given source file.
	if (!$image = @imagecreatefromjpeg($sourceImage)) {
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
	imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
	echo 'post resampled ';
	imagejpeg($newImage, $targetImage, $quality);
	echo 'post imagejpeg ';

  // Free up the memory.
  imagedestroy($image);
  imagedestroy($newImage);

  return true;
}

function resize_image($method,$image_loc,$new_loc,$width,$height) {
  if (!is_array(@$GLOBALS['errors'])) { $GLOBALS['errors'] = array(); }
  
  if (!in_array($method,array('force','max','crop'))) { $GLOBALS['errors'][] = 'Invalid method selected.'; }
  
  if (!$image_loc) { $GLOBALS['errors'][] = 'No source image location specified.'; }
  else {
    if ((substr(strtolower($image_loc),0,7) == 'http://') || (substr(strtolower($image_loc),0,7) == 'https://')) { /*don't check to see if file exists since it's not local*/ }
    elseif (!file_exists($image_loc)) { $GLOBALS['errors'][] = 'Image source file does not exist.'; }
		$extension = strtolower(substr($image_loc,strrpos($image_loc,'.')));
		echo $image_loc;
    if (!in_array($extension,array('.jpg','.JPG','.JPEG','.jpeg','.png','.gif','.bmp'))) { $GLOBALS['errors'][] = 'Invalid source file extension!'; }
  }
  
  if (!$new_loc) { $GLOBALS['errors'][] = 'No destination image location specified.'; }
  else {
    $new_extension = strtolower(substr($new_loc,strrpos($new_loc,'.')));
    if (!in_array($new_extension,array('.jpg','.JPG','.JPEG','.jpeg','.png','.gif','.bmp'))) { $GLOBALS['errors'][] = 'Invalid destination file extension!'; }
  }

  $width = abs(intval($width));
  if (!$width) { $GLOBALS['errors'][] = 'No width specified!'; }
  
  $height = abs(intval($height));
  if (!$height) { $GLOBALS['errors'][] = 'No height specified!'; }
  
  if (count($GLOBALS['errors']) > 0) { echo_errors(); return false; }
  
  if (in_array($extension,array('.jpg','.jpeg'))) { $image = @imagecreatefromjpeg($image_loc); }
  elseif ($extension == '.png') { $image = @imagecreatefrompng($image_loc); }
  elseif ($extension == '.gif') { $image = @imagecreatefromgif($image_loc); }
  elseif ($extension == '.bmp') { $image = @imagecreatefromwbmp($image_loc); }
  
  if (!$image) { $GLOBALS['errors'][] = 'Image could not be generated!'; }
  else {
    $current_width = imagesx($image);
    $current_height = imagesy($image);
    if ((!$current_width) || (!$current_height)) { $GLOBALS['errors'][] = 'Generated image has invalid dimensions!'; }
  }
  if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); echo_errors(); return false; }

  if ($method == 'force') { $new_image = resize_image_force($image,$width,$height); }
  elseif ($method == 'max') { $new_image = resize_image_max($image,$width,$height); }
  elseif ($method == 'crop') { $new_image = resize_image_crop($image,$width,$height); }
  
  if ((!$new_image) && (count($GLOBALS['errors'] == 0))) { $GLOBALS['errors'][] = 'New image could not be generated!'; }
  if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); echo_errors(); return false; }
  
  $save_error = false;
  if (in_array($extension,array('.jpg','.jpeg'))) { imagejpeg($new_image,$new_loc) or ($save_error = true); }
  elseif ($extension == '.png') { imagepng($new_image,$new_loc) or ($save_error = true); }
  elseif ($extension == '.gif') { imagegif($new_image,$new_loc) or ($save_error = true); }
  elseif ($extension == '.bmp') { imagewbmp($new_image,$new_loc) or ($save_error = true); }
  if ($save_error) { $GLOBALS['errors'][] = 'New image could not be saved!'; }
  if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); @imagedestroy($new_image); echo_errors(); return false; }

  imagedestroy($image);
  imagedestroy($new_image);
  
  return true;
}

function echo_errors() {
  if (!is_array(@$GLOBALS['errors'])) { $GLOBALS['errors'] = array('Unknown error!'); }
  foreach ($GLOBALS['errors'] as $error) { echo '<p style="color:red;font-weight:bold;">Error: '.$error.'</p>'; }
}

/**
 * Example
 * resizeImage('image.jpg', 'resized.jpg', 200, 200);
*/

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

        // if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name));

        //All smaller files to be compressed.
        if(is_uploaded_file($_FILES["files"]["tmp_name"][$f])) {
          //Add a '.jpg' to the name because I'm lazy.
          // compress_image($_FILES["files"]["tmp_name"][$f], $path.basename($name).'.jpg', 90);
          echo 'pre-resize ';
          // echo $path.$name;
          echo $_FILES["files"]["tmp_name"][$f];
					resizeImage($_FILES["files"]["tmp_name"][$f], $path.$name, 1200, 1200);
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
