<?php

session_start();
$name = '';

if(isset($_COOKIE['signed_in']) && $_COOKIE['signed_in'] == true)
{

	$name = $_COOKIE['username'];
	$id = $_COOKIE['id'];
	$acess = $_COOKIE['level'];


}

require("config.php");
$mysqli = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or
die ("could not connect to database.");
	    $uploadDir = 'multiple/';
//Image upload
if(isset($_POST['submit'])) {

    $image = array();

    foreach($_FILES['image']['name'] as $index => $name) 
	{
		

        if($_FILES['image']['error'][$index] == 4) {
            continue;
        }

        if($_FILES['image']['error'][$index] == 0) {
			
			$temp= $_FILES;
            $fileName = $_FILES['image']['name'][$index];
            $tmpName  = $_FILES['image']['tmp_name'][$index];
            
			$fileSize = $_FILES['image']['size'][$index];
            $fileType = $_FILES['image']['type'][$index];

           //if(($fileType == "image/gif"   || $fileType == "image/jpeg"  || $fileType == "image/pjpeg" || $fileType == "image/png"   || $fileType == "image/x-png") && $fileSize < 500000) {

                $imagePath = $uploadDir . $fileName;
				
			//	echo $fileName.'----'.$tmpName.'--->'.$imagePath;
                $result = move_uploaded_file($tmpName, $imagePath);
                if (!$result) {
                    echo "Error uploading";
                    exit;
                }
                $image[] = $imagePath;
				
                $fname= implode(',', $temp['image']['name']);
			//}
        }
    }
	
    // Save images to database
    /*$nbImage = count($image);
    if($nbImage) {

        $sql = "INSERT INTO picture (image1, image2, image3) VALUES (";
        for($i=0; $i<$nbImage; $i++) {
            if($i) $sql .= ",";
            $sql .= "\"".$image[$i]."\"";
        }
        $sql .= ")";

        @mysql_query($sql);
    }*/

		  




if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//the form hasn't been posted yet, display it
	echo " No Reply submited";
}

$reply = $_POST['reply'];
$topic_id = $_POST['topic_id'] ;

//$reply = $mysqli->real_escape_string($reply);


 if ($reply == '')
 {
		echo "No reply was posted";
		
 }
 
 else 
 {
//echo $reply;
//echo $topic_id;
//echo "<br>";
//echo $id;

$sql = "INSERT INTO	posts(post_content, post_date, post_topic, post_by,image_path) VALUES ('" . $mysqli->real_escape_string($reply) . "', NOW()," . $topic_id . ",". $id.",'" . $fname ."')";

$result = $mysqli->query($sql) or die("error");
$sql1 = "select user_email email from users U, (select sub_by from subscribe where sub_to = $id) A where U.user_id = A.sub_by";
$result = $mysqli->query($sql1);
$row = $result->fetch_assoc();


	       $to = $row['email'];
            		   
		  $subject = "Mail of Subscription";  
          $message = "Your subscribed user has posted\r\rPlease check the forum for more details!!! .";
          $header = 'From: Monarch Forums' . "\r\n" .

          'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" .

            'X-Mailer: PHP/' . phpversion();    
            		
     
           mail($to, $subject, $message, $header);
		   
	}

header("location:topic.php?id=". $topic_id );

}

?>