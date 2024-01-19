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

namespace pocketmine\command;


interface CommandMap{

	/**
	 * @param string $fallbackPrefix
	 * @param Command[] $commands
	 */
	public function registerAll(string $fallbackPrefix, array $commands);

	/**
	 * @param string      $fallbackPrefix
	 * @param Command     $command
	 * @param string|null $label
	 *
	 * @return bool
	 */
	public function register(string $fallbackPrefix, Command $command, string $label = null) : bool;

	/**
	 * @param CommandSender $sender
	 * @param string        $cmdLine
	 *
	 * @return bool
	 */
	public function dispatch(CommandSender $sender, string $cmdLine) : bool;

	/**
	 * @param Command     $command
	 *
	 * @return bool
	 */
	public function unregister(Command $command) : bool;

	/**
	 * @return void
	 */
	public function clearCommands();

	/**
	 * @param string $name
	 *
	 * @return Command|null
	 */
	public function getCommand(string $name);


}