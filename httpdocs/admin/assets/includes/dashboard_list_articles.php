<?php if(isset($articles) && $articles ){?>
					<table id="article-list">
							<thead>
							  	<?php if($newCalc){?>
								  	<tr>
								      <th class="align-left">Article Title</th>
								      <th>Date Created</th>
								      <th>US Pageviews</th>
								      <th>Rate</th>
								      <th class="bold align-right">Total Rev</th>
								    </tr>
							  	<?php }else{?>
							    <tr>
							      <th class="align-left">Article Title</th>
							      <th>Date Created</th>
							       <?php if( $show_art_rate ){?>
							     	<th>Article Rate</th>
							      <?php }?>
							      <th>Shares</th>
							      <th>Share Rate</th>
							      <th>Share Rev</th>
							      <th>% U.S. Traffic</th>
							      <th class="bold align-right">Total Rev</th>
							    </tr>
							    <?php }?>
							</thead>
						  	<tbody>
							  	<?php 
							  		$date_updated = '';
							  		$ids = array();
							  		foreach( $articles as $article ){ 
							  			$id = $article['article_id'];
							  			array_push($ids, $id);
							  		}
							  		
							  		$freqs = array_count_values($ids);
							  		$date_updated = date_format(date_create($dateupdated[0]['date_updated']), 'l, F jS Y \a\t h:i:s A');

							  		if( !$newCalc ){
							  		foreach( $articles as $article ){ 
							  		$creation_date = date_format(date_create($article['creation_date']), 'm/d/y');
							  		$month_created = date_format(date_create($article['creation_date']), 'n');
							  		$cat = $article['category'];
							  		$prevMonthData = $dashboard->get_dashboardArticlesPrevMonth($article['article_id'], $last_month, $cat, $last_year);

							  		/*Display just those articles when the shares has changed.*/
							  		if( ( isset($prevMonthData) && $prevMonthData ) && ( isset($article) && $article ) ){
							  			if( $article["facebook_shares"] != $prevMonthData['facebook_shares'] ||
							  				$article['facebook_likes'] != $prevMonthData['facebook_likes'] ||
							  				$article['facebook_comments'] != $prevMonthData['facebook_comments'] ||
							  				$article['twitter_shares'] != $prevMonthData['twitter_shares'] ||
							  				$article['pinterest_shares'] != $prevMonthData['pinterest_shares'] ||
							  				$article['google_shares'] != $prevMonthData['google_shares'] ||
							  				$article['linkedin_shares'] != $prevMonthData['linkedin_shares'] ||
							  				$article['delicious_shares'] != $prevMonthData['delicious_shares'] ||
							  				$article['stumbleupon_shares'] != $prevMonthData['stumbleupon_shares']
							  			){/*Do NOTHING*/}else continue;
							  		}

							  		$facebook_shares = $article['facebook_shares'];
							  		$facebook_likes = $article['facebook_likes'];
							  		$facebook_comments = $article['facebook_comments'];
							  		$twitter_shares = $article['twitter_shares'];
							  		$pinterest_shares = $article['pinterest_shares'];
							  		$googleplus_shares = $article['google_shares'];
							  		$linkedin_shares = $article['linkedin_shares'];
							  		$delicious_shares = $article['delicious_shares'];
							  		$stumbleupon_shares = $article['stumbleupon_shares'];
							  		$article_id = $article['article_id'];
							  		
							  		//How many time the same article is listed.
									$count = $freqs[$article_id];
							  		
							  		//RATE BY ARTICLE 
							  		$rate_by_article = 0;

							  		if( $month_created == $month && $article['rate_by_article'] != 0){
							  			if( $contributor_type > 2) $rate_by_article = $article['rate_by_article'] / $count;
							  			else $rate_by_article = 0;
							  		}

							  		$rate_by_share  = $article['rate_by_share'];
							  		
							  		//TOTAL SHARES
							  		$total_shares_this_month = $facebook_shares + $twitter_shares + $pinterest_shares + $googleplus_shares +
							  								   $linkedin_shares + $delicious_shares + $stumbleupon_shares;

							  		$us_pct_traffic = 0;
							  		$us_traffic = 0;
							  		if(!empty($article['pct_pageviews']) && $article['pct_pageviews'] != 0){
							  			$us_pct_traffic = $article['pct_pageviews']/100;	
							  			$us_traffic = 	$article['pct_pageviews'];	
							  		}	

							  		if($year == 2015 && $month <= 1 || $year < 2015 ){
							  			$us_pct_traffic = 100;
							  			$us_traffic = 100;
							  		}	

							  		if($year == 2015 && $month == 1) $total_shares_this_month = $total_shares_this_month + $facebook_likes + $facebook_comments;

							  		//SHARE RATE  TOTAL SHARES * RATE BY ARTICLE (0.04)			   
							  		$share_rate = $total_shares_this_month * $rate_by_share;

							  		//ARTICLE RATE WILL BE SHOW ONLY ON PREVIEWS MONTH Jan and 2014 months
							  		$share_rev = 0;
							  		if( $show_art_rate ){
										$share_rev += $rate_by_article;
							  		}

							  		if($year == 2015 && $month > 1) $share_rev += ($share_rate * $us_pct_traffic);
							  		else  $share_rev += ($share_rate * 1);

							  		$total_shares += $total_shares_this_month;
							  		$total_share_rate += $share_rate;
							  		$total_article_rate += $rate_by_article;
							  		$total += $share_rev;
							  		$link_to_article = 'http://puckermob.com/'.$article["category"].'/'.$article["article_seo_title"];

							  		if($month_created != $month && $share_rev == 0) continue; 
							  	?>
							    <tr id="article-<?php echo $article['article_id']; ?>">
							      <td class="article align-left"><a href='<?php echo $link_to_article; ?>' target='blank'><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 20); ?></a></td>
							      <td><?php echo $creation_date;?></td>
							      <?php if( $show_art_rate ){?>
							      	<td><?php echo '$'.$rate_by_article;?></td>
							      <?php }?>
							      <td class=""><?php echo number_format($total_shares_this_month, 0, '.', ','); ?></td>
							      <td><?php echo $rate_by_share; ?></td>
							      <td class=""><?php echo '$'.number_format($share_rate, 2, '.', ','); ?></td>
							      <td ><?php echo round($us_traffic, 2).'%'; ?></td>
							      <td class="bold align-right"><?php echo '$'.number_format($share_rev, 2, '.', ','); ?></td>
							    </tr>
							    <?php }?>
							    <tr class="total">
							    	<td class="bold">TOTAL</td>
							    	<td></td>
							    	<?php if($show_art_rate ){?>
							    		<td class="bold"><?php echo '$'.number_format($total_article_rate, 2, '.', ','); ?></td>
							    	<?php }?>
							    	<td class="bold"><?php echo number_format($total_shares, 0, '.', ','); ?></td>
							    	<td></td>
							    	<td class="bold"><?php echo '$'.number_format($total_share_rate, 2, '.', ','); ?></td>
							    	<td></td>
							    	<td class="bold align-right"><?php echo '$'.number_format($total, 2, '.', ','); ?></td>
							    </tr>
							    <?php }else{
								    	$total_page_views = 0;
								  		$us_page_views = 0;
								  		$total_rev = 0;
								  		$total_us_page_views = 0;
								  		$total = 0;
								  	
								  		foreach( $articles as $article ){ 
									  		$creation_date = date_format(date_create($article['creation_date']), 'm/d/y');
									  		$month_created = date_format(date_create($article['creation_date']), 'n');
									  		$cat = $article['cat_dir_name'];
									  		$link_to_article = 'http://puckermob.com/'.$cat.'/'.$article["article_seo_title"];

									  		$total_page_views = $article['pageviews'];
									  		$us_page_views = $article['usa_pageviews'];
									  		$pct_pageviews = $article['pct_pageviews'];
									  		
									  		if( $contributor_type == 6 || $contributor_type == 1 || $contributor_type == 7){
										  		if( $month > 3 && $year >= 2015 ){
										  			 $total_rev = 0;
										  		}else{
										  			if( $us_page_views > 0 ){
									  					$total_rev = ($us_page_views/1000) * $rate['rate'];
									  				}
										  		}
									  		}else{
									  			if( $us_page_views > 0 ){
									  				$total_rev = ($us_page_views/1000) * $rate['rate'];
									  			}
									  		}

									  		$total += $total_rev;
									  		$total_us_page_views += $us_page_views;
								  			?>
										  	<tr id="article-<?php echo $article['article_id']; ?>">
										      <td class="article align-left"><a href='<?php echo $link_to_article; ?>' target='blank'><?php echo $mpHelpers->truncate(trim(strip_tags($article['article_title'])), 20); ?></a></td>
										      <td><?php echo $creation_date;?></td>
										      <td class=""><?php echo number_format($us_page_views, 0, '.', ','); ?></td>
										      <td class=""><?php echo '$'.number_format($rate['rate'], 2, '.', ','); ?></td>
										      <td class="bold align-right"><?php echo '$'.number_format($total_rev, 2, '.', ','); ?></td>
										    </tr>
							  			<?php } ?>
								  		<tr class="total">
									    	<td class="bold">TOTAL</td>
									    	<td></td>
									    	<td class="bold"><?php echo number_format($total_us_page_views, 0, '.', ','); ?></td>
									    	<td class="bold"><?php echo '$'.number_format($rate['rate'], 2, '.', ','); ?></td>
									    	<td class="bold align-right"><?php echo '$'.number_format($total, 2, '.', ','); ?></td>
								    	</tr>
							  	<?php }?>
						  	</tbody>
					</table>
					<?php }else{ ?>
					<section class="columns">
						<p class="notes bold margin-top uppercase">No Records Found!</p>
					</section>
					<?php } ?>