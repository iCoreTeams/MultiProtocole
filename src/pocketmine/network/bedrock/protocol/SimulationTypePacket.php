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

class SimulationTypePacket extends DataPacket{
    public const NETWORK_ID = ProtocolInfo::SIMULATION_TYPE_PACKET;
    public const GAME = 0;
    public const EDITOR = 1;
    public const TEST = 2;

    /** @var int */
    public $type;

    public function decodePayload() : void{
        $this->type = $this->getByte();
    }

    public function encodePayload() : void{
        $this->putByte($this->type);
    }

    public function handle(NetworkSession $session): bool {
        return $session->handleSimulationType($this);
    }
}