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

class NetworkSettingsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_SETTINGS_PACKET;

	public const COMPRESS_NOTHING = 0;
	public const COMPRESS_EVERYTHING = 1;

	/** @var int */
	public $compressionThreshold;
	/** @var int */
	public $compressionAlgorithm;
	/** @var bool */
	public $enableClientThrottling;
	/** @var int */
	public $clientThrottleThreshold;
	/** @var float */
	public $clientThrottleScalar;

	public function decodePayload(){
		$this->compressionThreshold = $this->getLShort();
		$this->compressionAlgorithm = $this->getLShort();
		$this->enableClientThrottling = $this->getBool();
		$this->clientThrottleThreshold = $this->getByte();
		$this->clientThrottleScalar = $this->getLFloat();
	}

	public function encodePayload(){
		$this->putLShort($this->compressionThreshold);
		$this->putLShort($this->compressionAlgorithm);
		$this->putBool($this->enableClientThrottling);
		$this->putByte($this->clientThrottleThreshold);
		$this->putLFloat($this->clientThrottleScalar);
	}

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleNetworkSettings($this);
	}
}