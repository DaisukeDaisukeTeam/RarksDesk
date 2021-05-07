<?php

declare(strict_types = 1);

namespace rark_desk\scoreboard;

use pocketmine\{
	Player,
	network\mcpe\protocol\SetDisplayObjectivePacket,
	network\mcpe\protocol\SetScorePacket,
	network\mcpe\protocol\types\ScorePacketEntry
};


class ScoreBoard{

	private const SLOT = 'sidebar';

	private static int $scoreboard_count = 0;
	private static array $viewers = [];
	private int $line;
	private string $title;
	private int $id;
	private array $score = [];

	public function __construct(string $title){
		$this->title = $title;
		$this->id = ++self::$scoreboard_count;
	}

	public function getId():int{
		return $this->id;
	}

	public function add(string $text, ?int $line = null):void{
		$line?? $line = ++$this->line;
		$this->score[$line] = [$text, true];
	}

	public function remove(int $line):void{
		if(!isset($this->score[$line])) return;
		unset($this->score[$line]);
		$this->score = array_filter($this->score);
		--$this->line;
	}

	public function sendScoreboard(Player ...$targets):void{
		$pk = new SetDisplayObjectivePacket;
		$pk->displaySlot = self::SLOT;
		$pk->objectiveName = self::SLOT;
		$pk->criteriaName = 'scoreboard.unknown';
		$pk->displayName = $this->title;
		$pk->sortOrder = 0;

		foreach($targets as $target){
			$target->sendDataPacket($pk);
			self::$viewers[$this->id][] = $target;
			$this->update();
		}
	}

	public function removeScoreboard(Player ...$targets):void{
		$entry = new ScorePacketEntry;
		$entry->objectiveName = self::SLOT;
		$entry->scoreboardId = $this->id;
		$pk = new SetScorePacket;
		$pk->type = SetScorePacket::TYPE_REMOVE;
		$pk->entries[] = $entry;

		foreach($targets as $target){
			if(!$this->isViewer($target)) continue;
			$target->sendDataPacket($pk);
		}
	}

	public function update(){
		$pk = new SetScorePacket;
		$pk->type = SetScorePacket::TYPE_CHANGE;

		foreach($this->score as $line => $text_data){
			if(!$text_data[1]) continue;
			$this->score[$line] = [$text_data[0], false];
			$entry = new ScorePacketEntry;
			$entry->objectiveName = self::SLOT;
			$entry->type = $entry::TYPE_FAKE_PLAYER;
			$entry->customName = $text_data[0];
			$entry->score = $line;
			$entry->scoreboardId = $this->id;
			$pk->entries[] = $entry;
		}
		foreach(self::$viewers[$this->id] as $viewer){
			$viewer->sendDataPacket($pk);
		}
	}

	public function isViewer(Player $player):bool{
		foreach(self::$viewers[$this->id] as $viewer){
			if($viewer->getName() === $player->getName()) return true;
		}
		return false;
	}
}