<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * CustomToolFactory
 *
 * @package PhpMyAdmin
 */
if (! defined('PHPMYADMIN')) {
	exit;
}

class CustomToolFactory
{
	private static $_path = 'libraries/custom_tools/%s.class.php';

	/**
	 * Sanitizes the name of a Node class
	 *
	 * @param string $class The class name to be sanitized
	 *
	 * @return string
	 */
	private static function _sanitizeClass($class)
	{
		if (false) {
		// if ($class !== 'Node' && ! preg_match('@^Node_\w+(_\w+)?$@', $class)) {
			$class = 'Node';
			trigger_error(
				sprintf(
				/* l10n: The word "Node" must not be translated here */
					__('Invalid class name "%1$s", using default of "Node"'),
					$class
				),
				E_USER_ERROR
			);
		}
		return self::_checkFile($class);
	}
	/**
	 * Checks if a file exists for a given class name
	 * Will return the default class name back if the
	 * file for some subclass is not available
	 *
	 * @param string $class The class name to check
	 *
	 * @return string
	 */
	private static function _checkFile($class)
	{
		$path = sprintf(self::$_path, $class);
		if (! is_readable($path)) {
			trigger_error(
				sprintf(
					__('Could not include class "%1$s", file "%2$s" not found'),
					$class,
					$path
					// 'Nodes/' . $class . '.class.php'
				),
				E_USER_ERROR
			);
		}
		return $class;
	}
	/**
	 * Instantiates a Node object

	 * @param string $custom_tool    The name of the class to instantiate
	 * @return mixed
	 */
	public static function getInstance(
		$custom_tool = 'index'
	) {
		$custom_tool_class = self::_sanitizeClass($custom_tool."_tool");
		include_once sprintf(self::$_path, $custom_tool_class);
		return new $custom_tool_class();
	}
}



?>