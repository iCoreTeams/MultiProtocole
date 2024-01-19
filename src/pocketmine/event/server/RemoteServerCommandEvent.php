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

use pocketmine\command\CommandSender;

/**
 * This event is called when a command is received over RCON.
 */
class RemoteServerCommandEvent extends ServerCommandEvent{
	public static $handlerList = null;

	/**
	 * @param CommandSender $sender
	 * @param string        $command
	 */
	public function __construct(CommandSender $sender, string $command){
		parent::__construct($sender, $command);
	}

}