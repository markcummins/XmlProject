
<?php       
      
 ini_set('display_errors',1); 
 error_reporting(E_ALL);  

      
      if (!(isset($_POST['filetype']))){
	$errorMsg = "<br>Sorry, you dont have permissions to access the uploads page.";
	include "download.php";
	}
	
      else{
      
      $filetype = $_POST['filetype'];
      
      $page_title = 'File Upload';
      
      include 'includes/header.php';
      include 'includes/config.php';
	
	echo '<h1>Upload Localisation File</h1>';
	echo '<h2>Upload the converted <i>"'.$filetype.'"</i> localisation file.</h2>';
	echo '<br>';
	
	echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
	echo '<input type="file" name="file" id="file" required><br>';
	echo '<br><input type="submit" class="btn-primary" name="submit" value="Submit">';
	echo  '<input type="hidden" name="filetype" value="'.$filetype.'" />';
	echo '</form>';
      
      
				      #UPLOADED.PHP - (POST)
    
    if (($_SERVER['REQUEST_METHOD']) == 'POST'){

    // if there is a file
      if (isset($_FILES['file']["name"])) {
	$allowedExts = array("xml");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	$timeStamp = date('Y-m-d H:i:s').' - ';
      
      if(!(in_array($extension, $allowedExts))){
		  $errorMsg = "<b><u>Please upload a valid XML file</b></u>";
	    }
      //if there is an error with the file, show an error message
      switch ($_FILES['file'] ['error'])
	      {   case 1:
			$errorMsg = '<p> The file is bigger than this PHP installation allows</p>';
			break;
		  case 2:
			$errorMsg = '<p> The file is bigger than this form allows</p>';
			break;
		  case 3:
			$errorMsg = '<p> Only part of the file was uploaded</p>';
			break;
		  case 4:
			$errorMsg = '<p> No file was uploaded</p>';
			break;
	      }
	
	      
	if (isset($errorMsg)){
	  echo '<br><br><br>'.$errorMsg ;
	  }
	  
	// if there are no errors, upload the file here
	else{
	  
	//Shows Details of File Upload in javascript
	  echo '<input type="button" class="btn-primary" onclick="UploadDetails()" value="Show Details">';
	  
	  $UploadDetails  = "Upload: " . $_FILES["file"]["name"] . "\\n";
	  $UploadDetails .= "Type: " . $_FILES["file"]["type"] . "\\n";
	  $UploadDetails .= "Size: " . ($_FILES["file"]["size"] / 1024) . " kB\\n";
	  $UploadDetails .= "Stored in: " . "upload/" . $timeStamp.$filetype;
	  
	  if (file_exists($uploadFolder . $_FILES["file"]["name"]))
	    {
	    echo $_FILES["file"]["name"] . " already exists. ";
	    }
	    
	  else{
	    $UploadedFileLoc = $uploadFolder . $timeStamp . $filetype;
	    move_uploaded_file($_FILES["file"]["tmp_name"], $UploadedFileLoc);
	    
	    //displays details
	    echo '<script>function UploadDetails(){alert ( "'. $UploadDetails .'");}</script>'; 
	    
	    
	    $file1 = $path.$filetype;
	    $file2 = $UploadedFileLoc;
	    
	    include 'merge.php';
	    
	    }
	  }
      }
    }
    }
?>

</body>
