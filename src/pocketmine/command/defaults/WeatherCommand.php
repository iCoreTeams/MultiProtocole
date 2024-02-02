<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\level\Level;
use pocketmine\level\weather\Weather;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class WeatherCommand extends VanillaCommand{

	/**
	 * WeatherCommand constructor.
	 *
	 * @param string $name
	 */
	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.weather.description",
			"%pocketmine.command.weather.usage"
		);
		$this->setPermission("pocketmine.command.weather");
	}

	/**
	 * @param CommandSender $sender
	 * @param string $currentAlias
	 * @param array $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) < 1){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		if($sender instanceof Player){
			$wea = Weather::getWeatherFromString($args[0]);
			if(!isset($args[1])) {
                $server = $sender->getServer();
                $weatherRandomDurationMin = $server->getAdvancedProperty("level.weather-random-duration-min", 6000);
                $weatherRandomDurationMax = $server->getAdvancedProperty("level.weather-random-duration-max", 12000);
                $duration = mt_rand(
                    min($weatherRandomDurationMin, $weatherRandomDurationMax),
                    max($weatherRandomDurationMin, $weatherRandomDurationMax));
            }
			else $duration = (int) $args[1];
			if($wea >= 0 and $wea <= 3){
				$sender->getLevel()->getWeather()->setWeather($wea, $duration);
				$sender->sendMessage(new TranslationContainer("pocketmine.command.weather.changed", [$sender->getLevel()->getFolderName()]));
				return true;
			}else{
				$sender->sendMessage(TextFormat::RED . "%pocketmine.command.weather.invalid");
				return false;
			}
		}

		if(count($args) < 2){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
			return false;
		}

		$level = $sender->getServer()->getLevelByName($args[0]);
		if(!$level instanceof Level){
			$sender->sendMessage(TextFormat::RED . "%pocketmine.command.weather.invalid.level");
			return false;
		}

		$wea = Weather::getWeatherFromString($args[1]);
		if(!isset($args[1])){
            $server = $sender->getServer();
            $weatherRandomDurationMin = $server->getAdvancedProperty("level.weather-random-duration-min", 6000);
            $weatherRandomDurationMax = $server->getAdvancedProperty("level.weather-random-duration-max", 12000);
            $duration = mt_rand(
                min($weatherRandomDurationMin, $weatherRandomDurationMax),
                max($weatherRandomDurationMin, $weatherRandomDurationMax));
        }
		else $duration = (int) $args[1];
		if($wea >= 0 and $wea <= 3){
			$level->getWeather()->setWeather($wea, $duration);
			$sender->sendMessage(new TranslationContainer("pocketmine.command.weather.changed", [$level->getFolderName()]));
			return true;
		}else{
			$sender->sendMessage(TextFormat::RED . "%pocketmine.command.weather.invalid");
			return false;
		}
	}
}
