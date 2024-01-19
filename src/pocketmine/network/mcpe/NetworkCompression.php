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

namespace pocketmine\network\mcpe;

use pocketmine\utils\Zlib;
use const ZLIB_ENCODING_DEFLATE;

final class NetworkCompression{
	public static $LEVEL = 7;
	public static $THRESHOLD = 256;

	private function __construct(){

	}

	public static function decompress(string $payload) : string{
		return Zlib::decompress($payload, 1024 * 1024 * 2); //Max 2 MB
	}

	/**
	 * @param string $payload
	 * @param int|null $compressionLevel
	 *
	 * @return string
	 */
	public static function compress(string $payload, ?int $compressionLevel = null) : string{
		return Zlib::compress($payload, ZLIB_ENCODING_DEFLATE, $compressionLevel ?? self::$LEVEL);
	}
}