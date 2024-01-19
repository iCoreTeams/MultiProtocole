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

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\IPlayer;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Server;

/**
 * Called when a player's data is about to be saved to disk.
 */
class PlayerDataSaveEvent extends Event implements Cancellable{
	public static $handlerList = null;

	/** @var CompoundTag */
	protected $data;
	/** @var string */
	protected $playerName;

	public function __construct(CompoundTag $nbt, string $playerName){
		$this->data = $nbt;
		$this->playerName = $playerName;
	}

	/**
	 * Returns the data to be written to disk as a CompoundTag
	 * @return CompoundTag
	 */
	public function getSaveData() : CompoundTag{
		return $this->data;
	}

	/**
	 * @param CompoundTag $data
	 */
	public function setSaveData(CompoundTag $data){
		$this->data = $data;
	}

	/**
	 * Returns the username of the player whose data is being saved. This is not necessarily an online player.
	 * @return string
	 */
	public function getPlayerName() : string{
		return $this->playerName;
	}

	/**
	 * Returns the player whose data is being saved. This may be a Player or an OfflinePlayer.
	 * @return IPlayer (Player or OfflinePlayer)
	 */
	public function getPlayer() : IPlayer{
		return Server::getInstance()->getOfflinePlayer($this->playerName);
	}
}