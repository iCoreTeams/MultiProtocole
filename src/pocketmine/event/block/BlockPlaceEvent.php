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

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

/**
 * Called when a player places a block
 */
class BlockPlaceEvent extends BlockEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Player */
	protected $player;

	/** @var Item */
	protected $item;


	protected $blockReplace;
	protected $blockAgainst;

	public function __construct(Player $player, Block $blockPlace, Block $blockReplace, Block $blockAgainst, Item $item){
		$this->block = $blockPlace;
		$this->blockReplace = $blockReplace;
		$this->blockAgainst = $blockAgainst;
		$this->item = $item;
		$this->player = $player;
	}

	public function getPlayer(){
		return $this->player;
	}

	/**
	 * Gets the item in hand
	 *
	 * @return mixed
	 */
	public function getItem(){
		return $this->item;
	}

	public function getBlockReplaced(){
		return $this->blockReplace;
	}

	public function getBlockAgainst(){
		return $this->blockAgainst;
	}
}