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

use pocketmine\network\bedrock\palette\ActorMapping;
use pocketmine\network\bedrock\protocol\AvailableActorIdentifiersPacket;
use pocketmine\network\bedrock\protocol\BiomeDefinitionListPacket;
use function file_get_contents;

final class StaticPacketCache{
	private static string $biomeDefs;
	private static string $availableActorIdentifiers;

	private static BiomeDefinitionListPacket $biomeDefsPkt;
	private static AvailableActorIdentifiersPacket $actorIdentifiersPkt;

	public static function init() : void
    {
        $biomeDefs = new BiomeDefinitionListPacket();
        $biomeDefs->namedtag = file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/biome_definitions.nbt");
        self::$biomeDefsPkt = clone $biomeDefs;

        $actorIdentifiers = new AvailableActorIdentifiersPacket();
        $actorIdentifiers->namedtag = ActorMapping::getEncodedActorIdentifiers();
        self::$actorIdentifiersPkt = clone $actorIdentifiers;

        $stream = new BedrockPacketBatch();
        $stream->putPacket(self::$biomeDefsPkt);

        self::$biomeDefs = NetworkCompression::compress($stream->buffer);

        $stream->reset();
        $stream->putPacket(self::$actorIdentifiersPkt);

        self::$availableActorIdentifiers = NetworkCompression::compress($stream->buffer);
    }

	/**
	 * @return string
	 */
	public static function getBiomeDefs() : string{
		return self::$biomeDefs;
	}

	/**
	 * @return string
	 */
	public static function getAvailableActorIdentifiers() : string{
        return self::$availableActorIdentifiers;
	}
}