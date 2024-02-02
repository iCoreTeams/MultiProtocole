<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\tile\Beacon as TileBeacon;
use pocketmine\tile\Tile;

class Beacon extends Transparent
{

    protected $id = self::BEACON;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName()
    {
        return "Beacon";
    }

    public function getLightLevel()
    {
        return 15;
    }

    public function getResistance(): float
    {
        return 15;
    }

    public function getHardness()
    {
        return 3;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $this->getLevel()->setBlock($this, $this, true, true);
        $nbt = CompoundTag::create()
            ->setString("id", Tile::BEACON)
            ->setInt("x", $this->x)
            ->setInt("y", $this->y)
            ->setInt("z", $this->z)
            ->setByte("isMovable", 0)
            ->setInt("primary", 0)
            ->setInt("secondary", 0);
        Tile::createTile(Tile::BEACON, $this->getLevel(), $nbt);
        return true;
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if ($player instanceof Player) {
            $top = $this->getSide(Vector3::SIDE_UP);
            if ($top->isTransparent() !== true) {
                return true;
            }

            $t = $this->getLevel()->getTile($this);
            $beacon = null;
            if ($t instanceof TileBeacon) {
                $beacon = $t;
            } else {
                $nbt = CompoundTag::create()
                    ->setString("id", Tile::BEACON)
                    ->setInt("x", $this->x)
                    ->setInt("y", $this->y)
                    ->setInt("z", $this->z)
                    ->setByte("isMovable", 0)
                    ->setInt("primary", 0)
                    ->setInt("secondary", 0);
                Tile::createTile(Tile::BEACON, $this->getLevel(), $nbt);
            }

            $player->addWindow($beacon->getInventory());
        }

        return true;
    }

    public function onBreak(Item $item, Player $player = null): bool
    {
        $this->getLevel()->setBlock($this, Block::get(Block::AIR), true, true);
        return true;
    }

}