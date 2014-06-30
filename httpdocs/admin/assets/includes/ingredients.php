<?php 
if($ingredientsObj){
	$obj = explode("<p>", $ingredientsObj);
	$count = count($obj);

	foreach( $obj as $key => $value){
		$index = $key+1;
								
		$fieldset = '';
		$fieldset .= '<fieldset class="ingredients-box" id="ingredients-'.$index.'" >';
			$fieldset .= '<label for="article_ingredients_'.$index.'-nf">Ingredients: </label>';

			$fieldset .= '<div id="elements-box" data-info="article_ingredients-nf"  data-label="ingredients">';
				$fieldset .= '<div class="input-elements">';
										
				$listObj = explode("</li>", $value); 

				foreach( $listObj as $key => $list){
					$indexList =  $key +1;

					if(strlen($list) > 2){
												
						if(strpos($list,'</p>') !== false){
							$list2 = explode("</p>", $list);
													
							$fieldset .= '<input type="text" placeholder="ex: 1/2 Cup Flour" class="article_ingredients-title-'.$index.'-nf" id="article_ingredients-title-'.$index.'-nf" name="article_ingredients-title-'.$index.'-nf" value="'.$list2[0].'" />';
							if(strpos($list2[1],'<li>') !== false){
								$val =  explode("<li>", $list2[1]);
							}

							$fieldset .= '<input type="text" placeholder="ex: 1/2 Cup Flour" class="article_ingredients-nf" id="article_ingredients-'.$index.'-nf-'.$indexList.'" name="article_ingredients-'.$index.'-nf-'.$indexList.'" value="'.$val[1].'" />';
													
						}else{
							$fieldset .= '<input type="text" placeholder="ex: 1/2 Cup Flour" class="article_ingredients-nf" id="article_ingredients-'.$index.'-nf-'.$indexList.'" name="article_ingredients-'.$index.'-nf-'.$indexList.'"';

							if(strpos($list,'<li>') !== false){
								$val =  explode("<li>", $list);
							}
								
							if(strlen($val[1]) > 0){ $fieldset .= 'value="'.$val[1].'" />';}
						}
									
						$indexList++;
					}
				}
										
				$fieldset .= '</div>';
							
				$fieldset .= '<div class="add-element">';
					$fieldset .= '<a href="" class="add-element-link" name = "add-element-link"><i class="icon-plus-sign"></i>Add Ingredient</a>';
				$fieldset .= '</div>';
			$fieldset .= '</div>';
		$fieldset .= '</fieldset>';

		echo $fieldset;
	}
}else{ ?>
	<fieldset class="ingredients-box" id="ingredients-1">
		<label for="article_ingredients_1-nf">Ingredients<span>*</span> :</label>
		<input type="text" placeholder="ex: 1/2 Cup Flour" class="article_ingredients-nf" id="article_ingredients-1-nf-1" name="article_ingredients-1-nf-1" >
						
		<div class="tooltip">
			<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">
			<div class="tooltip-info">
				<p>Please input ingredients, one in each field. Does your recipe require a secondary ingredient set for a sauce, glaze or icing? If so, click here to enter another set of ingredients.</p>
			</div>
		</div>
		<label for="elements-box"></label>
		<div id="elements-box" data-info="article_ingredients-nf"  data-label="ingredients">
			<div class="input-elements"></div>
			<div class="add-element">
				<a href="" class="add-element-link" name = "add-element-link"><i class="icon-plus-sign"></i>Add Ingredient</a>
			</div>
		</div>
		
	</fieldset>
<?php }
?>