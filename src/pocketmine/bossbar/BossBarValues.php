<?php

declare(strict_types=1);

namespace pocketmine\bossbar;

use pocketmine\entity\Attribute;

class BossBarValues extends Attribute{

	public const NETWORK_ID = 37; // Ender Dragon

	/** @var float */
	protected $min;
	/** @var float */
	protected $max;
	/** @var float */
	protected $value;
	/** @var string */
	protected $name;

	public function __construct(float $min, float $max, float $value, string $name){
		$this->min = $min;
		$this->max = $max;
		$this->value = $value;
		$this->name = $name;
	}

	public function getMinValue() : float{
		return $this->min;
	}

	public function getMaxValue() : float{
		return $this->max;
	}

	public function getValue() : float{
		return $this->value;
	}

	public function getName() : string{
		return $this->name;
	}

	public function getDefaultValue() : float{
		return $this->min;
	}
}