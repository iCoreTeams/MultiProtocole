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
use pocketmine\math\AxisAlignedBB;
use pocketmine\Player;

abstract class Slab extends Transparent{

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->meta &= 0x07;
		if($face === 0){
			if($target->getId() === $this->id and ($target->getDamage() & 0x08) === 0x08 and ($target->getDamage() & 0x07) === ($this->meta)){
				$this->getLevel()->setBlock($target, Block::get($this->doubleId, $this->meta), true);

				return true;
			}elseif($block->getId() === $this->id and ($block->getDamage() & 0x07) === ($this->meta)){
				$this->getLevel()->setBlock($block, Block::get($this->doubleId, $this->meta), true);

				return true;
			}else{
				$this->meta |= 0x08;
			}
		}elseif($face === 1){
			if($target->getId() === $this->id and ($target->getDamage() & 0x08) === 0 and ($target->getDamage() & 0x07) === $this->meta){
				$this->getLevel()->setBlock($target, Block::get($this->doubleId, $this->meta), true);

				return true;
			}elseif($block->getId() === $this->id and ($block->getDamage() & 0x07) === $this->meta){
				$this->getLevel()->setBlock($block, Block::get($this->doubleId, $this->meta), true);

				return true;
			}
		}else{ //TODO: collision
			if($block->getId() === $this->id){
				if(($block->getDamage() & 0x07) === $this->meta){
					$this->getLevel()->setBlock($block, Block::get($this->doubleId, $this->meta), true);

					return true;
				}

				return false;
			}else{
				if($fy > 0.5){
					$this->meta |= 0x08;
				}
			}
		}

		if($block->getId() === $this->id and ($target->getDamage() & 0x07) !== ($this->meta & 0x07)){
			return false;
		}
		$this->getLevel()->setBlock($block, $this, true, true);

		return true;
	}

	protected function recalculateBoundingBox(){

		if(($this->meta & 0x08) > 0){
			return new AxisAlignedBB(
				$this->x,
				$this->y + 0.5,
				$this->z,
				$this->x + 1,
				$this->y + 1,
				$this->z + 1
			);
		}else{
			return new AxisAlignedBB(
				$this->x,
				$this->y,
				$this->z,
				$this->x + 1,
				$this->y + 0.5,
				$this->z + 1
			);
		}
	}
}