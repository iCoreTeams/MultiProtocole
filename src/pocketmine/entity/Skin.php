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

namespace pocketmine\entity;

use pocketmine\network\bedrock\protocol\types\skin\Skin as BedrockSkin;
use pocketmine\network\bedrock\skin\SkinConverter as BedrockSkinConverter;
use pocketmine\network\mcpe\protocol\types\Skin as McpeSkin;
use pocketmine\network\mcpe\skin\SkinConverter as McpeSkinConverter;

class Skin{

	/** @var McpeSkin */
	protected $mcpeSkin;
	/** @var BedrockSkin */
	protected $bedrockSkin;

	public static function fromMcpeSkin(McpeSkin $mcpeSkin) : self{
		$bedrockSkin = BedrockSkinConverter::convert($mcpeSkin);
		return new self($mcpeSkin, $bedrockSkin);
	}

	public static function fromBedrockSkin(BedrockSkin $bedrockSkin) : self{
		$mcpeSkin = McpeSkinConverter::convert($bedrockSkin);
		return new self($mcpeSkin, $bedrockSkin);
	}

	public function __construct(McpeSkin $mcpeSkin, BedrockSkin $bedrockSkin){
		$this->mcpeSkin = $mcpeSkin;
		$this->bedrockSkin = $bedrockSkin;
	}

	/**
	 * @return bool
	 */
	public function isValid() : bool{
		return $this->mcpeSkin !== null and $this->bedrockSkin !== null and $this->mcpeSkin->isValid() and $this->bedrockSkin->isValid();
	}

	/**
	 * @return McpeSkin
	 */
	public function getMcpeSkin() : McpeSkin{
		return $this->mcpeSkin;
	}

	/**
	 * @return BedrockSkin
	 */
	public function getBedrockSkin() : BedrockSkin{
		return $this->bedrockSkin;
	}
}