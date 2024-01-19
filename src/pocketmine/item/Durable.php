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

namespace pocketmine\item;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\nbt\tag\ByteTag;

abstract class Durable extends Item{

	public function isUnbreakable(){
		$tag = $this->getNamedTag();
		return $tag->hasTag("Unbreakable", ByteTag::class) and $tag->getByte("Unbreakable") > 0;
	}

	/**
	 * @param bool $unbreakable
	 *
	 * @return $this
	 */
	public function setUnbreakable(bool $unbreakable){
		$this->getNamedTag()->setInt("Unbreakable", $unbreakable ? 1 : 0);
		return $this;
	}

	/**
	 * Applies damage to the item.
	 * @param int $amount
	 *
	 * @return bool if any damage was applied to the item
	 */
	public function applyDamage(int $amount) : bool{
		if($this->isUnbreakable() or $this->isBroken()){
			return false;
		}

		$amount -= $this->getUnbreakingDamageReduction($amount);

		$this->meta = min($this->meta + $amount, $this->getMaxDurability());
		if($this->isBroken()){
			$this->onBroken();
		}

		return true;
	}

	protected function getUnbreakingDamageReduction(int $amount) : int{
		if(($unbreaking = $this->getEnchantment(Enchantment::UNBREAKING)) !== null){
			$negated = 0;

			$chance = 1 / ($unbreaking->getLevel() + 1);
			for($i = 0; $i < $amount; ++$i){
				if(lcg_value() > $chance){
					$negated++;
				}
			}

			return $negated;
		}

		return 0;
	}

	/**
	 * Called when the item's damage exceeds its maximum durability.
	 */
	protected function onBroken() : void{
		$this->pop();
	}

	/**
	 * Returns whether the item is broken.
	 * @return bool
	 */
	public function isBroken() : bool{
		return $this->meta >= $this->getMaxDurability();
	}
}