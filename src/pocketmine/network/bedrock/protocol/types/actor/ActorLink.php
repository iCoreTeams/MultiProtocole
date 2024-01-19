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

namespace pocketmine\network\bedrock\protocol\types\actor;

class ActorLink{

	public const TYPE_REMOVE = 0;
	public const TYPE_RIDER = 1;
	public const TYPE_PASSENGER = 2;

	/** @var int */
	public $fromActorUniqueId;
	/** @var int */
	public $toActorUniqueId;
	/** @var int */
	public $type;
	/** @var bool */
	public $immediate; //for dismounting on mount death
	/** @var bool */
	public $riderInitiated;

	public function __construct(?int $fromActorUniqueId = null, ?int $toActorUniqueId = null, ?int $type = null, bool $immediate = false, bool $riderInitiated = false){
		$this->fromActorUniqueId = $fromActorUniqueId;
		$this->toActorUniqueId = $toActorUniqueId;
		$this->type = $type;
		$this->immediate = $immediate;
		$this->riderInitiated = $riderInitiated;
	}
}
