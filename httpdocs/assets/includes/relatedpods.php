<?php if(isset($relatedPods) && $relatedPods){ ?>
	<section id="related-article-pods">	
		<header>
			<h2>Related Videos by MyPod Studios: <span>Most Recent</span></h2>

			<ul>
				<li class="current" id="1">Most Recent</li>
				<li id="2">Most Popular</li>
				<li id="3">Alphabetical A-Z</li>
				<li id="4">Alphabetical Z-A</li>
			</ul>
		</header>

		<section id="related-article-pods-cont">
			<?php
				$relatedPodIndex = 1;
				foreach($relatedPods['pods'] as $podId => $subArray){
					$podUrl = ($local) ? $config['pod_url'] : $subArray['pod_url'];
					$imageUrl = $mpHelpers->stripUrls($subArray['pod_url'], 'images');
					$pod = '<div class="pod" id="pod'.$relatedPodIndex++.'">';
						$pod .= '<div class="pod-image">';
							$pod .= '<a href="'.$podUrl.'" title="'.explode(':', $subArray['pod_name'])[0].'" target="_blank">';
								$pod .= '<img src="'.$imageUrl.$subArray['pod_html_img'].'" alt="'.explode(':', $subArray['pod_name'])[0].' Image">';
								$pod .= '<div id="play-button">';
									$pod .= '<img src="'.$config['image_url'].'sharedimages/playbutton.png" alt="Play Button">';
								$pod .= '</div>';
							$pod .= '</a>';
						$pod .= '</div>';	
						
						$pod .= '<div class="pod-info" data-title="'.htmlspecialchars($subArray['pod_name']).'" data-desc="'.htmlspecialchars(trim(strip_tags($subArray['pod_desc']))).'">';
							$pod .= '<h2>';
								$pod .= '<a href="'.$podUrl.'" title="'.explode(':', $subArray['pod_name'])[0].'" target="_blank">';
									$pod .= $mpHelpers->truncate($subArray['pod_name'], 50);
								$pod .= '</a>';
							$pod .= '</h2>';

							$pod .= '<p><a href="'.$podUrl.'" target="_blank">'.$mpHelpers->truncate(trim(strip_tags($subArray['pod_desc'])), 150).'</a></p>';
						$pod .= '</div>';

						$pod .= '<div class="visit-pod">';
							$pod .= '<a href="'.$podUrl.'" title="'.explode(':', $subArray['pod_name'])[0].'" target="_blank">';
								$pod .= 'Watch Now';
							$pod .= '</a>';
						$pod .= '</div>';
					$pod .= '</div>';
					echo $pod;
				}
			?>
		</section>

		<div id="loading">
			<img src="<?php echo $config['image_url']; ?>sharedimages/loading.gif" alt="Loading Image">
		</div>
	</section>
<?php } ?>