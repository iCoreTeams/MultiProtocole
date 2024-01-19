<?php

/*
 *
 *                            __  __ _
 *     /\                    |  \/  (_)
 *    /  \   __ _ _   _  __ _| \  / |_ _ __   ___
 *   / /\ \ / _` | | | |/ _` | |\/| | | '_ \ / _ \
 *  / ____ \ (_| | |_| | (_| | |  | | | | | |  __/
 * /_/    \_\__, |\__,_|\__,_|_|  |_|_|_| |_|\___|
 *             | |
 *             |_|
 *
 * This program is private software. No license required.
 * Publication of this program is forbidden and will be punished.
 *
 * @author GreenWix Project
 * @link https://www.greenwix.fun
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\plugin;

use pocketmine\event\plugin\PluginDisableEvent;
use pocketmine\event\plugin\PluginEnableEvent;
use pocketmine\Server;

/**
 * Simple script loader, not for plugin development
 * For an example see https://gist.github.com/shoghicp/516105d470cf7d140757
 */
use function class_exists;
use function dirname;
use function file;
use function file_exists;
use function is_dir;
use function preg_match;
use function strpos;
use function trim;

use const DIRECTORY_SEPARATOR;
use const FILE_IGNORE_NEW_LINES;
use const FILE_SKIP_EMPTY_LINES;

class ScriptPluginLoader implements PluginLoader{

	/** @var Server */
	private $server;

	/**
	 * @param Server $server
	 */
	public function __construct(Server $server){
		$this->server = $server;
	}

	/**
	 * Loads the plugin contained in $file
	 *
	 * @param string $file
	 *
	 * @return Plugin|null
	 */
	public function loadPlugin(string $file){
		if(($description = $this->getPluginDescription($file)) instanceof PluginDescription){
			$this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.plugin.load", [$description->getFullName()]));
			$dataFolder = dirname($file) . DIRECTORY_SEPARATOR . $description->getName();
			if(file_exists($dataFolder) and !is_dir($dataFolder)){
				throw new \InvalidStateException("Projected dataFolder '" . $dataFolder . "' for " . $description->getName() . " exists and is not a directory");
			}

			include_once($file);

			$className = $description->getMain();

			if(class_exists($className, true)){
				$plugin = new $className();
				$this->server->getPluginManager()->initPlugin($this, $plugin, $description, $dataFolder, $file);

				return $plugin;
			}else{
				throw new PluginException("Couldn't load plugin " . $description->getName() . ": main class not found");
			}
		}

		return null;
	}

	/**
	 * Gets the PluginDescription from the file
	 *
	 * @param string $file
	 *
	 * @return null|PluginDescription
	 */
	public function getPluginDescription(string $file){
		$content = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		$data = [];

		$insideHeader = false;
		foreach($content as $line){
			if(!$insideHeader and strpos($line, "/**") !== false){
				$insideHeader = true;
			}

			if(preg_match("/^[ \t]+\\*[ \t]+@([a-zA-Z]+)([ \t]+(.*))?$/", $line, $matches) > 0){
				$key = $matches[1];
				$content = trim($matches[3] ?? "");

				if($key === "notscript"){
					return null;
				}

				$data[$key] = $content;
			}

			if($insideHeader and strpos($line, "*/") !== false){
				break;
			}
		}
		if($insideHeader){
			return new PluginDescription($data);
		}

		return null;
	}

	/**
	 * Returns the filename patterns that this loader accepts
	 *
	 * @return string
	 */
	public function getPluginFilters() : string{
		return "/\\.php$/i";
	}
}
