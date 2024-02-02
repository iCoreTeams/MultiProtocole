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

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Arrow;
use pocketmine\item\enchantment\Enchantment;

/**
 * Called when an entity takes damage from an entity sourced from another entity, for example being hit by a snowball thrown by a Player.
 */
class EntityDamageByChildEntityEvent extends EntityDamageByEntityEvent{

	/** @var Entity */
	private $childEntity;


	/**
	 * @param Entity $damager
	 * @param Entity $childEntity
	 * @param Entity $entity
	 * @param int $cause
	 * @param int|int[] $damage
	 * @param float $knockBack
	 */
	public function __construct(Entity $damager, Entity $childEntity, Entity $entity, int $cause, $damage, float $knockBack = 1.0){
		$this->childEntity = $childEntity;
		parent::__construct($damager, $entity, $cause, $damage, $knockBack);
		$this->addChildModifiers();
	}

	protected function addChildModifiers(){ //TODO: move this to entity classes
		if($this->childEntity instanceof Arrow and ($bow = $this->childEntity->getBow()) !== null){
			if(($enchantment = $bow->getEnchantment(Enchantment::POWER)) !== null){
				$this->setDamage($this->getDamage() * 0.25 * ($enchantment->getLevel() + 1), self::MODIFIER_ENCHANTMENT_POWER);
			}
		}
	}

	/**
	 * Returns the entity which caused the damage, or null if the entity has been killed or closed.
	 *
	 * @return Entity|null
	 */
	public function getChild(){
		if($this->childEntity !== null and ($this->childEntity->isFlaggedForDespawn() or $this->childEntity->closed)){
			$this->childEntity = null;
		}
		return $this->childEntity;
	}
}