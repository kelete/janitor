<?php
global $model;

?>
<div class="scene setup i:scene">
	<h1>Janitor maintenance room</h1>
	<h2>Upgrade center</h2>

	<p>
		Select you upgrade option:
	</p>

	<div class="option">
		<h3>Full upgrade</h3>
		<p>
			Updates database and data structure to latest standard.
		</p>
		<ul class="actions">
			<li class="check"><a href="/janitor/admin/setup/upgrade/full" class="button primary">Full upgrade</a></li>
		</ul>

	</div>

<? if(preg_match("/(^http[s]?\:\/\/test\.)|(\.local$)/", SITE_URL)):
	// initialize mailer to make ADMIN_EMAIL available
	mailer();
 ?>
	<h2>Development tools</h2>
	<div class="option">
		<h3>Replace user emails</h3>
		<p>
			Changes all user emails to <em><?= ADMIN_EMAIL ?></em>. Useful for testing user updates on "real" users without risking
			sending unintended emails.
		</p>
		<p class="note">
			DON'T DO THIS IN PRODUCTION ENVIROMENTS - CHANGES CANNOT BE UNDONE.
		</p>
		<ul class="actions">
			<li class="replace"><a href="/janitor/admin/setup/upgrade/replace-emails" class="button primary">Replace emails</a></li>
		</ul>
	</div>

	<div class="option">
		<h3>Bulk remove items</h3>
		<p>
			Bulk removal of items. Used to remove KBs from live-replicas for local testing and functional backup.
		</p>
		<p class="note">
			DON'T DO THIS IN PRODUCTION ENVIROMENTS - CHANGES CANNOT BE UNDONE.
		</p>
		<ul class="actions">
			<li class="bulk"><a href="/janitor/admin/setup/upgrade/bulk-item-removal" class="button primary">Bulk removal</a></li>
		</ul>
	</div>
<? endif; ?>

</div>