<?php if(isset($pagesArray) && $pagesArray){
	$startSym = (isset($_GET['c']) || isset($_GET['q'])) ? '&' : '?';

	if(isset($uri[0]) && $uri[0] == "videos") $startSym = '?';
?>
<section id="pagination" class="small-12 pagination-centered columns sidebar-right">
		<ul class="pagination">
			<?php if(!in_array(1, $pagesArray['pages'])){ ?>	
			<li>
				<a href="<?php echo $pagesArray['url']; ?><?php if(isset($sortId) && $sortId > 1) echo $startSym.'sort='.$mpShared->dropDownInfo[$sortId -1]['shortname']; ?>">&laquo;</a>
			</li>
				
			<li>
				<a href="<?php echo $pagesArray['url'].$startSym.'p='.($currentPage - 1); ?><?php if(isset($sortId) && $sortId > 1) echo '&sort='.$mpShared->dropDownInfo[$sortId -1]['shortname']; ?>">&lsaquo;</a>
			</li>
			<?php } ?>

			<?php 
				foreach($pagesArray['pages'] as $page){
					$li = '<li';
						if($currentPage == $page) $li .= ' class="current"';
					$li .= '>';
						$li .= '<a href="';
						$li .= ($page == '...') ? '#" onClick="return false;' : $pagesArray['url'].$startSym.'p='.$page;
						if(isset($sortId) && $sortId > 1) $li .= '&sort='.$mpShared->dropDownInfo[$sortId -1]['shortname'];
						$li .= '">';
							$li .= $page;
						$li .= '</a>';
					$li .= '</li>';
					echo $li;
				}
			?>		
			<?php if(in_array('...', $pagesArray['pages'])){ ?>
				<li>
					<a href="<?php echo $pagesArray['url'].$startSym.'p='.($currentPage + 1); ?><?php if(isset($sortId) && $sortId > 1) echo '&sort='.$mpShared->dropDownInfo[$sortId -1]['shortname']; ?>">&rsaquo;</a>
				</li>
				
				<li>
					<a href="<?php echo $pagesArray['url'].$startSym.'p='.$totalPages; ?><?php if(isset($sortId) && $sortId > 1) echo '&sort='.$mpShared->dropDownInfo[$sortId -1]['shortname']; ?>">&raquo;</a>
				</li>
			<?php } ?>
		</ul>
	</section>

<?php } ?>