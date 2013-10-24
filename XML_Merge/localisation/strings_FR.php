<body>

<?php
include 'includes/header.php';


$dh = '.';
$path = realpath($path).'/localisation';

  if ($handle = opendir($path)) {
  echo '<form action=http://127.0.0.1/solas-match/mark/download.php method=post>
	<select name="langSelect" onchange="this.form.submit();">
	<option value="0">--Select Language--</option>';
    while (false !== ($file = readdir($handle))) {
    
      if ($file != '.' and $file != '..' and filetype($path.'/'.$file) == 'file') {
      print "<option value='$file'>$file</option>";
      }
    }
    
    echo '</select></form>';
  closedir($handle);
  print "<p>Done reading $path</p>\n";    
  }
  
  else {
  print "<p>Unable to open directory: $path</p>\n";
  }

?> 

<?php
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ){
    echo '<a href="http://127.0.0.1/solas-match/mark/localisation/'.$_POST['langSelect'].'" download="'.$_POST['langSelect'].'">Download: '.$_POST['langSelect'].'</a> &nbsp;&nbsp;';
    echo '<a href="http://127.0.0.1/solas-match/mark/upload.php"> Upload File </a>';
    }

?>

</body>
 
