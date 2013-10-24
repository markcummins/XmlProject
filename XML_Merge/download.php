<?php
$page_title = 'File Download';
include 'includes/header.php';
include 'includes/config.php';
?>

<script type="text/javascript">
<!--
function go(){
var url= document.languageDDL.example.options[document.languageDDL.example.selectedIndex].value;
open(url);
};
</script>
	
	<h1>Download Localisation File</h1>
	<h2>Download the xml localisation form for conversion.</h2>


<?php
	$thelist = '';

	if ($handle = opendir($path)) {
	    while (false !== ($file = readdir($handle)))
	    {
		if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'xml')
		{	
		    if (($_SERVER['REQUEST_METHOD']) == 'POST'){
		      
			  if(($_POST['langSelect'] == $file)){
			    $thelist .=  '<option value="' .$file. '"selected>' .$file. '</option>';
			  }
			  
			  else{
			  $thelist .=  '<option value="' .$file. '">' .$file. '</option>';
			  }
			
		    }
		    else{
		      $thelist .=  '<option value="' .$file. '">' .$file. '</option>';
		    }
		}

	    }
	    closedir($handle);
	}   
	
	else {
	    $thelist = 'No Files Found';
        }

        if (isset($errorMsg)){
	    echo '<b><u>'.$errorMsg.'</u></b><br><br>';
	  }
?>
	
	<br>
	<form action=download.php method=post >
	<select name="langSelect">
	<!--<option value="0">Select</option>';-->
	<?php echo $thelist;?>
	
	</select><button type="submit">Select</button></form>
	<br><br>

<?php
	if (($_SERVER['REQUEST_METHOD']) == 'POST'){
	  
	  echo '<form action="upload.php" method="post">
		  <input type="submit" class="btn-primary" value="Upload '.$_POST['langSelect'].'">';  
	 

	  echo  '<input type="hidden" name="filetype" value="'.$_POST['langSelect'].'" /></form>';
	  
	  echo '<a href="' .$XMLLink . $_POST['langSelect'].'" download="'.$_POST['langSelect'].'">
		<button type="button" class="btn-primary"> Download '.$_POST['langSelect'].'</button>
		</a>';
		    

	  
	  }
	
?>

<body>