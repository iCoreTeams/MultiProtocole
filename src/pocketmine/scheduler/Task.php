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

/**
 * WARNING! Plugins that create tasks MUST extend PluginTask
 */
abstract class Task{

	/** @var TaskHandler */
	private $taskHandler = null;

	/**
	 * @return TaskHandler|null
	 */
	final public function getHandler(){
		return $this->taskHandler;
	}

	/**
	 * @return int
	 */
	final public function getTaskId() : int{
		if($this->taskHandler !== null){
			return $this->taskHandler->getTaskId();
		}

		return -1;
	}

	/**
	 * @param TaskHandler|null $taskHandler
	 */
	final public function setHandler(TaskHandler $taskHandler = null){
		if($this->taskHandler === null or $taskHandler === null){
			$this->taskHandler = $taskHandler;
		}
	}

	/**
	 * Actions to execute when run
	 *
	 * @param int $currentTick
	 *
	 * @return void
	 */
	abstract public function onRun(int $currentTick);

	/**
	 * Actions to execute if the Task is cancelled
	 */
	public function onCancel(){

	}

}
