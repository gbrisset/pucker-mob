<div id="history-modal" class="reveal-modal medium" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h2 id="modalTitle">History</h2>
  <div class="columns small-12" id="history-transaccions">

  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<script>	
	var admin_url = 'http://www.puckermob.com/admin/';
	// trigger by event
	$('a#history-link').on('click', function(e){
		e.preventDefault();
		var contributor_id = $(this).attr('data-info-id');
		$('#history-transaccions').load( admin_url + 'assets/includes/history_orders.php', { "contributor_id" : contributor_id } );
	});
	
	$('a.close-reveal-modal').trigger('click');

</script>