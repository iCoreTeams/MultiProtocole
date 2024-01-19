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

/**
 * Plugin related classes
 */
namespace pocketmine\plugin;

use pocketmine\command\CommandExecutor;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\Config;


/**
 * It is recommended to use PluginBase for the actual plugin
 *
 */
interface Plugin extends CommandExecutor{

	/**
	 * Called when the plugin is loaded, before calling onEnable()
	 */
	public function onLoad();

	/**
	 * Called when the plugin is enabled
	 */
	public function onEnable();

	/**
	 * @return bool
	 */
	public function isEnabled() : bool;

	/**
	 * Called when the plugin is disabled
	 * Use this to free open things and finish actions
	 */
	public function onDisable();

	/**
	 * @return bool
	 */
	public function isDisabled() : bool;

	/**
	 * Gets the plugin's data folder to save files and configuration.
	 * This directory name has a trailing slash.
	 *
	 * @return string
	 */
	public function getDataFolder() : string;

	/**
	 * @return PluginDescription
	 */
	public function getDescription() : PluginDescription;

	/**
	 * Gets an embedded resource in the plugin file.
	 *
	 * @param string $filename
	 *
	 * @return
	 */
	public function getResource(string $filename);

	/**
	 * Saves an embedded resource to its relative location in the data folder
	 *
	 * @param string $filename
	 * @param bool $replace
	 *
	 * @return bool
	 */
	public function saveResource(string $filename, bool $replace = false) : bool;

	/**
	 * Returns all the resources packaged with the plugin
	 *
	 * @return string[]
	 */
	public function getResources() : array;

	/**
	 * @return Config
	 */
	public function getConfig() : Config;

	public function saveConfig();

	/**
	 * @return bool
	 */
	public function saveDefaultConfig() : bool;

	public function reloadConfig();

	/**
	 * @return Server
	 */
	public function getServer() : Server;

	/**
	 * @return string
	 */
	public function getName() : string;

	/**
	 * @return PluginLogger
	 */
	public function getLogger() : PluginLogger;

	/**
	 * @return PluginLoader
	 */
	public function getPluginLoader();

	public function registerEvents(Listener $listener) : void;

}
