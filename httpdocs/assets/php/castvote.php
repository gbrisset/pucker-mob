<?php
	require_once('config.php');

	if(!count($_POST) || !isset($_POST['article']) || !isset($_POST['votecast'])){
		echo json_encode(array("haserror" => 1, "response" => "One or more required values were left out."));
		die();
	}

	$articleId = preg_replace('/[^0-9]/' , '', $_POST['article']);
	$voteVal = preg_replace('/[^0-9]/', '', $_POST['votecast']);

	if($articleId > 0 && $voteVal > 0){
		if($r = $mpArticle->recordArticleRating($articleId, $voteVal)){
			$_SESSION['votecast'][$articleId] = $voteVal;
			echo json_encode(array("haserror" => 0, "response" => "Rating added sucuessfully!"));
			die();
		}else{
			echo json_encode(array("haserror" => 1, "response" => "Error inserting vote in database."));
			die();
		}

	}else{
		echo json_encode(array("haserror" => 1, "response" => "Invalid values for one or more required fields."));
		die();
	}
?>