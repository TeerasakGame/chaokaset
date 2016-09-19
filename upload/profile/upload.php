 <?php
 header('Access-Control-Allow-Origin: *');

 //$location = $_POST['directory'];
 //$uploadfile = $_POST['fileName'];
 $file = $_FILES['file']['tmp_name'];
 $path = $_SERVER["DOCUMENT_ROOT"].'/chaokaset/upload/profile/profile_'.$_POST['id'].'.jpg';
 //move_uploaded_file($file, $path);
 //file_put_contents($file, $path);

 if(move_uploaded_file($file, $path)){
         echo 'File successfully uploaded!';
 } else {
         echo 'Upload error!';
 }
 ?>
