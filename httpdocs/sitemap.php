<?php
	Header("Content-type: text/xml");
	require_once('assets/php/config.php');
	$sitemap = $MPNavigation->generateSiteMap();
	//var_dump($sitemap);
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php
		foreach($sitemap as $key => $subArray){
			$url = '<url>';
				$url .= '<loc>'.$subArray['url'].'</loc>';
				$url .= '<lastmod>'.date("Y-m-d").'</lastmod>';
				$url .= '<changefreq>'.$subArray['change'].'</changefreq>';
				$url .= '<priority>'.$subArray['priority'].'</priority>';
			$url .= '</url>';
			echo $url;
		}
	?>
</urlset>