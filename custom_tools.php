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
require 'libraries/custom_tools/custom_tool_factory.class.php';

if(empty($GLOBALS['custom_tool']))
	$GLOBALS['custom_tool'] = "index";

$tool = CustomToolFactory::getInstance($GLOBALS['custom_tool']);
$tool->entry();

