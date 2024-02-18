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

namespace pocketmine\block;

use pocketmine\inventory\EnchantInventory;
use pocketmine\item\Item;
use pocketmine\item\TieredTool;
use pocketmine\item\Tool;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\tile\EnchantTable;
use pocketmine\tile\Tile;

class EnchantingTable extends Transparent{

	protected $id = self::ENCHANTING_TABLE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->setBlock($block, $this, true, true);
		$nbt = CompoundTag::create()
			->setString("id", Tile::ENCHANT_TABLE)
			->setInt("x", $this->x)
			->setInt("y", $this->y)
			->setInt("z", $this->z);

		if($item->hasCustomName()){
			$nbt->setString("CustomName", $item->getCustomName());
		}

		if($item->hasCustomBlockData()){
			foreach($item->getCustomBlockData() as $key => $v){
				$nbt->setTag($key, $v);
			}
		}

		Tile::createTile(Tile::ENCHANT_TABLE, $this->getLevel(), $nbt);

		return true;
	}

	public function getHardness(){
		return 5;
	}

	public function getBlastResistance() : float{
		return 6000;
	}

	public function getName(){
		return "Enchanting Table";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getToolHarvestLevel() : int{
		return TieredTool::TIER_WOODEN;
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){
            $tile = $this->getLevel()->getTile($this);
            if(!($tile instanceof EnchantTable)){
                $this->getLevel()->setBlock($this, $this, true, true);
                $nbt = CompoundTag::create()
                    ->setString("id", Tile::ENCHANT_TABLE)
                    ->setInt("x", $this->x)
                    ->setInt("y", $this->y)
                    ->setInt("z", $this->z);

                if($item->hasCustomName()){
                    $nbt->setString("CustomName", $item->getCustomName());
                }

                if($item->hasCustomBlockData()){
                    foreach($item->getCustomBlockData() as $key => $v){
                        $nbt->setTag($key, $v);
                    }
                }

                $tile = Tile::createTile(Tile::ENCHANT_TABLE, $this->getLevel(), $nbt);
            }
			$player->addWindow(new EnchantInventory($tile));
			$player->craftingType = Player::CRAFTING_ENCHANT;
		}

		return true;
	}

	public function canBeActivated() : bool{
		return true;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[$this->id, 0, 1],
			];
		}else{
			return [];
		}
	}
}