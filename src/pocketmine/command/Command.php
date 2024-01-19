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

/**
 * Command handling related classes
 */
namespace pocketmine\command;

use pocketmine\event\TextContainer;
use pocketmine\event\TimingsHandler;
use pocketmine\event\TranslationContainer;
use pocketmine\command\data\CommandParameter;
use pocketmine\command\data\CommandOverload;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

use function explode;
use function file_get_contents;
use function json_decode;
use function str_replace;

abstract class Command{
	/** @var array */
	private static $defaultDataTemplate = null;

	/** @var string */
	private $name;
	/** @var array */
	protected $commandData = null;

	/** @var string */
	private $nextLabel;

	/** @var string */
	private $label;

	/**
	 * @var string[]
	 */
	private $activeAliases = [];

	/** @var CommandMap */
	private $commandMap = null;

	/** @var string */
	protected $description = "";

	/** @var string */
	protected $usageMessage;

	/** @var string */
	private $permissionMessage = null;

	/** @var TimingsHandler */
	public $timings;

	/**
	 * @param string   $name
	 * @param string   $description
	 * @param string   $usageMessage
	 * @param string[] $aliases
	 */
	public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
		$this->commandData = SimpleCommandMap::$commandData[$name] ?? self::generateDefaultData();
		$this->name = $name;
		$this->setLabel($name);
		$this->setDescription($description);
		$this->usageMessage = $usageMessage ?? ("/" . $name);
		$this->setAliases($aliases);
	}

	public function addParameter(CommandParameter $parameter, int|string $columnId = "default") : void{
		$overload = $this->commandData["overloads"][$columnId] ?? new CommandOverload();

		if (!$overload instanceof CommandOverload) {
			unset($this->commandData["overloads"][$columnId]);
			$overload = new CommandOverload();
		}

		$overload->getInput()->addParameter($parameter);

		if (!isset($this->commandData["overloads"][$columnId])) {
			$this->commandData["overloads"][$columnId] = $overload;
		}
	}

	/*public function addSubCommand(string $name, CommandParameter ...$parameters) : void{
		$enumParameter = new CommandParameterEnum($name, false, [$name]);
		$overload = [
			"input" => [
				"parameters" => [
					$enumParameter,
					$parameters
				]
			],
			"output" => []
		];
		$this->commandData["overloads"][$name] = $overload;
	}*/

	/**
	 * Returns an array containing command data
	 *
	 * @return array
	 */
	public function getDefaultCommandData() : array{
		return $this->commandData;
	}

	/**
	 * Generates modified command data for the specified player
	 * for AvailableCommandsPacket.
	 *
	 * @param Player $player
	 *
	 * @return array
	 */
	public function generateCustomCommandData(Player $player) : array{
		//TODO: fix command permission filtering on join
		/*if(!$this->testPermissionSilent($player)){
			return null;
		}*/
		$customData = $this->commandData;
		$customData["aliases"] = $this->getAliases();
		/*foreach($customData["overloads"] as $overloadName => $overload){
			if(isset($overload["pocketminePermission"]) and !$player->hasPermission($overload["pocketminePermission"])){
				unset($customData["overloads"][$overloadName]);
			}
		}*/
		return $customData;
	}

	/**
	 * @return array
	 */
	public function getOverloads() : array{
		return $this->commandData["overloads"];
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $commandLabel
	 * @param string[]      $args
	 *
	 * @return mixed
	 */
	abstract public function execute(CommandSender $sender, string $commandLabel, array $args);

	/**
	 * @return string
	 */
	public function getName() : string{
		return $this->name;
	}

	/**
	 * @return string|null
	 */
	public function getPermission(){
		return $this->commandData["pocketminePermission"] ?? null;
	}


	/**
	 * @param string|null $permission
	 */
	public function setPermission(string $permission = null){
		if($permission !== null){
			$this->commandData["pocketminePermission"] = $permission;
		}else{
			unset($this->commandData["pocketminePermission"]);
		}
	}

	/**
	 * @param CommandSender $target
	 *
	 * @return bool
	 */
	public function testPermission(CommandSender $target) : bool{
		if($this->testPermissionSilent($target)){
			return true;
		}

		if($this->permissionMessage === null){
			$target->sendCommandMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));
		}elseif($this->permissionMessage !== ""){
			$target->sendMessage(str_replace("<permission>", $this->getPermission(), $this->permissionMessage));
		}

		return false;
	}

	/**
	 * @param CommandSender $target
	 *
	 * @return bool
	 */
	public function testPermissionSilent(CommandSender $target) : bool{
		if(($perm = $this->getPermission()) === null or $perm === ""){
			return true;
		}

		foreach(explode(";", $perm) as $permission){
			if($target->hasPermission($permission)){
				return true;
			}
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function getLabel() : string{
		return $this->label;
	}

	public function setLabel(string $name) : bool{
		$this->nextLabel = $name;
		if(!$this->isRegistered()){
			if($this->timings instanceof TimingsHandler){
				$this->timings->remove();
			}
			$this->timings = new TimingsHandler("** Command: " . $name);
			$this->label = $name;

			return true;
		}

		return false;
	}

	/**
	 * Registers the command into a Command map
	 *
	 * @param CommandMap $commandMap
	 *
	 * @return bool
	 */
	public function register(CommandMap $commandMap) : bool{
		if($this->allowChangesFrom($commandMap)){
			$this->commandMap = $commandMap;

			return true;
		}

		return false;
	}

	/**
	 * @param CommandMap $commandMap
	 *
	 * @return bool
	 */
	public function unregister(CommandMap $commandMap) : bool{
		if($this->allowChangesFrom($commandMap)){
			$this->commandMap = null;
			$this->activeAliases = $this->commandData["aliases"];
			$this->label = $this->nextLabel;

			return true;
		}

		return false;
	}

	/**
	 * @param CommandMap $commandMap
	 *
	 * @return bool
	 */
	private function allowChangesFrom(CommandMap $commandMap) : bool{
		return $this->commandMap === null or $this->commandMap === $commandMap;
	}

	/**
	 * @return bool
	 */
	public function isRegistered() : bool{
		return $this->commandMap !== null;
	}

	/**
	 * @return string[]
	 */
	public function getAliases() : array{
		return $this->activeAliases;
	}

	/**
	 * @return string
	 */
	public function getPermissionMessage() : string{
		return $this->permissionMessage;
	}

	/**
	 * @return string
	 */
	public function getDescription() : string{
		return $this->commandData["description"];
	}

	/**
	 * @return string
	 */
	public function getUsage() : string{
		return $this->usageMessage;
	}

	/**
	 * @param string[] $aliases
	 */
	public function setAliases(array $aliases){
		$this->commandData["aliases"] = $aliases;
		if(!$this->isRegistered()){
			$this->activeAliases = (array) $aliases;
		}
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description){
		$this->commandData["description"] = $description;
	}

	/**
	 * @param string $permissionMessage
	 */
	public function setPermissionMessage(string $permissionMessage){
		$this->permissionMessage = $permissionMessage;
	}

	/**
	 * @param string $usage
	 */
	public function setUsage(string $usage){
		$this->usageMessage = $usage;
	}

	/**
	 * @return array
	 */
	final public static function generateDefaultData() : array{
		if(self::$defaultDataTemplate === null){
			self::$defaultDataTemplate = json_decode(file_get_contents(Server::getInstance()->getFilePath() . "src/pocketmine/resources/command_default.json"), true);
		}
		return self::$defaultDataTemplate;
	}

	/**
	 * @param CommandSender        $source
	 * @param TextContainer|string $message
	 * @param bool                 $sendToSource
	 */
	public static function broadcastCommandMessage(CommandSender $source, $message, bool $sendToSource = true){
		if($message instanceof TextContainer){
			$m = clone $message;
			$result = "[" . $source->getName() . ": " . ($source->getServer()->getLanguage()->get($m->getText()) !== $m->getText() ? "%" : "") . $m->getText() . "]";

			$users = $source->getServer()->getPluginManager()->getPermissionSubscriptions(Server::BROADCAST_CHANNEL_ADMINISTRATIVE);
			$colored = TextFormat::GRAY . TextFormat::ITALIC . $result;

			$m->setText($result);
			$result = clone $m;
			$m->setText($colored);
			$colored = clone $m;
		}else{
			$users = $source->getServer()->getPluginManager()->getPermissionSubscriptions(Server::BROADCAST_CHANNEL_ADMINISTRATIVE);
			$result = new TranslationContainer("chat.type.admin", [$source->getName(), $message]);
			$colored = new TranslationContainer(TextFormat::GRAY . TextFormat::ITALIC . "%chat.type.admin", [$source->getName(), $message]);
		}

		if($sendToSource === true and !($source instanceof ConsoleCommandSender)){
			$source->sendCommandMessage($message);
		}

		foreach($users as $user){
			if($user instanceof CommandSender){
				if($user instanceof ConsoleCommandSender){
					$user->sendCommandMessage($result);
				}elseif($user !== $source){
					$user->sendCommandMessage($colored);
				}
			}
		}
	}

	/**
	 * @return string
	 */
	public function __toString() : string{
		return $this->name;
	}
}
