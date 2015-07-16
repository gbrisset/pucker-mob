<?php 
	// If the total number of pages > 1, display the pagination links...
	if($pagination->total_pages() && $pagination->total_pages() > 1){ 
		$totalPages = $pagination->total_pages();
		if (!isset($sortingMethod['order']) || strlen($sortingMethod['order']) == 0){
			if (isset($sortingMethod))$order = $sortingMethod['articleStatus'];
		}

?>
	<section id="pages">
		<ul>
			<li>PAGE:</li>
                	<?php 
							if ($pagination->has_previous_page()) {
								$query_array = array("page"=>$pagination->previous_page(), "sort"=>$order);//, "assoc_cat"=>$category, "visible"=>$visible);
								$query_string = http_build_query($query_array);
								echo "<li><a href='".$_SERVER['SCRIPT_NAME']."?page=1'> << </a></li>";
							}

							for ($i=1; $i <= $pagination->total_pages(); $i++) {
								$query_array = array("page"=>$i, "sort"=>$order, "artype"=>$artType);
								$query_string = http_build_query($query_array);
								if ($i==$page) {
									echo "<li class='current'><a href=".$_SERVER['SCRIPT_NAME']."?".$query_string.">{$i}</a></li>";
								} else if ($i > $page+9 || $i < $page - 9) {
									// echo ". . .";
									// break;
								} else {
									// The pages AFTER page+5
									echo " <li><a style=\"\" href=\"".$_SERVER['SCRIPT_NAME']."?".$query_string."\">{$i}</a></li> ";
								}
							}
							if ($pagination->has_next_page()) {
								$query_array = array("page"=>$pagination->next_page(), "sort"=>$order, "artype"=>$artType);
								$query_string = http_build_query($query_array);
								echo "<li>. . .</li>";
								echo "<li><a href='".$_SERVER['SCRIPT_NAME']."?page=".$totalPages."&sort=".$order." '>".$totalPages."</a></li>";
							}
					?>
		</ul>
	</section>
<?php } ?>