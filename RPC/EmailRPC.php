<?php
require_once('../module/EmailModule.php');
$id = (isset($_POST['id'])) ? (int)$_POST['id'] : NULL;
$Email = new EmailModule($id);
$result = $Email->activate();
?>
<div>
<a href="mailto:<?= $result['address']?>"> Click to compose mail to <?= $result['address'] ?> </a>
<textarea>
<?= $result['body']?>
</textarea>
</div>