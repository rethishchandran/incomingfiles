
<?php 

if(isset($_POST['submit'])){
    
    function get_random_string($valid_chars, $length)
    {
        $random_string = "";
        $num_valid_chars = strlen($valid_chars);
        for ($i = 0; $i < $length; $i++)
        {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick-1];
            $random_string .= $random_char;
        }
        return $random_string;
    }

    function incoming_files() {
      $files = $_FILES;
      $files2 =array();
      foreach ($files as $input => $infoArr) {
          $filesByInput =array();
          foreach ($infoArr as $key => $valueArr) {
              if (is_array($valueArr)) {
                  foreach($valueArr as $i=>$value) {
                      $filesByInput[$i][$key] = $value;
                  }
              }
              else {
                  $filesByInput[] = $infoArr;
                  break;
              }
          }
          $files2 = array_merge($files2,$filesByInput);
      }
      $files3 = array();
      foreach($files2 as $file) {
          if (!$file['error']) $files3[] = $file;
      }
      return $files3;
    }
    
    echo " Form Posted <br/>";
    $tmpFiles = incoming_files();

    $randomnum = get_random_string("1234567890",5);

    if($tmpFiles!==""&&count($tmpFiles)>0){
      echo " Files received count ".count($tmpFiles)." <br/>";
      foreach ($tmpFiles as $tmpFile ) {
      echo " Trying to upload File :==> ".basename($tmpFile['name'])." <br/>";
      $uploaddir = 'genratedfiles/';
      $tmpfilename= str_replace(' ', '_', basename($tmpFile['name']));
      $uploadfile = $uploaddir . $subject.$randomnum.$tmpfilename;
        if (move_uploaded_file($tmpFile['tmp_name'], $uploadfile)) {
           echo " Uploaded File  :==> ".$uploadfile." <br/>";
        } else {
           echo " Upload failed Filename :==> ".basename($tmpFile['name'])." <br/>";
        }
      }
    }
}
?>
<html>
    <head>
        <title>File Uplod</title>
    </head>
    <body>
        <h1>Submit Form</h1>
        <form method="POST" action="index.php" enctype="multipart/form-data">
            <input type="file" name="myUploadFile1" />
            <input type="file" name="myUploadFile2" />
            <input type="file" name="myUploadFile3" multiple/>
            <button type="submit" name="submit" value="submit"/>
        </form>
    </body>
</html>
