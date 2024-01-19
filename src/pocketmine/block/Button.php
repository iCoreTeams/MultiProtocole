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

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;

abstract class Button extends Flowable{

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, $face, $fx, $fy, $z, Player $player = null){
		//TODO: check valid target block
		$this->meta = $face;

		return $this->level->setBlock($this, $this, true, true);
	}

	public function onActivate(Item $item, Player $player = null){
		//TODO
		return true;
	}

	public function canBeActivated() : bool{
		return true;
	}
}
