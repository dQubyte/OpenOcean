<?php

require_once("../../core/init.php");

require_once(PATH_LIBRARIES . 'OpenOcean/Template.php');

$languagesAvailableJson = file_get_contents('languages/available.json');
$languagesAvailable = (array) json_decode($languagesAvailableJson);

$languagesDefault = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if (!in_array($languagesDefault, $languagesAvailable)){
	$languagesDefault = 'en';
}

$languageSelect = "";
foreach ($languagesAvailable as $key => $value) {
	if ($value != $languagesDefault) {
		$languageSelect .= "<option value='$value'>$key</option>";
	} else {
		$languageSelect .= "<option value='$value' selected>$key</option>";
	}
}

$templateData = array(
	'languageSelect' => $languageSelect
);

$templateFile = file_get_contents('assets/html/index.html');
$template = new OoTemplate($templateFile, $templateData, PATH_PUBLIC_HTML . "install/languages/" . $languagesDefault . ".json");
$template->parse();

echo($template->get());