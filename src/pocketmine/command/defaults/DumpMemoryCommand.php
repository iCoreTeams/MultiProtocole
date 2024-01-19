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

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;

use function count;
use function sha1;
use function strtoupper;
use function substr;

class DumpMemoryCommand extends VanillaCommand{

	private static $executions = 0;

	public function __construct($name){
		parent::__construct(
			$name,
			"Dumps the memory",
			"/$name <TOKEN (run once to get it)> [path]"
		);
		$this->setPermission("pocketmine.command.dumpmemory");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$token = strtoupper(substr(sha1(BOOTUP_RANDOM . ":" . $sender->getServer()->getServerUniqueId() . ":" . self::$executions), 6, 6));

		if(count($args) < 1 or strtoupper($args[0]) !== $token){
			$sender->sendMessage("Usage: /" . $this->getName() . " " . $token);
			return true;
		}

		++self::$executions;

		$sender->getServer()->getMemoryManager()->dumpServerMemory($args[1] ?? ($sender->getServer()->getDataPath() . "/memoryDump_$token"), 48, 80);
		return true;
	}
}
