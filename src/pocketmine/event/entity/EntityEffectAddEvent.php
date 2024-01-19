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

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;

class EntityEffectAddEvent extends EntityEffectEvent{
	public static $handlerList = null;

	/** @var bool */
	private $modify;
	/** @var Effect */
	private $oldEffect;

	public function __construct(Entity $entity, Effect $effect, $modify, $oldEffect){
		parent::__construct($entity, $effect);
		$this->modify = $modify;
		$this->oldEffect = $oldEffect;
	}

	public function willModify() : bool{
		return $this->modify;
	}

	public function setWillModify(bool $modify){
		$this->modify = $modify;
	}

	public function hasOldEffect() : bool{
		return $this->oldEffect instanceof Effect;
	}

	/**
	 * @return Effect|null
	 */
	public function getOldEffect(){
		return $this->oldEffect;
	}


}