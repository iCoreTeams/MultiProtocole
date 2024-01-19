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

namespace pocketmine\scheduler;

/**
 * Allows the creation of simple callbacks with extra data
 * The last parameter in the callback will be this object
 *
 * If you want to do a task in a Plugin, consider extending PluginTask to your needs
 *
 * @deprecated
 */
class CallbackTask extends Task{

	/** @var callable */
	protected $callable;

	/** @var array */
	protected $args;

	/**
	 * @param callable $callable
	 * @param array    $args
	 */
	public function __construct(callable $callable, array $args = []){
		$this->callable = $callable;
		$this->args = $args;
	}

	/**
	 * @return callable
	 */
	public function getCallable() : callable{
		return $this->callable;
	}

	public function onRun(int $currentTicks){
		$c = $this->callable;
		$args = $this->args;
		$c(...$args);
	}
}
