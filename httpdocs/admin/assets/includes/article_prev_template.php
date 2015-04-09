<div id="preview-article" class="modalDialogpPreviewArticle" >
	<div id="popup-content" style="width:33% !important; min-width: 35rem; margin: 1% auto !important;">
		<a href="#close" title="Close" class="close">X</a>
		<div class="modal-img" style="background: none; padding: 0;">
			<section id="article-summary" class="small-12 column">
				<!-- TITLE -->
				<h1 id="article-title" style="margin-bottom: 0.5rem;">{{TITLE}}</h1>
					
				<!-- SOCIAL DESKTOP -->
				<div class="row social-media-container" style="margin-bottom: 0rem; display:block !important;">
					<div class="small-12 columns half-padding-right-on-lg padding-top no-padding no-vertical-padding">
						<img src="http://www.puckermob.com/admin/assets/img/shares_prev_bar.png" alt="" />
					</div>
				</div>
				
				<!-- Article Image -->
				<div class="row no-vertical-padding">
					<div class="small-12 columns half-padding-right-on-lg padding-top no-padding no-vertical-padding">
					<img id="article_img" src="" alt="">
					</div>
				</div>

				<!-- Category, Date And Author Information -->
				<div class="row no-vertical-padding">
					<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg no-padding no-vertical-padding">
						<p class="left uppercase">
							<span id="article-category" class="span-category">{{CATEGORY}}</span>
							<span id="article-date" class="span-date">{{DATE}}</span>
						</p>
						<p class="right uppercase"><span class="span-author">By <a href="#" id="article-author">{{AUTHOR_NAME}}</a></span></p>
					</div>
				</div>

				<!-- Article Content -->
				<div class="row no-vertical-padding">
					<section id="article-content" class="small-12 column sidebar-box no-vertical-padding">"> 
						{{BODY}}
					</section>
				</div>
			</section>
		</div>
	</div>
</div>
