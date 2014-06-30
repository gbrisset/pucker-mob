<?php
if($instructionsObj){
	$obj = explode("<p>", $instructionsObj);
	$count = count($obj);

	foreach( $obj as $key => $value){
		$index = $key+1;
								
		$fieldset = '';
		$fieldset .= '<fieldset class="instructions-box" id="instructions-'.$index.'" >';
			$fieldset .= '<label for="article_instructions_'.$index.'-nf">Instructions: </label>';
						
			$fieldset .= '<div id="elements-box" data-info="article_instructions-nf"  data-label="instructions">';
				$fieldset .= '<div class="input-elements">';
							
					$listObj = explode("</li>", $value); 
					foreach( $listObj as $key => $list){

						$indexList =  $key +1;
							if(strlen($list) > 2){
										
								$additionalComments = false;

								if(strpos($list,'</p>') !== false){	

									$list2 = explode("</p>", $list);
									$fieldset .= '<input type="text" placeholder="ex: Heat olive oil in a large skillet over medium high heat." class="article_instructions-title-'.$index.'-nf" id="article_instructions-title-'.$index.'-nf" name="article_instructions-title-'.$index.'-nf" value="'.$list2[0].'" />';

									if(strpos($list2[1],'<li>') !== false){
										$val =  explode("<li>", $list2[1]);
									}

									$fieldset .= '<input type="text" placeholder="ex: Heat olive oil in a large skillet over medium high heat." class="article_instructions-nf" id="article_instructions-'.$index.'-nf-'.$indexList.'" name="article_instructions-'.$index.'-nf-'.$indexList.'" value="'.$val[1].'" />';
													
								}else{ 
									$fieldset .= '<input type="text" placeholder="ex: Heat olive oil in a large skillet over medium high heat." class="article_instructions-nf" id="article_instructions-'.$index.'-nf-'.$indexList.'" name="article_instructions-'.$index.'-nf-'.$indexList.'"';
										if(strpos($list,'<li>') !== false){
											$val =  explode("<li>", $list);
										}
												
									$fieldset .= 'value="'.$val[1].'" />';
								}
											
								$indexList++;
							}
						}
										
				$fieldset .= '</div>';
							
				$fieldset .= '<div class="add-element">';
					$fieldset .= '<a href="" class="add-element-link" name = "add-element-link"><i class="icon-plus-sign"></i>Add Instruction</a>';
				$fieldset .= '</div>';

		$fieldset .= '</div>';

	$fieldset .= '</fieldset>';

	echo $fieldset;

	}
}else{ ?>
	<fieldset class="instructions-box" id="instructions-1">
		<label for="article_instructions-nf">Instructions<span>*</span> :</label>
		<input type="text" placeholder="ex: Heat olive oil in a large skillet over medium high heat." class="article_instructions-nf" id="article_instructions-1-nf-1" name="article_instructions-1-nf-1" >
						
		<div class="tooltip">
			<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">
			<div class="tooltip-info">
				<p>Please input instructions, one in each field. Does your recipe require secondary instructions for a sauce, glaze or icing? If so, click here to enter another set of instructions.</p>
			</div>
		</div>

		<div id="elements-box" data-info="article_instructions-nf" data-label="instructions">
			<div class="input-elements"></div>
			<div class="add-element">
				<a href="" class="add-element-link" name = "add-element-link"><i class="icon-plus-sign"></i>Add Instruction</a>
			</div>
		</div>
	</fieldset>
<?php }
?>