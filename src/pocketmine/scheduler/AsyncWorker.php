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

use pocketmine\thread\Worker;
use pocketmine\thread\log\ThreadSafeLogger;

class AsyncWorker extends Worker{

	private ThreadSafeLogger $logger;
	private int $id;

	public function __construct(ThreadSafeLogger $logger, int $id){
		$this->logger = $logger;
		$this->id = $id;
	}

	public function onRun() : void{
		$this->registerClassLoader();
		\GlobalLogger::set($this->logger);

		gc_enable();
		ini_set("memory_limit", '-1');

		global $store;
		$store = [];
	}

	public function handleException(\Throwable $e){
		parent::onUncaughtException($e);
		$this->logger->logException($e);
	}

	public function getLogger() : ThreadSafeLogger{
		return $this->logger;
	}

	public function getThreadName() : string{
		return "Asynchronous Worker #" . $this->id;
	}
}