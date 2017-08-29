public function enterNewCateogries(){
	$pdo = $this->con->openCon();
	$catInfo = array(
		array(
			'name' => 'Travel & Leisure',
			'visiblename' => 'Travel & Leisure',
			'subdomain' => 'travelandleisure',
			'catparent' => 0,
			'catchildof' => 9,
			'catvisible' => 0,
			'catanalytics' => '<script>//Travel & Leisure Analytics</script>',
			'cat300atf' => 'Travel & Leisure 300ATF Ad',
			'cat300btf' => 'Travel & Leisure 300BTF Ad',
			'cat728btf' => 'Travel & Leisure 728BTF Ad',
			'catadsrotate' => 1,
			'catadrotationtime' => 5
		)
	);

	foreach ($catInfo as $key => $catArray) {
		/*
		echo "Starting Category Build<br />";
		$q = $pdo->prepare("INSERT INTO categories (cat_name, cat_visible_name, cat_subdomain, cat_parent, cat_child_of, cat_visible, cat_analytics) VALUES (:name, :visiblename, :subdomain, :catparent, :catchildof, :catvisible, :catanalytics)");
		$q->execute(array(
			':name' => $catArray['name'],
			':visiblename' => $catArray['visiblename'],
			':subdomain' => $catArray['subdomain'],
			':catparent' => $catArray['catparent'],
			':catchildof' => $catArray['catchildof'],
			':catvisible' => $catArray['catvisible'],
			':catanalytics' => $catArray['catanalytics']
		));
		if($q){
			$newId = $pdo->lastInsertId();
			echo "Category entered into info table with new id of: ".$newId."<br />";
			
			echo "Attempting to insert empty styling row<br />";
			$q = $pdo->query("INSERT INTO category_styling (cat_id) VALUES ($newId)");
			if($q){
				echo "Styling information entered successfully<br />";
			}else{
				echo "Problem entering styling info: ".serialize($pdo->erroInfo())."<br /><br />";
				continue;
			}

			echo "Attempting to insert analytics row<br />";
			$q = $pdo->query("INSERT INTO category_analytics (cat_id) VALUES ($newId)");
			if($q){
				echo "Analytics information entered successfully<br />";
			}else{
				echo "Problem entering analytics info: ".serialize($pdo->erroInfo())."<br /><br />";
				continue;
			}

			echo "Attempting to insert ads row<br />";
			$q = $pdo->prepare("INSERT INTO category_ads (cat_id, 300_atf, 300_btf, 728_btf, ads_rotate, ad_rotation_time) VALUES (:id, :cat300atf, :cat300btf, :cat728btf, :catadsrotate, :catadrotationtime)");
			$q->execute(array(
				':id' => $newId,
				':cat300atf' => $catArray['cat300atf'],
				':cat300btf' => $catArray['cat300btf'],
				':cat728btf' => $catArray['cat728btf'],
				':catadsrotate' => $catArray['catadsrotate'],
				':catadrotationtime' => $catArray['catadrotationtime']
			));
			if($q){
				echo "Ad information entered successfully<br />";
				echo "All cateogry info set up!<br /><br />";
			}else{
				echo "Problem entering ad info: ".serialize($pdo->erroInfo())."<br /><br />";
				continue;
			}
		}else echo "Error: ".serialize($pdo->errorInfo())."<br />";
		*/
	}
}