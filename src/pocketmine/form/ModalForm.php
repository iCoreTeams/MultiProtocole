<?php

declare(strict_types=1);

namespace pocketmine\form;

class ModalForm extends Form{

	/** @var string */
	private string $content = "";

	/**
	 * @param string   $title = ""
	 */
	public function __construct(string $title = ""){
		parent::__construct($title);
		$this->data["type"] = "modal";
		$this->data["content"] = $this->content;
		$this->data["button1"] = "";
		$this->data["button2"] = "";
	}
	/**
	 * @return string
	 */
	public function getContent() : string{
		return $this->data["content"];
	}

	/**
	 * @param string $content
	 */
	public function setContent(string $content) : void{
		$this->data["content"] = $content;
	}

	/**
	 * @param string $text
	 */
	public function setButton1(string $text) : void{
		$this->data["button1"] = $text;
	}

	/**
	 * @return string
	 */
	public function getButton1() : string{
		return $this->data["button1"];
	}

	/**
	 * @param string $text
	 */
	public function setButton2(string $text) : void{
		$this->data["button2"] = $text;
	}

	/**
	 * @return string
	 */
	public function getButton2() : string{
		return $this->data["button2"];
	}
}
