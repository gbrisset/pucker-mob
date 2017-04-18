<?php if(!$detect->isMobile()){ ?>
	<div id="header-ad" class="ad-unit hide-for-print padding-top" style="background: #fff !important; margin-top:90px !important">
		<!-- ARTICLES -->
		<?php if(isset($articleInfoObj) && $articleInfoObj){

		        $selected_articles_lelo = array(16562 , 17425 ,14479 ,14576 ,15109 ,15271 ,17286, 8560, 14613 , 15104 ,15284 ,15488, 14873 );
				
				 if(in_array($article_id, $selected_articles_lelo)){

                ?>
					<!-- LELO -->
					<div class="lelo">
						<a href="https://www.lelo.com/hex-condoms-original?utm_source=publisher_puckermob.com&utm_medium=banner&utm_content=&utm_campaign=hex_display" target="_blank">
							<img src="http://www.puckermob.com/assets/img/campaing/lelo_desk.png" />
						</a>
					</div>


				<?php
				 }else{	

		             switch ($article_id) {
					  case 8158: // relationships/8-things-guys-do-that-make-our-hearts-melt
		              case 27296: // moblog/what-time-doesnt-heal-you-have-to-heal-yourself
		              case 23319: // moblog/15-open-letters-to-leave-your-boyfriend
		              case 25829: // moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
		              case 4019: // TEST PAGE DEDICATED TO BETHANY FOR DFP TESTING /relationships/how-to-date-when-you-are-broke
		              case 20506: // contains explicit content - not approved for Undertone - moblog/pssy-eating-101-five-tips-to-taste-delicious

		                //do nothing - we do not want other ads to interfer with the test page
		                break;

		              default:
		                include($config['include_path'] . 'ads/Undertone_DynamicTag.php');
		                
		             }//end switch ($article_id)

				}//end if( in_array($article_id, $selected_articles_lelo)

		 }// end if(isset($articleInfoObj) && $articleInfoObj)?> 
	</div>
<?php } //end if(!$detect->isMobile() ?>
