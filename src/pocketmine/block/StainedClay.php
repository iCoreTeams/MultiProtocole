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

namespace pocketmine\block;

use pocketmine\item\Tool;

class StainedClay extends Solid{

	protected $id = self::STAINED_CLAY;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 1.25;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		static $names = [
			0 => "White Stained Clay",
			1 => "Orange Stained Clay",
			2 => "Magenta Stained Clay",
			3 => "Light Blue Stained Clay",
			4 => "Yellow Stained Clay",
			5 => "Lime Stained Clay",
			6 => "Pink Stained Clay",
			7 => "Gray Stained Clay",
			8 => "Light Gray Stained Clay",
			9 => "Cyan Stained Clay",
			10 => "Purple Stained Clay",
			11 => "Blue Stained Clay",
			12 => "Brown Stained Clay",
			13 => "Green Stained Clay",
			14 => "Red Stained Clay",
			15 => "Black Stained Clay",
		];
		return $names[$this->meta & 0x0f];
	}

}