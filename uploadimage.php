<?php

 
    
    $uname=     $_POST["username"];
    $iname=     $_FILES['image']['name'];
	$type=     $_FILES['image']['type'];
	$temp=     $_FILES['image']['tmp_name'];
	$size=     $_FILES['image']['size'];
	
	if( $type == 'image/jpeg' ){ $filetype= '.jpg'; }else{ $filetype= str_replace( 'image/', '', $type); }
	if( $type == 'image/png' ){ $filetype= '.png'; }else{ $filetype= str_replace( 'image/', '', $type); }
	if( $type == 'image/gif' ){ $filetype= '.gif'; }else{ $filetype= str_replace( 'image/', '', $type); }
	

	$path=     'uploads/' . $uname . '.'.$filetype;
	$thumb_path=     'uploads/thumb_' . $uname . '.'.$filetype;
   
	$size2= getimagesize( $temp );
	$width= $size2[0];
	$height= $size2[1];
     
	//requirements
	/*$maxwidth= 1281;
	$maxheight= 721;
	$allowed=  array( 'image/jpeg' , 'image/png' , 'image/png' );
	
	if( in_array( $type,$allowed ) ){
	
	      if( $width < $maxwidth && $height < $maxheight){
		  
		      if( $size < 10485760 ){
			  
			  //shape 
			  if( $width == $height){$case=1;}
			  if( $width > $height){$case=2;}
		      if( $width < $height){$case=3;}
			  
			  switch( $case ){
			  
			  
			       //square
				   case 1: 
				     
					   $newwidth= 100;
					   $newheight= 100;
					   
					break;   
			  
			      //Lying rectangle
			       case 2:
				   
				      
					  $newheight=  100;
					  $ratio= $newheight / $height;
					  $newwidth= round( $width*$ratio );
					  
					  
			       
				      break;
				   //Standing rectangle
				   case 3:
				   
				       
					     $newwidth= 100;
						 $ratio= $newwidth / $width;
						 $newheight= round( $height*$ratio );
						 
						 
						 
						 break;
				   }
	
*/	
                /*switch( $type ){
     
                  case 'image/jpeg':
				     
					       $img= imagecreatefromjpeg( $temp );
						   $thumb= imagecreatetruecolor( $newwidth , $newheight );
                             		imagecopyresized( $thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
									imagejpeg( $thumb, $thumb_path );
									
								break;
								
								
					case 'image/png':
                           
						   $img= imagecreatefrompng( $temp );
						   $thumb= imagecreatetruecolor( $newwidth , $newheight );
                             		imagecopyresized( $thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
									imagepng( $thumb, $thumb_path );
    

                        break;

                    case 'image/gif':

                              $img= imagecreatefromgif( $temp );
						   $thumb= imagecreatetruecolor( $newwidth , $newheight );
                             		imagecopyresized( $thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
									imagegif( $thumb, $thumb_path );
									
                         break;

                   } */

                    move_uploaded_file( $temp,$path );				   
									
	                echo '<p>Your image has been uploaded. </p>';
					
					/*else{
					
					     echo '<p>Your image doesnot meet the requirements.Picture is too large </p>';
						 
						 }
				}*/
				/*else{
				          echo '<p>Your image is bigger than the allowed resolution. </p>'; echo $size;
						  }
						  
						  }*/
						  
						  
						  
						 
 ?>