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
 * UPnP port forwarding support. Only for Windows
 */
namespace pocketmine\network\upnp;

use pocketmine\utils\Internet;
use pocketmine\utils\Utils;

use function class_exists;
use function gethostbyname;
use function is_object;
use function trim;

abstract class UPnP{

	public static function PortForward(int $port) : bool{
		if(Internet::$online === false){
			return false;
		}
		if(Utils::getOS() != "win" or !class_exists("COM")){
			return false;
		}

		$myLocalIP = Internet::getInternalIP();
		try{
			/** @noinspection PhpUndefinedClassInspection */
			$com = new \COM("HNetCfg.NATUPnP");
			/** @noinspection PhpUndefinedFieldInspection */
			if($com === false or !is_object($com->StaticPortMappingCollection)){
				return false;
			}
			/** @noinspection PhpUndefinedFieldInspection */
			$com->StaticPortMappingCollection->Add($port, "UDP", $port, $myLocalIP, true, "PocketMine-MP");
		}catch(\Throwable $e){
			return false;
		}

		return true;
	}

	public static function RemovePortForward(int $port) : bool{
		if(Internet::$online === false){
			return false;
		}
		if(Utils::getOS() != "win" or !class_exists("COM")){
			return false;
		}

		try{
			/** @noinspection PhpUndefinedClassInspection */
			$com = new \COM("HNetCfg.NATUPnP") or false;
			/** @noinspection PhpUndefinedFieldInspection */
			if($com === false or !is_object($com->StaticPortMappingCollection)){
				return false;
			}
			/** @noinspection PhpUndefinedFieldInspection */
			$com->StaticPortMappingCollection->Remove($port, "UDP");
		}catch(\Throwable $e){
			return false;
		}

		return true;
	}
}