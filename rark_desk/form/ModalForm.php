<?php

declare(strict_types = 1);


class ModalForm extends BaseForm{

	public const FORM_TYPE = 'modal';
	public string $text = '';

	final public function addButton(Button $button1, Button $button2):void{
		$this->addElement($button1, $button2);
	}

	final public function onSubmit(Player $player, $data):bool{
		if(!is_bool($data)) return false;
		($this->func)();
		return true;
	}
}