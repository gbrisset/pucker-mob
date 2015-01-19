<?php 

if(isset($updateStatus) && $updateStatus['hasError']){ ?>

<div id="openModal" class="modalDialog">
	<div id="popup-content">
		<a href="#close" title="Close" class="close">X</a>
		<div>
			<?php 
				
				echo $updateStatus['message']; 

			?>
		</div>
	</div>
</div>

<script>
	$('body').addClass('show-modal-box');
	///if($('#openModal')){

		$('.close').click(function(e){
			$('body').removeClass('show-modal-box');
		});

		$('#openModal').click(function(e){
			$('body').removeClass('show-modal-box');
		});

	//}
</script>
<?php }else{?>

<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form' && $updateStatus['hasError'] !== true){ ?>
	<div id="openModal" class="modalDialog">
	<div id="popup-content">
		<div>
			<p>Succesfully Added!!</p>
		</div>
	</div>
	</div>
	<script type="text/javascript">
	$('body').addClass('show-modal-box');
	
		setTimeout(function(){
			window.location = "<?php echo $config['this_admin_url']; ?>articles/edit/<?php echo $updateStatus['articleInfo'][':article_seo_title']; ?>";
	}, 2000);
	</script>
	<?php } ?>
<?php }?>
