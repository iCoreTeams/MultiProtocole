<?php

declare(strict_types=1);

namespace pocketmine\form;

class ServerSettingsForm extends CustomForm{

	/**
	 * @param string   $title = ""
	 * @param int      $iconType = -1
	 * @param string   $iconPath = ""
	 */
	public function __construct(string $title = "", int $iconType = -1, string $iconPath = ""){
		if($iconType !== -1){
			$this->data["icon"]["type"] = $iconType === 0 ? "path" : "url";
			$this->data["icon"]["data"] = $iconPath;
		}
		parent::__construct($title);
	}
}