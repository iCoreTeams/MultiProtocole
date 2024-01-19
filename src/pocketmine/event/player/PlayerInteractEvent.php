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
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;

/**
 * Called when a player interacts or touches a block (including air?)
 */
class PlayerInteractEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	public const LEFT_CLICK_BLOCK = 0;
	public const RIGHT_CLICK_BLOCK = 1;
	public const LEFT_CLICK_AIR = 2;
	public const RIGHT_CLICK_AIR = 3;
	public const PHYSICAL = 4;

	/** @var Block */
	protected $blockTouched;

	/** @var Vector3 */
	protected $touchVector;

	/** @var int */
	protected $blockFace;

	/** @var Item */
	protected $item;

	/** @var int */
	protected $action;

	public function __construct(Player $player, Item $item, Vector3 $block, int $face, int $action = PlayerInteractEvent::RIGHT_CLICK_BLOCK){
		if($block instanceof Block){
			$this->blockTouched = $block;
			$this->touchVector = new Vector3(0, 0, 0);
		}else{
			$this->touchVector = $block;
			$this->blockTouched = Block::get(0, 0, new Position(0, 0, 0, $player->level));
		}
		$this->player = $player;
		$this->item = $item;
		$this->blockFace = $face;
		$this->action = $action;
	}

	/**
	 * @return int
	 */
	public function getAction() : int{
		return $this->action;
	}

	/**
	 * @return Item
	 */
	public function getItem() : Item{
		return $this->item;
	}

	/**
	 * @return Block
	 */
	public function getBlock() : Block{
		return $this->blockTouched;
	}

	/**
	 * @return Vector3
	 */
	public function getTouchVector() : Vector3{
		return $this->touchVector;
	}

	/**
	 * @return int
	 */
	public function getFace() : int{
		return $this->blockFace;
	}
}
