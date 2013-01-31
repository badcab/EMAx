<?php
require_once('../module/EmailModule.php');
$id = (isset($_POST['id'])) ? (int)$_POST['id'] : NULL;
$Email = new EmailModule($id);
$result = $Email->activate();
?>
<div>
<a href="mailto:<?= $result['address']?>"> <?= $result['address'] ?> </a>
<br/>
<p><strong>Subject:</strong> <?= $result['subject'] ?></p>
<div id="emailBody">
<?= $result['body']?>
</div>
</div>