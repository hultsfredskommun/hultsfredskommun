<?php 
//Send a generated image to the browser 
create_image($_REQUEST["w"],$_REQUEST["h"]); 
exit; 

function create_image($width = 150, $height = 150) 
{   
    //Create the image resource 
    $image = imagecreatetruecolor($width, $height);  
	
	// exit if fails to create
	if (!$image)
		exit;
		
    //We are making three colors, white, black and gray 
    $white = imagecolorallocate($image, 255, 255, 255); 

    //Make the background black 
    ImageFill($image, 0, 0, $white); 
	imagecolortransparent($image, $white);
  
    //Tell the browser what kind of file is come in 
    header("Content-Type: image/png"); 

    //Output the newly created image in jpeg format 
    imagepng($image); 
    
    //Free up resources
    imagedestroy($image); 
} 
?>