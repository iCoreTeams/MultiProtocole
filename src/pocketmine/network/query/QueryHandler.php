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
 * Implementation of the UT3 Query Protocol (GameSpot)
 * Source: http://wiki.unrealadmin.org/UT3_query_protocol
 */
namespace pocketmine\network\query;

use pocketmine\Server;
use pocketmine\utils\Binary;
use pocketmine\utils\BinaryStream;
use pocketmine\utils\BinaryDataException;

use function chr;
use function hash;
use function microtime;
use function random_bytes;
use function strlen;
use function substr;

class QueryHandler{
	private $server, $lastToken, $token, $longData, $shortData, $timeout;

	public const HANDSHAKE = 9;
	public const STATISTICS = 0;

	public function __construct(){
		$this->server = Server::getInstance();
		$this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.server.query.start"));
		$addr = ($ip = $this->server->getIp()) != "" ? $ip : "0.0.0.0";
		$port = $this->server->getPort();
		$this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.server.query.info", [$port]));
		/*
		The Query protocol is built on top of the existing Minecraft PE UDP network stack.
		Because the 0xFE packet does not exist in the MCPE protocol,
		we can identify	Query packets and remove them from the packet queue.

		Then, the Query class handles itself sending the packets in raw form, because
		packets can conflict with the MCPE ones.
		*/

		$this->regenerateToken();
		$this->lastToken = $this->token;
		$this->regenerateInfo();
		$this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.server.query.running", [$addr, $port]));
	}

	public function regenerateInfo(){
		$ev = $this->server->getQueryInformation();
		$this->longData = $ev->getLongQuery();
		$this->shortData = $ev->getShortQuery();
		$this->timeout = microtime(true) + $ev->getTimeout();
	}

	public function regenerateToken(){
		$this->lastToken = $this->token;
		$this->token = random_bytes(16);
	}

	public static function getTokenString($token, $salt){
		return Binary::readInt(substr(hash("sha512", $salt . ":" . $token, true), 7, 4));
	}

	public function handle(string $address, int $port, string $packet) : bool{
		try{
			$stream = new BinaryStream($packet);
			$header = $stream->get(2);
			if($header !== "\xfe\xfd"){ //TODO: have this filtered by the regex filter we installed above
				return false;
			}
			$packetType = $stream->getByte();
			$sessionID = $stream->getInt();

			switch($packetType){
				case self::HANDSHAKE: //Handshake
					$reply = chr(self::HANDSHAKE);
					$reply .= Binary::writeInt($sessionID);
					$reply .= self::getTokenString($this->token, $address) . "\x00";

					$this->server->getNetwork()->sendPacket($address, $port, $reply);

					return true;
				case self::STATISTICS: //Stat
					$token = $stream->getInt();
					if($token !== ($t1 = self::getTokenString($this->token, $address)) and $token !== ($t2 = self::getTokenString($this->lastToken, $address))){
						$this->debug("Bad token $token from $address $port, expected $t1 or $t2");

						return true;
					}
					$reply = chr(self::STATISTICS);
					$reply .= Binary::writeInt($sessionID);

					if($this->timeout < microtime(true)){
						$this->regenerateInfo();
					}

					$remaining = $stream->getRemaining();
					if(strlen($remaining) === 4){ //TODO: check this! according to the spec, this should always be here and always be FF FF FF 01
						$reply .= $this->longData;
					}else{
						$reply .= $this->shortData;
					}
					$this->server->getNetwork()->sendPacket($address, $port, $reply);

					return true;
				default:
					return false;
			}
		}catch(BinaryDataException $e){
			$this->debug("Bad packet from $address $port: " . $e->getMessage());
			return false;
		}
	}
}
