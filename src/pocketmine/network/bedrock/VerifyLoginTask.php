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

namespace pocketmine\network\bedrock;

use pocketmine\network\bedrock\protocol\LoginPacket;
use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;

class VerifyLoginTask extends \pocketmine\network\mcpe\VerifyLoginTask{

	public function __construct(Player $player, LoginPacket $packet){
		$this->chainJwts = igbinary_serialize($packet->chainData["chain"]);
		$this->clientDataJwt = $packet->clientDataJwt;

		AsyncTask::__construct([$player, $packet]);
	}
}