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

namespace pocketmine\network\bedrock\utils;

use pocketmine\BedrockPlayer;

final class BedrockUtils{

	public static function splitPlayers(array $players, &$pw10Players, &$bedrockPlayers) : void{
		$pw10Players = [];
		$bedrockPlayers = [];

		foreach($players as $player){
			if($player instanceof BedrockPlayer){
				$bedrockPlayers[] = $player;
			}else{
				$pw10Players[] = $player;
			}
		}
	}

	/**
	 * @param string $text
	 *
	 * @return string[]
	 */
	public static function convertSignTextToLines(string $text) : array{
		return array_slice(array_pad(explode("\n", $text), 4, ""), 0, 4);
	}

	/**
	 * @param string[] $lines
	 *
	 * @return string
	 */
	public static function convertSignLinesToText(array $lines) : string{
		return implode("\n", $lines);
	}

	private function __construct(){
		// oof
	}
}