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

use pocketmine\event\TextContainer;
use pocketmine\permission\Permissible;
use pocketmine\Server;

interface CommandSender extends Permissible{

	/**
	 * @param TextContainer|string $message
	 */
	public function sendMessage($message);

	/**
	 * @return Server
	 */
	public function getServer();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * Returns the line height of the command-sender's screen. Used for determining sizes for command output pagination
	 * such as in the /help command.
	 *
	 * @return int
	 */
	public function getScreenLineHeight() : int;

	/**
	 * Sets the line height used for command output pagination for this command sender. `null` will reset it to default.
	 * @param int|null $height
	 */
	public function setScreenLineHeight(int $height = null);
}