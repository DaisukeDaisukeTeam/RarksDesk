<?php

declare(strict_types = 1);

interface Element extends \JsonSerializable{

	public function onSubmit(Player $player, $data):void;
}