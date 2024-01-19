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

class StackRequestSlotInfo{

	/** @var int */
	public $containerId;
	/** @var int */
	public $slot;
	/** @var int */
	public $stackNetworkId;

	public function __construct(int $containerId = -1, int $slot = -1, int $stackNetworkId = -1){
		$this->containerId = $containerId;
		$this->slot = $slot;
		$this->stackNetworkId = $stackNetworkId;
	}
}