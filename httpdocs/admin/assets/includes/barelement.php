<div id = "bar-element">
	<div class="bar">
		<p><?php echo $pageName; ?></p>
   		<h2>
   			<label id="sortby_value">Most Recent</label> 
   			<span data-icon="/" class="down-arrow"></span>
   		</h2>
	</div>
   	<ul id="sortby">
		<?php foreach( $pageInfo['sort_values'] as $key => $value ) {?>
	    	<li id="<?php echo $key ?>" class=""><?php echo $value ?></li>
	    <?php }?>
	</ul>
</div>
