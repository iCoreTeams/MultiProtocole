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


namespace pocketmine\network\bedrock\protocol;


use pocketmine\network\NetworkSession;
use function ord;
use function strlen;

class UnknownPacket extends DataPacket{
	public const NETWORK_ID = -1; //Invalid, do not try to write this

	/** @var string */
	public $payload;

	public function pid() : int{
		if(strlen($this->payload ?? "") > 0){
			return ord($this->payload[0]);
		}
		return self::NETWORK_ID;
	}

	public function getName() : string{
		return "unknown packet";
	}

	protected function decodeHeader() : void{

	}

	public function decodePayload(){
		$this->payload = $this->getRemaining();
	}

	protected function encodeHeader() : void{

	}

	public function encodePayload(){
		$this->put($this->payload);
	}

	public function handle(NetworkSession $session) : bool{
		return false;
	}
}
