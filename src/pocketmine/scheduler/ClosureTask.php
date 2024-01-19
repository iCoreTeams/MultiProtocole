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

namespace pocketmine\scheduler;

use pocketmine\utils\Utils;

/**
 * Task implementation which allows closures to be called by a scheduler.
 *
 * Example usage:
 *
 * ```
 * Server::getInstance()->scheduleRepeatingTask(new ClosureTask(function(int $currentTick) : void{
 *     echo "HI on $currentTick\n";
 * }), 1);
 * ```
 */
class ClosureTask extends Task{

	/** @var \Closure */
	private $closure;

	/**
	 * @param \Closure $closure Must accept only ONE parameter, $currentTick
	 */
	public function __construct(\Closure $closure){
		Utils::validateCallableSignature(function(int $currentTick) : void{}, $closure);
		$this->closure = $closure;
	}

	public function getName() : string{
		return Utils::getNiceClosureName($this->closure);
	}

	public function onRun(int $currentTick){
		($this->closure)($currentTick);
	}
}