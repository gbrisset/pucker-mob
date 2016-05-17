    <?php 
        $ManageDashboard = new ManageAdminDashboard( $config );
        $contributor_id = $adminController->user->data['contributor_id'];

	    $userArticlesFilter = $adminController->user->data['user_email'];
	    if (isset($userData['user_permission_show_other_user_articles']) && $userData['user_permission_show_other_user_articles'] == 1){
			$userArticlesFilter = 'all';
		}

    	//Get Draft Articles for the current user
    	if(!isset($onDraft)) $onDraft = $mpArticle->countFiltered('1', '3', $userArticlesFilter, 'all');
    	else $onDraft = 0;


    	//GET RANK POSITION FOR CURRENT USER.
    	if( !isset($rank) ){
			 $rank = '999'; 
			 $rank_list = $ManageDashboard->getTopShareWritesRankHeader( date('n'), date('Y'));

             if(isset($rank_list) && $rank_list ){ 
				 foreach($rank_list as $rank_pw){ 
                   
				 	if( !is_null($rank_pw) && $rank_pw && $contributor_id === $rank_pw['contributor_id']){
				 		$rank = $rank_pw['rownum'];
				 	}
				 }
			}
    	}else $rank = '999';

    ?>

    <div class="row">
      <ul class="columns">
        <!--<li class="columns"><i class="fa fa-envelope-o"></i><span class="badge highlight round">4</span></li>-->
        <li class="columns"><i class="fa fa-bar-chart"></i><span class="badge highlight round"><?php echo $rank; ?></span></li>
        <li class="columns left"><i class="fa fa-file-text-o"></i><span class="badge highlight round"><?php echo $onDraft; ?></span></li>
      </ul>
    </div>
