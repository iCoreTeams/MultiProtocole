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

namespace pocketmine\network\bedrock\palette;

use pocketmine\nbt\tag\CompoundTag;

final class R12ToCurrentBlockMapEntry{

	/** @var string */
	private $id;
	/** @var int */
	private $meta;
	/** @var CompoundTag */
	private $blockState;

	public function __construct(string $id, int $meta, CompoundTag $blockState){
		$this->id = $id;
		$this->meta = $meta;
		$this->blockState = $blockState;
	}

	public function getId() : string{
		return $this->id;
	}

	public function getMeta() : int{
		return $this->meta;
	}

	public function getBlockState() : CompoundTag{
		return $this->blockState;
	}

	public function __toString(){
		return "id=$this->id, meta=$this->meta, nbt=$this->blockState";
	}
}