<?php 
	//Get the file
var_dump($_POST); 
	$content = file_get_contents($_POST['url']);
	//Store in the filesystem.
	$fp = fopen($_POST['articleId']."_tall.jpg", "w");
	fwrite($fp, $content);
	fclose($fp);
?>