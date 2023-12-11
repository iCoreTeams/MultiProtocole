<?php

declare(strict_types=1);

namespace pocketmine\network\bedrock;

use pocketmine\network\bedrock\palette\ActorMapping;
use pocketmine\network\bedrock\protocol\AvailableActorIdentifiersPacket;
use pocketmine\network\bedrock\protocol\BiomeDefinitionListPacket;
use function file_get_contents;

final class StaticPacketCache{

	private static $biomeDefs = '';
	private static $availableActorIdentifiers = '';


	public static function init() : void
    {
        $biomeDefs = new BiomeDefinitionListPacket();
        $biomeDefs->namedtag = file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/biome_definitions.nbt");

        $actorIdentifiers = new AvailableActorIdentifiersPacket();
        $actorIdentifiers->namedtag = ActorMapping::getEncodedActorIdentifiers();

        $stream = new BedrockPacketBatch();
        $stream->putPacket($biomeDefs);

        self::$biomeDefs = NetworkCompression::compress($stream->buffer);

        $stream->reset();
        $stream->putPacket($actorIdentifiers);

        self::$availableActorIdentifiers = NetworkCompression::compress($stream->buffer);
    }

	/**
	 * @param int $protocol
	 *
	 * @return string
	 */
	public static function getBiomeDefs() : string{
		return self::$biomeDefs;
	}

	/**
	 * @param int $protocol
	 *
	 * @return string
	 */
	public static function getAvailableActorIdentifiers() : string{
		return self::$availableActorIdentifiers;
	}
}