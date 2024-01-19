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

namespace pocketmine\level\format\io;

use pocketmine\level\LevelException;

use function is_subclass_of;
use function strtolower;
use function trim;

abstract class LevelProviderManager{
	protected static $providers = [];

	/**
	 * @param string $class
	 *
	 * @throws LevelException
	 */
	public static function addProvider(string $class){
		if(!is_subclass_of($class, LevelProvider::class)){
			throw new LevelException("Class is not a subclass of LevelProvider");
		}
		/** @var LevelProvider $class */
		self::$providers[strtolower($class::getProviderName())] = $class;
	}

	/**
	 * Returns a LevelProvider class for this path, or null
	 *
	 * @param string $path
	 *
	 * @return string|null
	 */
	public static function getProvider(string $path){
		foreach(self::$providers as $provider){
			/** @var $provider LevelProvider */
			if($provider::isValid($path)){
				return $provider;
			}
		}

		return null;
	}

	/**
	 * Returns a LevelProvider by name, or null if not found
	 *
	 * @param string $name
	 *
	 * @return string|null
	 */
	public static function getProviderByName(string $name){
		return self::$providers[trim(strtolower($name))] ?? null;
	}
}