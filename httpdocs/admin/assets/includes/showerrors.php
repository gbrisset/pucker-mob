<?php 

if(isset($updateStatus) && $updateStatus['hasError']){ ?>

<div id="openModal" class="modalDialog">
	<div id="popup-content">
		<a href="#close" title="Close" class="close">X</a>
		<div>
			<h2 style=" color: red; font-family: OswaldLight; font-size: 1.8rem;">Sorry...</h2>
			<p>
			<?php echo $updateStatus['message']; ?>
			</p>
		</div>
	</div>
</div>

<script>
	$('body').addClass('show-modal-box');
		$('.close').click(function(e){
			$('body').removeClass('show-modal-box');
		});

		$('#openModal').click(function(e){
			$('body').removeClass('show-modal-box');
		});
</script>
<?php }else{?>

<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form' && $updateStatus['hasError'] !== true){ ?>
<div id="openModal" class="modalDialog">
	<div id="popup-content">
		<div>
			<?php if($starter_blogger){?>
				<h2 style=" color: green; font-family: OswaldLight; font-size: 1.8rem;">Thank you!</h2> <p>A PuckerMob editor will review it for possible publication on the site shortly.</p>
			<?php }else{?>
				<h2 style=" color: green; font-family: OswaldLight; font-size: 1.8rem;">Thank you!</h2><p>Your article was created Succesfully!!</p>
			<?php }?>
		</div>
	</div>
</div>
	<script type="text/javascript">
	$('body').addClass('show-modal-box');
		setTimeout(function(){
			//window.location = "<?php //echo $config['this_admin_url']; ?>articles/edit/<?php //echo $updateStatus['articleInfo'][':article_seo_title']; ?>";
			window.location = "<?php echo $config['this_admin_url']; ?>articles/ ?>";
	}, 2000);
	</script>
<?php } ?>

<?php }?>
