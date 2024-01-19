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

namespace pocketmine\network\bedrock\skin;

use pocketmine\network\bedrock\protocol\types\skin\SerializedSkinImage;
use pocketmine\network\bedrock\protocol\types\skin\Skin as BedrockSkin;
use pocketmine\network\mcpe\protocol\types\Skin as McpeSkin;
use function file_get_contents;
use function json_decode;

class SkinConverter{

	/** @var array[] */
	private static $skinIdToBedrockMap = [];

	public static function init() : void{
		$skinIdMap = json_decode(file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/pw10_skins/skin_id_map.json"), true);
		foreach($skinIdMap as $skinId => $item){
			$geometryData = file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/pw10_skins/geometry/" . $item["geometry"] . ".json");

			$data = [
				"geometry" => $item["geometry"],
				"geometryData" => $geometryData,
			];
			if(isset($item["cape"])){
				$capeData = file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/bedrock/pw10_skins/capes/" . $item["cape"] . ".skindata");

				$data["cape"] = $item["cape"];
				$data["capeData"] = $capeData;
			}
			self::$skinIdToBedrockMap[$skinId] = $data;
		}
	}

	public static function convert(McpeSkin $mcpeSkin) : BedrockSkin{
		$mapping = self::$skinIdToBedrockMap[$mcpeSkin->getSkinId()] ?? null;
		if($mapping === null){
			return BedrockSkin::empty();
		}

		return new BedrockSkin(
			$mcpeSkin->getSkinId(),
			"",
			'{"geometry":{"default":"' . $mapping["geometry"] . '"}}',
			SerializedSkinImage::fromLegacyImageData($mcpeSkin->getSkinData()),
			[],
			isset($mapping["capeData"]) ? new SerializedSkinImage(64, 32, $mapping["capeData"]) : SerializedSkinImage::empty(),
			$mapping["geometryData"],
			"",
			false,
			false,
			false,
			$mapping["cape"] ?? ""
		);
	}
}