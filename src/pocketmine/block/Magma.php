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

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Tool;
use pocketmine\Player;

class Magma extends Solid{

    protected $id = self::MAGMA;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function getName(){
        return "Magma";
    }

    public function hasEntityCollision(){
        return true;
    }

    public function onEntityCollide(Entity $entity): bool
    {
        if ($entity->hasEffect(Effect::FIRE_RESISTANCE)) {
            return false;
        }

        if ($entity instanceof Player) {
            if ($entity->getInventory()->getBoots()->getEnchantment(Enchantment::FROST_WALKER) != null
                || $entity->isCreative() || $entity->isSpectator() || $entity->isSneaking()) {
                return false;
            }
        }
        $ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_HOT_FLOOR, 1);
        $entity->attack($ev);
        return true;
    }

    public function getHardness() {
        return 0.5;
    }

    public function getResistance(): float
    {
        return 30;
    }

    public function getLightLevel() {
        return 3;
    }

    public function getToolType(){
        return Tool::TYPE_PICKAXE;
    }
}