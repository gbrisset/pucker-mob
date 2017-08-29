<?php
	require_once('config.php');
	require_once ('class.SocialMediaManage.php');

	$socialmedia = new SocialMediaManage($config);
	
	$urls = $_GET['urls'];
	$urls = explode(";", $_GET['urls']);
	var_dump($urls);
	$fb_shares = $fb_likes = $fb_comments = $twitter = $pinterest = $stumbleUpon = $googleplus = $delicious = $linkedIn = 0;
	
	if($urls){
		

?>
<html>
	<head>
		<title>Social Media Network Shares</title>
		<style>
		table{ border: 1px solid #ddd; padding: 0.5rem; }
		thead td{ text-transform: uppercase; font-size: 16px;}
		tr {
		display: table-row;
		vertical-align: inherit;
		border-color: inherit;
		padding:1rem;
		}
		td, th {
		display: table-cell;
		vertical-align: inherit;
		padding:0.5rem;
		border: 1px solid #ddd;
		}
		</style>
	</head>
	
	<body>

		<table style="border: 1px solid #ddd;">
			<thead>
				<tr>
					<td>Url</td>
					<td>Facebook Shares</td>
					<td>Facebook Likes</td>
					<td>Facebook Comments</td>
					<td>Twitter</td>
					<td>Pinterest</td>
					<td>StumbleUpon</td>
					<td>Google +1</td>
					<td>Delicious</td>
					<td>LinkedIn</td>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach($urls as $url){
					$result = $socialmedia->extractDataFromSocialMediaNetworks($url);
					if($result){
						$fb_shares = $result['Facebook']['share_count'];
						$fb_likes = $result['Facebook']['like_count'];
						$fb_comments = $result['Facebook']['comment_count'];
						$twitter = $result['Twitter'];
						$pinterest = $result['Pinterest'];
						$stumbleUpon = $result['StumbleUpon'];
						$googleplus = $result['GooglePlusOne'];
						$delicious = $result['Delicious'];
						$linkedIn = $result['LinkedIn'];
					}
					//var_dump($results);
					
				
				
				?>
				<tr>
					<td><?php echo $url; ?></td>
					<td><?php echo $fb_shares; ?></td>
					<td><?php echo $fb_likes; ?></td>
					<td><?php echo $fb_comments; ?></td>
					<td><?php echo $twitter; ?></td>
					<td><?php echo $pinterest; ?></td>
					<td><?php echo $stumbleUpon; ?></td>
					<td><?php echo $googleplus; ?></td>
					<td><?php echo $delicious; ?></td>
					<td><?php echo $linkedIn; ?></td>
				</tr>
				<?php }?>
			</tbody>
			
		</table>
	</body>
</html>
<?php }?>