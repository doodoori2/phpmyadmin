<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tool manager
 *
 * @package LimitedPMA
 */

/**
 * Gets some core libraries
 */
require_once 'libraries/common.inc.php';
$response = PMA_Response::getInstance();
$header   = $response->getHeader();
$scripts  = $header->getScripts();
// $scripts->addFile('jquery/jquery-ui-timepicker-addon.js');
// $scripts->addFile('jquery/jquery.uitablefilter.js');
$relationsPara = PMA_getRelationsParam();
$response->addHTML('<div>');
$response->addHTML(json_encode($GLOBALS['cfg']['Server']['user']));

$retval  = '<ul id="topmenu2">';
$items = array();
$items[] = array("url" => "/tools.php", "name" => "aaa");
$items[] = array("url" => "/tools.php", "name" => "bbb");
$items[] = array("url" => "/tools.php", "name" => "ccc");
$items[] = array("url" => "/tools.php", "name" => "ddd");
$selfUrl = "/";
foreach ($items as $item) {
	$class = '';
	if ($item['url'] === $selfUrl) {
		$class = ' class="tabactive"';
	}
	$retval .= '<li>';
	$retval .= '<a' . $class;
	$retval .= ' href="' . $item['url']  .  '">';
	$retval .= $item['name'];
	$retval .= '</a>';
	$retval .= '</li>';
}
$retval .= '</ul>';
$retval .= '<div class="clearfloat"></div>';
$response->addHTML($retval);
$response->addHTML('</div>');

