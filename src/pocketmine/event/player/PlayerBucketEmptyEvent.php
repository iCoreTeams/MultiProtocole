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

namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerBucketEmptyEvent extends PlayerBucketEvent{
	public static $handlerList = null;

	public function __construct(Player $who, Block $blockClicked, $blockFace, Item $bucket, Item $itemInHand){
		parent::__construct($who, $blockClicked, $blockFace, $bucket, $itemInHand);
	}
}