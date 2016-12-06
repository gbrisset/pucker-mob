f<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?php if(isset($pageName) && strlen($pageName)){echo $pageName;}else{echo "Pucker Mob | We're All Part of It";} ?></title>
	<?php 
		$headDesc = $mpArticle->data['article_page_desc'];
		$headTags = $mpArticle->data['article_page_tags'];
	?>
	<meta name="description" content="<?php if(isset($headDesc) && strlen($headDesc)) echo $headDesc; ?>">
	<meta name ="keywords" content="<?php if(isset($headTags) && strlen($headTags)) echo strtolower($headTags); ?>">
	<meta name="author" content="Sequel Media International">
	<meta property="og:url"           content="http://www.puckermob.com" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Pucker Mob | We're All Part of It" />
	<meta property="og:description"   content="General interest news, information, articles and advice for a world on the move" />
	<meta property="og:image"         content="http://images.puckermob.com/articlesites/featured/puckermobfeaturedimage.png" />
	
	<link rel="shortcut icon" href="<?php echo $config['this_url']; ?>assets/img/mini.ico" />
	<link type="text/plain" rel="author" href="<?php echo $config['this_url']; ?>humans.txt" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3.3.2/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/app.css?ver_4456">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/appadmin.css?ver_4459">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/jquery.Jcrop.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/dropzone.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['this_url']; ?>assets/css/tooltipster.css" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Include Editor style. -->
	<link href="<?php echo $config['this_url']; ?>assets/css/froalacss/froala_editor.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $config['this_url']; ?>assets/css/froalacss/froala_style.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/line_breaker.css">
	<link rel="stylesheet" href="<?php echo $config['this_url']; ?>assets/css/froalacss/plugins/char_counter.css">


<script type="text/javascript" src="http://www.puckermob.com/assets/js/modernizr-2.5.3.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['this_url']; ?>assets/js/foundation.min.js"></script>
<script src="<?php echo $config['this_url']; ?>assets/js/dropzone.js"></script>
	 
 
</head>
<?php 
	$blogger =  $pro_blogger =  $admin_user =  $externalWriter = $pro_admin =  $starter_blogger =  $suspended = false;
	if( $adminController->user->data['user_type'] == 3 ||  $adminController->user->data['user_type'] == 8 ||  $adminController->user->data['user_type'] == 9 || $adminController->user->data['user_type'] == 4 || $adminController->user->data['user_type'] == 30 ) $blogger = true;
	if( $adminController->user->data['user_type'] == 8 ) $pro_blogger = true;
	if( $adminController->user->data['user_type'] == 1 ) $pro_admin = true;
	if( $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2 || $adminController->user->data['user_type'] == 6) $admin_user = true;
	if( $adminController->user->data['user_type'] == 7 ) $externalWriter = true;
	if( $adminController->user->data['user_type'] == 30 ) $starter_blogger = true;
	if( $adminController->user->data['user_type'] == 0 ) $suspended = true;
	
?>
