<?php 
//Send a generated image to the browser 
create_image($_REQUEST["w"],$_REQUEST["h"]); 
exit(); 

function create_image($width = 150, $height = 150) 
{   
    //Create the image resource 
    $image = ImageCreate($width, $height);  

    //We are making three colors, white, black and gray 
    $white = ImageColorAllocate($image, 255, 255, 255); 

    //Make the background black 
    ImageFill($image, 0, 0, $white); 
  
    //Tell the browser what kind of file is come in 
    header("Content-Type: image/jpeg"); 

    //Output the newly created image in jpeg format 
    ImageJpeg($image); 
    
    //Free up resources
    ImageDestroy($image); 
} 
?>