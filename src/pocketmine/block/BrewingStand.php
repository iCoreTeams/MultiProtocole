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

use pocketmine\BedrockPlayer;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\math\Vector3;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;
use pocketmine\tile\BrewingStand as TileBrewingStand;
use pocketmine\tile\Tile;

class BrewingStand extends Transparent{

	protected $id = self::BREWING_STAND_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

    /**
     * @param Item        $item
     * @param Block       $block
     * @param Block       $target
     * @param int         $face
     * @param float       $fx
     * @param float       $fy
     * @param float       $fz
     * @param Player|null $player
     *
     * @return bool
     */
    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($block->getSide(Vector3::SIDE_DOWN)->isTransparent() === false){
            $this->getLevel()->setBlock($block, $this, true, true);

            $nbt = CompoundTag::create()
                ->setTag("Items", new ListTag([], NBT::TAG_Compound))
                ->setString("id", Tile::BREWING_STAND)
                ->setInt("x", $this->x)
                ->setInt("y", $this->y)
                ->setInt("z", $this->z);

            if($item->hasCustomName()){
                $nbt->setString("CustomName", $item->getCustomName());
            }

            if($item->hasCustomBlockData()){
                foreach($item->getCustomBlockData() as $k => $tag){
                    $nbt->setTag($k, $tag);
                }
            }

            Tile::createTile(Tile::BREWING_STAND, $this->getLevel(), $nbt);
            return true;
        }
        return false;
    }

	public function getName(){
		return "Brewing Stand";
	}

    /**
     * @return float
     */
    public function getHardness(){
        return 0.5;
    }

    /**
     * @return float
     */
    public function getResistance(): float
    {
        return 2.5;
    }

    /**
     * @return int
     */
    public function getLightLevel(){
        return 1;
    }

    /**
     * @param Item        $item
     * @param Player|null $player
     *
     * @return bool
     */
    public function onActivate(Item $item, Player $player = null){
        if($player instanceof Player){
            $t = $this->getLevel()->getTile($this);
            if($t instanceof TileBrewingStand){
                $brewingStand = $t;
            }else {
                $nbt = CompoundTag::create()
                    ->setTag("Items", new ListTag([], NBT::TAG_Compound))
                    ->setString("id", Tile::BREWING_STAND)
                    ->setInt("x", $this->x)
                    ->setInt("y", $this->y)
                    ->setInt("z", $this->z);
                $brewingStand = Tile::createTile(Tile::BREWING_STAND, $this->getLevel(), $nbt);
            }
            $player->addWindow($brewingStand->getInventory());
        }
        return true;
    }

    /**
     * @param Item $item
     *
     * @return array
     */
    public function getDrops(Item $item) : array{
        $drops = [];
        if($item->isPickaxe() >= Tool::TIER_WOODEN){
            $drops[] = [Item::BREWING_STAND, 0, 1];
        }
        return $drops;
    }

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}
}