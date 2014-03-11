<?php       defined('C5_EXECUTE') or die("Access Denied.");
$description = substr($description,0,325).'....';
$bodyHTML = t("
<h2>A Blog Post needs reviewed!</h2>
<p>Please make your way to the Blog Dashboard to review.</p>
<hr />
<p>$description</p>
<br/>
<br/>
<a href=\"$url\" alt=\"blog link\">$url</a>
<hr />
<br/>
Thanks for reading!
".BASE_URL." Web Team
<br/>
");

$body = strip_tags($bodyHTML);
