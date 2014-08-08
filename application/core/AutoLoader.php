<?php

namespace ManiaControl;

/**
 * ManiaControl AutoLoader
 *
 * @author    ManiaControl Team <mail@maniacontrol.com>
 * @copyright 2014 ManiaControl Team
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */
abstract class AutoLoader {

	/**
	 * Register the Auto Loader
	 */
	public static function register() {
		spl_autoload_register(array(get_class(), 'autoload'));
	}

	/**
	 * Try to autoload the Class with the given Name
	 *
	 * @param string $className
	 */
	public static function autoload($className) {
		$classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);

		// Core file
		$coreClassPath = preg_replace('/ManiaControl/', 'core', $classPath, 1);
		$coreFilePath  = ManiaControlDir . $coreClassPath . '.php';
		if (file_exists($coreFilePath)) {
			include_once $coreFilePath;
			return;
		}

		// Plugin file
		$pluginFilePath = ManiaControlDir . 'plugins' . DIRECTORY_SEPARATOR . $classPath . '.php';
		if (file_exists($pluginFilePath)) {
			include_once $pluginFilePath;
			return;
		}

		// Lib file
		$libFilePath = ManiaControlDir . 'libs' . DIRECTORY_SEPARATOR . $classPath . '.php';
		if (file_exists($libFilePath)) {
			include_once $libFilePath;
			return;
		}
	}
}
