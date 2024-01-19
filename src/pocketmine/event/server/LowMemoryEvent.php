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

namespace pocketmine\event\server;

use pocketmine\utils\Utils;


/**
 * Called when the server is in a low-memory state as defined by the properties
 * Plugins should free caches or other non-essential data.
 */
class LowMemoryEvent extends ServerEvent{
	public static $handlerList = null;

	/** @var int */
	private $memory;
	/** @var int */
	private $memoryLimit;
	/** @var int */
	private $triggerCount;
	/** @var bool */
	private $global;

	public function __construct(int $memory, int $memoryLimit, bool $isGlobal = false, int $triggerCount = 0){
		$this->memory = $memory;
		$this->memoryLimit = $memoryLimit;
		$this->global = $isGlobal;
		$this->triggerCount = $triggerCount;
	}

	/**
	 * Returns the memory usage at the time of the event call (in bytes)
	 *
	 * @return int
	 */
	public function getMemory() : int{
		return $this->memory;
	}

	/**
	 * Returns the memory limit defined (in bytes)
	 *
	 * @return int
	 */
	public function getMemoryLimit() : int{
		return $this->memoryLimit;
	}

	/**
	 * Returns the times this event has been called in the current low-memory state
	 *
	 * @return int
	 */
	public function getTriggerCount() : int{
		return $this->triggerCount;
	}

	/**
	 * @return bool
	 */
	public function isGlobal() : bool{
		return $this->global;
	}

	/**
	 * Amount of memory already freed
	 *
	 * @return int
	 */
	public function getMemoryFreed() : int{
		return $this->getMemory() - ($this->isGlobal() ? Utils::getMemoryUsage(true)[1] : Utils::getMemoryUsage(true)[0]);
	}

}