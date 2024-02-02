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

namespace pocketmine\network\bedrock\chunk;

use Closure;
use pocketmine\level\format\Chunk;
use pocketmine\level\Level;
use pocketmine\network\bedrock\BedrockPacketBatch;
use pocketmine\network\bedrock\NetworkCompression;
use pocketmine\network\bedrock\palette\BlockPalette;
use pocketmine\network\bedrock\protocol\LevelChunkPacket;
use pocketmine\network\bedrock\protocol\ProtocolInfo;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class BedrockChunkRequestTask extends AsyncTask{

	/** @var int */
	protected $levelId;

	/** @var int */
	protected $chunkX;
	/** @var int */
	protected $chunkZ;
	/** @var string */
	protected $tileData = "";
	/** @var string */
	protected $chunk;

	/** @var int */
	protected $compressionLevel;

	/** @var int */
	protected $protocolVersion;

	public function __construct(Level $level, Chunk $chunk, int $protocolVersion){
		$this->levelId = $level->getId();
		$this->compressionLevel = NetworkCompression::$LEVEL;

		$this->chunkX = $chunk->getX();
		$this->chunkZ = $chunk->getZ();

		$this->tileData = BedrockChunkSerializer::serializeTiles($chunk);
		$this->chunk = $chunk->fastSerialize();

		$this->protocolVersion = $protocolVersion;
	}

	public function onRun(){
		BlockPalette::lazyInit();

		$chunk = Chunk::fastDeserialize($this->chunk);

		$pk = new LevelChunkPacket();
		$pk->chunkX = $this->chunkX;
		$pk->chunkZ = $this->chunkZ;
		$pk->subChunkCount = $chunk->getSubChunkSendCount();
        $pk->subChunkCount += BedrockChunkSerializer::LOWER_PADDING_SIZE;

        $c = Closure::fromCallable([BlockPalette::class, "getRuntimeFromLegacyId"]);
        $pk->data = BedrockChunkSerializer::serialize($chunk, $c, $this->tileData);

		$stream = new BedrockPacketBatch();
		$stream->putPacket($pk);

		$this->setResult(ProtocolInfo::MCPE_RAKNET_PACKET_ID . NetworkCompression::compress($stream->buffer, $this->compressionLevel), false);
	}

	public function onCompletion(Server $server){
		$level = $server->getLevel($this->levelId);
		if($level instanceof Level){
			if($this->hasResult()){
				BedrockChunkCache::getInstance($level, $this->protocolVersion)->requestCallback($this->chunkX, $this->chunkZ, $this->getResult());
			}else{
				$server->getLogger()->error("Chunk request for level #" . $this->levelId . ", x=" . $this->chunkX . ", z=" . $this->chunkZ . " doesn't have any result data");
			}
		}else{
			$server->getLogger()->debug("Dropped chunk task due to level not loaded");
		}
	}
}
