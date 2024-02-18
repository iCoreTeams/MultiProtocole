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

/**
 * Network-related classes
 */
namespace pocketmine\network;

use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\Player;

/**
 * Classes that implement this interface will be able to be attached to players
 */
interface NetworkInterface{

	/**
	 * Sends a DataPacket to the interface, returns an unique identifier for the packet if $needACK is true
	 *
	 * @param Player     $player
	 * @param DataPacket $packet
	 * @param bool       $needACK
	 * @param bool       $immediate
	 *
	 * @return int|null
	 */
	public function putPacket(Player $player, DataPacket $packet, bool $needACK = false, bool $immediate = true);

	/**
	 * Sends a raw buffer to the interface, returns an unique identifier for the packet if $needACK is true
	 *
	 * @param Player     $player
	 * @param DataPacket $packet
	 * @param bool       $needACK
	 * @param bool       $immediate
	 *
	 * @return int|null
	 */
	public function putBuffer(Player $player, string $buffer, bool $needACK = false, bool $immediate = true);

	/**
	 * Terminates the connection
	 *
	 * @param Player $player
	 * @param string $reason
	 */
	public function close(Player $player, string $reason = "unknown reason");

    /**
     * @param string $name
     */
    public function setName(string $name): void;

	/**
	 * @return bool
	 */
	public function process() : bool;

	public function shutdown();

	public function emergencyShutdown();

}