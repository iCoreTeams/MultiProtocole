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
use pocketmine\Player;

class PlayerTransferEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var string */
	protected $address;
	/** @var int */
	protected $port = 19132;
	/** @var string */
	protected $message;

	/**
	 * @param Player $player
	 * @param string $address
	 * @param int    $port
	 * @param string $message
	 */
	public function __construct(Player $player, string $address, int $port, string $message){
		$this->player = $player;
		$this->address = $address;
		$this->port = $port;
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getAddress() : string{
		return $this->address;
	}

	/**
	 * @param string $address
	 */
	public function setAddress(string $address){
		$this->address = $address;
	}

	/**
	 * @return int
	 */
	public function getPort() : int{
		return $this->port;
	}

	/**
	 * @param int $port
	 */
	public function setPort(int $port){
		$this->port = $port;
	}

	/**
	 * @return string
	 */
	public function getMessage() : string{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage(string $message){
		$this->message = $message;
	}
}