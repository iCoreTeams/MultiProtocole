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

#include <rules/DataPacket.h>


use pocketmine\network\NetworkSession;

class SetTitlePacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SET_TITLE_PACKET;

	public const TYPE_CLEAR_TITLE = 0;
	public const TYPE_RESET_TITLE = 1;
	public const TYPE_SET_TITLE = 2;
	public const TYPE_SET_SUBTITLE = 3;
	public const TYPE_SET_ACTIONBAR_MESSAGE = 4;
	public const TYPE_SET_ANIMATION_TIMES = 5;

	/** @var int */
	public $type;
	/** @var string */
	public $text = "";
	/** @var int */
	public $fadeInTime = 0;
	/** @var int */
	public $stayTime = 0;
	/** @var int */
	public $fadeOutTime = 0;
	/** @var string */
	public $xuid = "";
	/** @var string */
	public $platformOnlineId = "";

	public function decodePayload(){
		$this->type = $this->getVarInt();
		$this->text = $this->getString();
		$this->fadeInTime = $this->getVarInt();
		$this->stayTime = $this->getVarInt();
		$this->fadeOutTime = $this->getVarInt();
        $this->xuid = $this->getString();
        $this->platformOnlineId = $this->getString();
	}

	public function encodePayload(){
		$this->putVarInt($this->type);
		$this->putString($this->text);
		$this->putVarInt($this->fadeInTime);
		$this->putVarInt($this->stayTime);
		$this->putVarInt($this->fadeOutTime);
        $this->putString($this->xuid);
        $this->putString($this->platformOnlineId);
	}

	public function mustBeDecoded() : bool{
		return false;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSetTitle($this);
	}
}
