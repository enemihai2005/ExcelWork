<?php

// file used for processing uploads
// reads the file from $_FILES php global variable
// is useful

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
} else {
	// added one line
    echo "Sorry, there was an error uploading your file.";
}