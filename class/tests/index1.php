<?php
include 'template.php';

$template = new template;

$template->assign('username', 'terry');

$template->render('mytemplate');
?>