<form role="search" method="get" class="searchform demo-search" action="/search">
<label class="screen-reader-text" for="<?= e($searchId) ?>">Tìm kiếm sản phẩm</label>
<input type="search" id="<?= e($searchId) ?>" name="q" placeholder="Tìm kiếm sản phẩm" aria-describedby="<?= e($searchId) ?>-note">
<button type="submit" aria-label="Gửi tìm kiếm">Tìm</button>
<small id="<?= e($searchId) ?>-note">Search — chờ chặng 2</small>
</form>
