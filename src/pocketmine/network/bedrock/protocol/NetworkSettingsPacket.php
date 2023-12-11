<?php

declare(strict_types=1);

namespace pocketmine\network\bedrock\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\NetworkSession;

class NetworkSettingsPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_SETTINGS_PACKET;

    public const ZLIB = 0;
    public const SNAPPY = 1;

    public const COMPRESS_NOTHING = 0;
    public const COMPRESS_EVERYTHING = 1;

    private int $compressionThreshold;
    private int $compressionAlgorithm;
    private bool $enableClientThrottling;
    private int $clientThrottleThreshold;
    private float $clientThrottleScalar;

    public static function create(int $compressionThreshold, int $compressionAlgorithm, bool $enableClientThrottling, int $clientThrottleThreshold, float $clientThrottleScalar) : self{
        $result = new self;
        $result->compressionThreshold = $compressionThreshold;
        $result->compressionAlgorithm = $compressionAlgorithm;
        $result->enableClientThrottling = $enableClientThrottling;
        $result->clientThrottleThreshold = $clientThrottleThreshold;
        $result->clientThrottleScalar = $clientThrottleScalar;
        return $result;
    }

    public function canBeSentBeforeLogin() : bool{
        return true;
    }

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

	public function handle(NetworkSession $session) : bool{
		return $session->handleNetworkSettings($this);
	}
}