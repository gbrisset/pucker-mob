<?php




// ***********************************
// ***********************************
// ***********************************
// ***********************************
// 	needs to use that header in ads.js to control the inline ads from teh smf_adManager
	// Header("content-type: application/x-javascript");
	// require_once('../../../assets/php/config.php');
// ***********************************
// ***********************************
// ***********************************
// ***********************************

// require_once dirname(__FILE__).'/config.php';//not needed here.

// -- Get the link to articles - useful to create a test page
/*
SELECT 
	a.article_id, 
	CONCAT('/', c.cat_dir_name, '/', a.article_seo_title)
	FROM article_categories ac
	INNER JOIN articles a ON a.article_id =  ac.article_id 
	INNER JOIN categories c ON c.cat_id =  ac.cat_id 
	WHERE a.article_id
	IN (16562 , 17425 ,14479 ,14576 ,15109 ,15271 ,17286, 8560, 14613 , 15104 ,15284 ,15488, 14873 )
*/


// -------------------------------------------------------------------------
// Image management
// ----------------------
// These articles are paid content and should keep their original image
 // 23564: /relationships/dating-pitfalls-avoiding-the-freaks-geeks-and-the-thoroughly-undatable
 // 26139: /moblog/to-the-20-somethings-looking-for-love-check-out-inner-circle

// -------------------------------------------------------------------------
// sponsored_pages_lelo 
// ----------------------
// 8560	/lifestyle/16-pieces-of-advice-to-ignore	
// 14479	/relationships/8-places-to-have-sex-that-you-need-to-try-right-now	
// 14576	/relationships/8-places-to-havefun-like-now	
// 14613	/entertainment/what-you-should-binge-watch-on-netflix-based-on-your-horoscope	
// 14873	/lifestyle/to-every-graduating-senior-whose-afraid-of-whats-next	
// 15104	/moblog/15-christina-yang-quotes-to-live-by	
// 15109	/relationships/lelo-article	
// 15271	/relationships/have-umfun-in-public-and-how-to-get-away-with-it	
// 15284	/lifestyle/finally-a-dating-app-thats-not-all-about-desperate-hook-ups	
// 15488	/relationships/why-we-need-to-stop-waiting-for-the-right-moment	
// 16562	/entertainment/7-things-you-need-for-the-ultimate-netflix-and-chill-night	
// 17286	/relationships/7-steps-only-true-netflix-and-chill-experts-know-to-take	
// 17425	/relationships/the-at-home-hook-up-starter-pack	

// -------------------------------------------------------------------------

// test_pages
// -------------
// 11237 /moblog/girl-whos-just-his-friend
// 23319 /moblog/15-open-letters-to-leave-your-boyfriend

// 25829 /moblog/what-do-you-do-when-you-feel-like-youre-parents-are-happy-for-everyone-else-but-you
// 27296 /moblog/what-time-doesnt-heal-you-have-to-heal-yourself
// 4019  /relationships/how-to-date-when-you-are-broke //TEST PAGE DEDICATED TO BETHANY FOR DFP TESTING 

// 8158  /relationships/8-things-guys-do-that-make-our-hearts-melt
// 8541  /lifestyle/19-reasons-to-date-the-girl-with-no-filter

// These are not test_pages - so when used as such, all other ads are appearing along the test ad
// -------------
// 8700 http://www.puckermob.com/relationships/17-things-that-have-lowered-the-bar-for-romance

require_once dirname(__FILE__).'/Connector.php';



class smf_adManager{

	public $sponsored_pages;
	public $sponsored_pages_lelo;
	public $test_pages;
	public $special_pages;

public function __construct($c){
		$this->config = $c; 
		$this->sponsored_pages = array(); //Placeholder for future content
		$this->sponsored_pages_img = array(23564, 26139); //These articles are paid content and should keep their original image - the array is used only with image management.
		$this->sponsored_pages_lelo = array(16562 , 17425 ,14479 ,14576 ,15109 ,15271 ,17286, 8560, 14613 , 15104 ,15284 ,15488, 14873 );

		$this->test_pages =  array(11237 ,23319 ,25829 ,27296 ,4019 ,8158 ,8541);
		$this->blocked_pages =  array();

		$this->special_pages = array_merge($this->sponsored_pages, $this->test_pages, $this->sponsored_pages_lelo, $this->blocked_pages);//sponsored_pages_img purposely not included here


// -------- Undertone does NOT like to be associated to sexual content ------------------------

		$this->con = new Connector($this->config);

		$pdo = $this->con->openCon();
		$query_string = "
			SELECT article_id
			FROM articles 
			WHERE article_seo_title LIKE \"%sex%\" 
			OR article_seo_title LIKE \"%penis%\" 
			OR article_seo_title LIKE \"%-oral%\"
			OR article_seo_title LIKE \"%orgasm%\"
			OR article_seo_title LIKE \"%squirt%\"
		";

		  $stmt = $pdo->prepare($query_string);
		  $stmt->execute([]) or die('#SQL:4E74DEJ5DDF8SG4D55E7E');
		 
		  $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
		  foreach ($r as  $v) {
		  	$this->sexual_content_pages[]=$v['article_id'];
		  }//end foreach

		// var_dump($sexual_content_pages);

		$this->special_pages_undertone = array_merge($this->sponsored_pages, $this->test_pages, $this->sponsored_pages_lelo, $this->blocked_pages, $this->sexual_content_pages);//sponsored_pages_img purposely not included here

// -------- END of Undertone does NOT like to be associated to sexual content ------------------------



	// SET THE TAGS ===================================================================

	// the $show_on variable imposes the tag on a page - Captain Obvious - 2017-05-03
	// $show_on =  array("all"); //Self explanatory
	// $show_on =  array(00000000);//Test Page - most likely an array of one value but can be  array(00000000, 1111111, 222222)
	// $show_on =  $this->sponsored_pages_lelo;// Sponsored content - use a preset array

	// The $dont_show_on variable prevents the tag to run in concurrence with other tags (useful to test tag without interference or prevent other advertisement)
	// $dont_show_on = array_diff($this->special_pages, $show_on); // do not show on other test/sponsored pages
	// $dont_show_on = array();// no restriction from any other page
	// $this->tag_list[]= array('ad_slot' => "slot_id", 'tag' => "tag_filename.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	

// ----------- DESKTOP -------------------------------------------------------------------------------- DESKTOP ---------------------------------------------
// ----------- DESKTOP -------------------------------------------------------------------------------- DESKTOP ---------------------------------------------
// ----------- DESKTOP -------------------------------------------------------------------------------- DESKTOP ---------------------------------------------


	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	// $lucky = rand(0,100);
	// if ($lucky>0 && $lucky<=20) $this->tag_list[]= array('ad_slot' => "dsk_overlay_top", 'tag' => "undertone_Flex.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// if ($lucky>0 && $lucky<=40) $this->tag_list[]= array('ad_slot' => "dsk_overlay_top", 'tag' => "undertone_SS.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// if ($lucky>40 && $lucky<=100) $this->tag_list[]= array('ad_slot' => "dsk_overlay_top", 'tag' => "undertone_SSFP.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	$show_on =  $this->sponsored_pages_lelo; $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_banner", 'tag' => "dsk_banner_lelo.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_overlay_top", 'tag' => "undertone_SSFP.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on =  array("all"); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_banner", 'tag' => "undertone_BB.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// ----- IMG ----------------------------------
	// image treatment is a bit customized


	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	$show_on = array("all"); $dont_show_on = array();
	// $this->tag_list[]= array('ad_slot' => "dsk_image", 'tag' => "egami_mob_1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_image", 'tag' => 'mbl_img_video_truvidplayer.php', 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_image", 'tag' => "dsk_img_video_truvidplayer_backfill.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	

	// ---------------------------------------

	// These are place holders - there is no such ad slot as of yet - GB 2017-05-03
	// $this->tag_list[]= array('ad_slot' => "dsk_eoa", 'tag' => "XXXXX.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// ---------------------------------------

	$show_on =  $this->sponsored_pages_lelo; $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_ad_stack_1", 'tag' => "dsk_lelo.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_ad_stack_1", 'tag' => "dsk_nativo_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_ad_stack_2", 'tag' => "dsk_answer_AB_tout_rocket.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_ad_stack_3", 'tag' => "dsk_sharethrough.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_ad_stack_4", 'tag' => "mbl_eoa_composite.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	
	// ---------------------------------------

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_sidebar_0", 'tag' => "dsk_sidebar_write_for_us.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on =  $this->sponsored_pages_lelo; $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_sidebar_1", 'tag' => "dsk_sidebar_video_lelo.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_1", 'tag' => "dsk_sidebar_video_answers.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_2", 'tag' => "dsk_sidebar_video_answers_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_3", 'tag' => "dsk_sidebar_carambola.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);

	//DEFY MEDIA - happens to create redirects - delete if no longer in use after november 30 21017 
	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_1", 'tag' => "dsk_defy_media_1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_2", 'tag' => "dsk_defy_media_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_3", 'tag' => "dsk_defy_media_3.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	$this->tag_list[]= array('ad_slot' => "dsk_sidebar_1", 'tag' => "mbl_morebar_amazon_1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_sidebar_2", 'tag' => "mbl_morebar_amazon_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	$this->tag_list[]= array('ad_slot' => "dsk_sidebar_3", 'tag' => "mbl_morebar_amazon_3.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	

	// $this->tag_list[]= array('ad_slot' => "dsk_sidebar_3", 'tag' => "answers_rocketyield_inline_9th_paragraph.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// ---- NEW BROWSER WINDOW or TAB -- (inserted in bottomscript) ----------------------------
	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "mbl_overlay_bottom", 'tag' => "divisionD.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
		

	

// ----------- MOBILE  -------------------------------------------------------------------------------- MOBILE --------------------------------------------
// ----------- MOBILE  -------------------------------------------------------------------------------- MOBILE --------------------------------------------
// ----------- MOBILE  -------------------------------------------------------------------------------- MOBILE --------------------------------------------
	
	// ---- TOP OVERLAY  -----------------------------------
	// $show_on = array(23319); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_overlay_top", 'tag' => "undertone_SS.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	// $lucky = rand(0,100);
	// if ($lucky>0 && $lucky<=20) $this->tag_list[]= array('ad_slot' => "mbl_overlay_top", 'tag' => "undertone_Flex.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// if ($lucky>0 && $lucky<=40) $this->tag_list[]= array('ad_slot' => "mbl_overlay_top", 'tag' => "undertone_SS.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// if ($lucky>40 && $lucky<=100) $this->tag_list[]= array('ad_slot' => "mbl_overlay_top", 'tag' => "undertone_SSFP.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	$this->tag_list[]= array('ad_slot' => "mbl_overlay_top", 'tag' => "undertone_SSFP.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	

	// ----- BANNER ----------------------------------

	// This is place holder - there is no such ad slot as of yet - GB 2017-05-03
	// $this->tag_list[]= array('ad_slot' => "mbl_banner", 'tag' => "XXXXX.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// ----- IMG ----------------------------------
	// image treatment is a bit customized

	$show_on = $this->sponsored_pages_img; $dont_show_on = array();// These articles are paid content and should keep their original image
	$this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => 'image_tag', 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);


	// $show_on = array(27296); $dont_show_on = array();
	// $this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => "egami_mob_1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// $this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => "mbl_img_video_truvidplayer.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// $show_on = array("all"); $dont_show_on = array_merge($this->sponsored_pages_img, array_diff($this->special_pages, $show_on));
	// $this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => 'mbl_img_video_truvidplayer.php', 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => "egami_mob_1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => "mbl_img_video_truvidplayer_backfill.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// $show_on = array("all"); $dont_show_on = array_merge($this->sponsored_pages_img, array_diff($this->special_pages, $show_on));
	$show_on = array("all"); $dont_show_on = array();
	$this->tag_list[]= array('ad_slot' => "mbl_image", 'tag' => 'image_tag', 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// ---- BELOW IMAGE -----------------------------------
		
	//DEFY MEDIA - happens to create redirects - delete if no longer in use after november 30 21017 
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_defy_media_below_image.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// jetpack test is over - delete after DECEMBER 31 2017
	// $show_on = array(8700); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "_TEST_jetpack.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $show_on = array(11237); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "_TEST_jetpack.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_Answers_Rubicon_DFP.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "undertone_ST_container_method.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_Answers_Rubicon.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_below_image_ad_rotator.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_below_image_amazon.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_below_image_puckerstore.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "mbl_below_image_google.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// ---- END OF ARTICLE -----------------------------------

	// 23319 /moblog/15-open-letters-to-leave-your-boyfriend
	// $show_on = array("23319"); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_eoa", 'tag' => "xxxxxxxxxxxxx.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_eoa", 'tag' => "mbl_eoa_bravonate.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_eoa", 'tag' => "mbl_eoa_carambola.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_eoa", 'tag' => "mbl_eoa_composite.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	$this->tag_list[]= array('ad_slot' => "mbl_eoa", 'tag' => "mbl_ad_stack_nativo_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);


	// ---- AD STACK ----------------------------------

	$show_on = array(4019); $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "mbl_ad_stack_1", 'tag' => "_TEST_AD_PermanentTestTag_Bethany.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on = $this->sponsored_pages_lelo; $dont_show_on = array_diff($this->special_pages, $show_on);
	$this->tag_list[]= array('ad_slot' => "mbl_ad_stack_1", 'tag' => "mbl_ad_stack_lelo.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	

	$this->tag_list[]= array('ad_slot' => "mbl_ad_stack_2", 'tag' => "mbl_img_video_truvidplayer_backfill.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_ad_stack_2", 'tag' => "mbl_ad_stack_sharethrough.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_ad_stack_2", 'tag' => "Spoutable_Mob_InPage.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// $this->tag_list[]= array('ad_slot' => "mbl_ad_stack_3", 'tag' => "mbl_featured_google.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_ad_stack_3", 'tag' => "mbl_ad_stack_amazon.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_ad_stack_3", 'tag' => "mbl_ad_stack_answer_inbanner_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_ad_stack_3", 'tag' => "mbl_eoa_composite.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// ---- MORE BAR ----------------------------------

	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_morebar_1", 'tag' => "mbl_morebar_amazon_1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_morebar_2", 'tag' => "mbl_morebar_amazon_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_morebar_3", 'tag' => "mbl_morebar_amazon_3.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_morebar_4", 'tag' => "mbl_morebar_amazon_4.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	// ---- FEATURED ARTICLES ----------------------------------
	

	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_featured", 'tag' => "mbl_featured_google.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_featured", 'tag' => "mbl_ad_stack_answer_inbanner_2.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_featured", 'tag' => "mbl_featured_carambola.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);

	
	// ---- OVERLAY BOTTOM -- (inserted in bottomscript) --------------------------------
	
	// $show_on = array("all"); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_overlay_bottom", 'tag' => "mbl_overlay_bottom_undertone_SA.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	$show_on = array(8541); $dont_show_on = array_diff($this->special_pages_undertone, $show_on);
	$this->tag_list[]= array('ad_slot' => "mbl_overlay_bottom", 'tag' => "_TEST_q1.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	$show_on = array("all"); $dont_show_on = array_diff($this->special_pages, $show_on); 
	// jetpack test is over - delete after DECEMBER 31 2017
	// $dont_show_on[] = 8700;
	
	// $this->tag_list[]= array('ad_slot' => "mbl_overlay_bottom", 'tag' => "mbl_overlay_bottom_adhesion_kixer.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	// $this->tag_list[]= array('ad_slot' => "mbl_overlay_bottom", 'tag' => "mbl_overlay_bottom_adhesion_kixer.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	$this->tag_list[]= array('ad_slot' => "mbl_below_image", 'tag' => "jetpack.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	
	// $this->tag_list[]= array('ad_slot' => "mbl_overlay_bottom", 'tag' => "mbl_overlay_bottom_answers.php", 'show_on' => $show_on, 'dont_show_on' => $dont_show_on);
	

	
}//end public function __construct


function display_tags($ad_slot_id, $article_id, $article_title = ""){


	// PROCESS THE REQUEST ===========================================================
	$fgc = "";
	foreach ($this->tag_list as $tag_item){
		$tag = "";
		if ( $tag_item['ad_slot']==$ad_slot_id){
			if(in_array($article_id, $tag_item['show_on'])) $tag = $tag_item['tag'];
			if(in_array("all", $tag_item['show_on'])) $tag = $tag_item['tag'];
			
			if(in_array($article_id, $tag_item['dont_show_on'])) $tag = "";

			if($tag!=""){
				if(strpos($tag, 'image_tag')!==false){
					$fgc = "<img src=\"http://images.puckermob.com/articlesites/puckermob/large/$article_id"  . "_tall.jpg\" alt=\" $article_title Image\">";
				}else{
					$f = $this->config['include_path'] . "ads/$tag";
					$fgc .= file_get_contents($f);
				}//end if
			}//end if
		}//end if ( $tag_item['ad_slot']==$ad_slot_id)

	}// end foreach ($this->tag_list => $tag_item)

	return  $fgc;
}//end function display_tags($ad_slot_id, $article_id)


}//end class smf_adManager
?>