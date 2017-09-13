<?php 
if(isset($_POST['upload'])){
 //check if files are empty
 if(!empty($_FILES['files']['name'][0])){
 	$files = $_FILES['files'];
 	//Create new opject
 	$zip = new ZipArchive;
 	//create file loop for multiple files
   foreach($files['name'] as $key => $filename){
	$fileTmp   = $files['tmp_name'][$key];
	$fileSize  = $files['size'][$key];
	$errors    = $files['error'][$key];
	//get file extensions----------//
	$ext = explode('.', $filename);//
	$ext = strtolower(end($ext));///
	//create zip file name
	$zip_name = time().".zip";
	//create allowed file extensions arrray 
	$allowed_extensions  = array('txt','jpg','png','gif','svg');
	//check if the file is allowed or not
	if(in_array($ext, $allowed_extensions)){
		//Check for errors
	if($errors ===0){
		//check the file sizes (2mb allowed)
		if($fileSize <= 2097152){
			//Generate a unique ID
			$newFilesNames = uniqid('', true) . '.' . $ext;
			//set file root
			$root = 'uploads/' . $newFilesNames;
			//move files to root
			 move_uploaded_file($fileTmp, $root);
			 if($zip->open($zip_name, ZIPARCHIVE::CREATE) === TRUE){
				 $zip->addFile($root,$newFilesNames); 
 				} 				 
			$zip->close();
		}else{
			echo "[$filename] is too large.";
		}
	}
  }else{
		  echo 'The file "'.$filename.'" with the '.$ext.' extension is not allowed';
		}
}//loop end here
	if(file_exists($zip_name)){
	  // push to download the zip
	  header('Content-type: application/zip');
	  header('Content-Disposition: attachment; filename="'.$zip_name.'"');
	  readfile($zip_name);
	  // remove zip file is exists in temp path
	  unlink($zip_name);
 	}
 	//Dalete uploaded the files
	unlink($root); 
   }
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="description" content="Creating files zip arcive using php files like images txt doc and other formats.">
		<meta name="author" content="Aizaz.dinho">
		<meta name="author" content="meralesson.com">
		<title>Create Images Zip Archive Using PHP</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" >
		<link rel="stylesheet" href="css/style.css"/>
  		
  		 
  	</head>
<body>
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Tutorial</a></li>
            <li role="presentation"><a href="#">Download Codes</a></li>
           </ul>
        </nav>
        <h3 class="text-muted">PHP Zipper</h3>
      </div>

      <div class="jumbotron">
        <h2>Create Zip Archive Using PHP</h2>
        <p class="lead">Create Zip Archive using PHP, just upload your files and make zip archive this is an free PHP script made by <a href="https://www.twitter.com/aizazdinho" rel="author">Aizaz.dinho</a> to upload multiple image and create zip file.</p>
        <!--+++++FORM HERE++++++-->
        <form  method="post" enctype="multipart/form-data">
        <input id="uploadFile" placeholder="Choose File" disabled="disabled" />
		  <div class="fileUpload btn btn-primary">#1: Select Files
		   <input  id="uploadBtn" name="files[]" type="file" class="upload" multiple  /> </div>
		  <label class="btn btn-lg btn-success">#2: Create Zip<input type="submit" name="upload" style="display: none;" value="Zip archive" /></label>
		</form>
		<!--+++++FORM END++++++-->
 		</div>
		<script type="text/javascript">
  				document.getElementById("uploadBtn").onchange = function () {
			    document.getElementById("uploadFile").value = this.value;
			};
  		</script>

      <footer class="footer">
        <p>Script created by <a href="http://www.meralesson.com/">&copy; Meralesson</a>. Template powered by <a href="http://getbootstrap.com/examples/jumbotron-narrow/">Bootstrap</a></p>
      </footer>

    </div> <!-- /container -->
</body>
</html>
