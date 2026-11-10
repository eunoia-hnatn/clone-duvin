<div class="col post-item">
			<div class="col-inner">
				<div class="box box-text-bottom box-blog-post has-hover">
            					<div class="box-image">
  						<div class="image-cover" style="padding-top:70%;">
							<a href="<?= e($article['url']) ?>" class="plain" aria-label="<?= e($article['title']) ?>">
								<?php $image = $article['image']; include __DIR__ . '/../image.php'; ?>							</a>
  							  							  						</div>
  						  					</div>
          					<div class="box-text text-left">
					<div class="box-text-inner blog-post-inner">


					<p class="cat-label  is-xxsmall op-7 uppercase">
    <span><?= e($article['category']) ?></span></p>

					<h5 class="post-title is-large ">
						<a href="<?= e($article['url']) ?>" class="plain"><?= e($article['title']) ?></a>
					</h5>
										<div class="is-divider"></div>

											<a href="<?= e($article['url']) ?>" class="button secondary is-link is-normal mb-0">
							Đọc tiếp						</a>


					</div>
					</div>
																<div class="badge absolute top post-date badge-outline">
							<div class="badge-inner">
								<span class="post-date-day"><?= e($article['date_day']) ?></span><br>
								<span class="post-date-month is-xsmall"><?= e($article['date_month']) ?></span>
							</div>
						</div>
									</div>
			</div>
		</div>
