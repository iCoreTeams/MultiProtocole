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

namespace pocketmine\network\bedrock\protocol\types\itemStack;

class StackResponseSlotInfo{

	/** @var int */
	public $slot;
	/** @var int */
	public $hotbarSlot;
	/** @var int */
	public $count;
	/** @var int */
	public $stackNetworkId;
	/** @var string */
	public $customName;
	/** @var int */
	public $durabilityCorrection;

	public function __construct(int $slot = -1, int $hotbarSlot = -1, int $count = -1, int $stackNetworkId = -1, string $customName = "", int $durabilityCorrection = 0){
		$this->slot = $slot;
		$this->hotbarSlot = $hotbarSlot;
		$this->count = $count;
		$this->stackNetworkId = $stackNetworkId;
		$this->customName = $customName;
		$this->durabilityCorrection = $durabilityCorrection;
	}
}