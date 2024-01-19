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

namespace pocketmine\network\bedrock\protocol\types;

use pocketmine\network\bedrock\protocol\MapInfoRequestPacket;
use pocketmine\utils\Color;
use function intdiv;

final class MapInfoRequestPacketClientPixel{

	private const Y_INDEX_MULTIPLIER = 128;

	/** @var Color */
	public $color;
	/** @var int */
	public $x;
	/** @var int */
	public $y;

	public function __construct(Color $color, int $x, int $y){
		$this->color = $color;
		$this->x = $x;
		$this->y = $y;
	}

	public static function read(MapInfoRequestPacket $in) : self{
		$color = $in->getLInt();
		$index = $in->getLShort();

		$x = $index % self::Y_INDEX_MULTIPLIER;
		$y = intdiv($index, self::Y_INDEX_MULTIPLIER);

		return new self(Color::fromRGBA($color), $x, $y);
	}

	public function write(MapInfoRequestPacket $out) : void{
		$out->putLInt($this->color->toRGBA());
		$out->putLShort($this->x + ($this->y * self::Y_INDEX_MULTIPLIER));
	}
}