<?php

declare(strict_types = 1);

namespace rarksdesk\permission;


abstract class Tag{

	public static function add(Player $player, string $tag):void{
		$list = $player->namedtag->getTag('rarksdesk');
		$set = $list === null? []: $list->getValue();
		$set[] = new StringTag($tag, '');
		$player->namedtag->setTag(new ListTag('rarksdesk', $set), true);
	}

	public static function remove(Player $player, string $tag):void{
		$nbt = $player->namedtag->getTag('rarksdesk');

		if($nbt === null) return;
		$nbt->removeTag($tag);
		$player->namedtag->setTag($nbt);

	}

	public static function getAllTag(Player $player):array{
		$tag = $player->namedtag->getTag('rarksdesk');

		if($tag === null) return [];
		$tags = [];
		foreach($tag->getValue() as $nbt) $tags[] = $nbt->getName();
		return $tags;
	}

	public static function hasTag(Player $player, string $tag):bool{
		return in_array($tag, self::getAllTag($player), true);
	}
}