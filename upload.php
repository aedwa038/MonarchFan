<?php


       $uname=     $_POST["username"];
    $iname=     $_FILES['image']['name'];
	$type=     $_FILES['image']['type'];
	$temp=     $_FILES['image']['tmp_name'];
	$size=     $_FILES['image']['size'];
	
	if( $type == 'image/jpeg' ){ $filetype= '.jpg'; }else{ $filetype= str_replace( 'image/', '', $type); }
	if( $type == 'image/png' ){ $filetype= '.png'; }else{ $filetype= str_replace( 'image/', '', $type); }
	if( $type == 'image/gif' ){ $filetype= '.gif'; }else{ $filetype= str_replace( 'image/', '', $type); }
	

	$path=     'multiple/' . $uname . '.'.$filetype;
	$thumb_path=     '/thumb_' . $uname . '.'.$filetype;
   
	$size2= getimagesize( $temp );
	$width= $size2[0];
	$height= $size2[1];
    if(isset($_FILES['image']['tmp_name']))
    {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
         $extension = end(explode(".", $_FILES["image"]["name"]));
		// Number of uploaded files
		
        $num_files = count($_FILES['image']['tmp_name']);
        
        /** loop through the array of files ***/
        for($i=0; $i < $num_files;$i++)
        {
		 //echo $num_files;
		//echo $i .'i';
            // check if there is a file in the array
            if(!is_uploaded_file($_FILES['image']['tmp_name'][$i]))
            {
                $messages[] = 'No file uploaded';
				
            }
            else
            {
			                  $filename= "multiple/".$_FILES['image']['name'] . $user_id  . "_" . $post_id . $i . '.jpg';
							  echo $filename;
                              $copied = move_uploaded_file($_FILES['image']['tmp_name'][$i] , $filename);
							  echo $copied;
			 // copy the file to the specified dir 
                if($copied)
                {
                    
					/*** give praise and thanks to the php gods ***/
                    $messages[] = $_FILES['image']['name'][$i].' uploaded';
				
					
                }
                else
                {
                    /*** an error message ***/
                    $messages[] = 'Uploading '.$_FILES['image']['name'][$i].' Failed';
                }
            }
        }
    }
?>