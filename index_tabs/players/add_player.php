	<?php
	$E_name = $_POST["E_name"];
	$version = $_POST["version"];
	$C_name = $_POST["C_name"];
	$rating = $_POST["rating"];

	// modify database
	$sql = 'INSERT INTO players(E_name, version, C_name, rating) VALUES("'.$E_name.'", "'.$version.'", "'.$C_name.'", '.$rating.')';
	$conn->query($sql);
	$id = $conn->insert_id;

	// upload photo
	$uploaded_card = $_FILES["photo"]["tmp_name"];
	$src = imagecreatefrompng($uploaded_card);
	list($width,$height)=getimagesize($uploaded_card);

	$new_height = 90;
	$new_width = ($width/$height)*$new_height;
	$tmp = imagecreatetruecolor($new_width, $new_height);
	
	imagealphablending($tmp, false);
	imagesavealpha($tmp, true);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	$target_dir = "images/photos/";
	$target_file = $target_dir.$id.'.'.pathinfo($_FILES["photo"]["name"],PATHINFO_EXTENSION);
	imagepng($tmp, $target_file, 9);
	imagedestroy($src);
	imagedestroy($tmp);


	// upload card
	$uploaded_card = $_FILES["card"]["tmp_name"];
	$src = imagecreatefrompng($uploaded_card);
	list($width,$height)=getimagesize($uploaded_card);

	$new_height = 200;
	$new_width = ($width/$height)*$new_height;
	$tmp = imagecreatetruecolor($new_width, $new_height);

	imagealphablending($tmp, false);
	imagesavealpha($tmp, true);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	$target_dir = "images/cards/";
	$target_file = $target_dir.$id.'.'.pathinfo($_FILES["card"]["name"],PATHINFO_EXTENSION);
	imagepng($tmp, $target_file, 9);
	imagedestroy($src);
	imagedestroy($tmp);
	?>