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

namespace pocketmine\network\bedrock\protocol\types\itemStack;

use pocketmine\item\Item;
use pocketmine\network\bedrock\protocol\DataPacket;
use pocketmine\network\bedrock\protocol\ItemStackRequestPacket;
use function count;

class AutoCraftRecipeStackRequestAction extends StackRequestAction{

	/** @var int */
	protected $recipeNetworkId;
	/** @var int */
	protected $repetitions;
	/** @var Item[] */
	protected $ingredients = [];

	/**
	 * @return int
	 */
	public function getRecipeNetworkId() : int{
		return $this->recipeNetworkId;
	}

	/**
	 * @return int
	 */
	public function getRepetitions() : int{
		return $this->repetitions;
	}

	/**
	 * @return Item[]
	 */
	public function getIngredients() : array{
		return $this->ingredients;
	}

	public function getActionId() : int{
		return ItemStackRequestPacket::ACTION_CRAFT_RECIPE_AUTO;
	}

	public function decode(DataPacket $stream) : void{
		$this->recipeNetworkId = $stream->getUnsignedVarInt();
		$this->repetitions = $stream->getByte();
		$this->ingredients = [];
		for($i = 0, $count = $stream->getUnsignedVarInt(); $i < $count; ++$i){
			$this->ingredients[] = $stream->getRecipeIngredient();
		}
	}

	public function encode(DataPacket $stream) : void{
		$stream->putUnsignedVarInt($this->recipeNetworkId);
		$stream->putByte($this->repetitions);
		$stream->putUnsignedVarInt(count($this->ingredients));
		foreach($this->ingredients as $ingredient){
			$stream->putRecipeIngredient($ingredient);
		}
	}
}