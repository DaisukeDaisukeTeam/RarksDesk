<?php

declare(strict_types = 1);


class SimpleForm extends BaseForm{

	public const FORM_TYPE = 'form';
	public string $text = '';

	final public function addButton(Button ...$buttons):void{
		$this->addElement(...$buttons);
	}

	final public function onSubmit(Player $player, $data):bool{
		if(!is_int($data)) return false;
		($this->func)();
		return true;
	}
}