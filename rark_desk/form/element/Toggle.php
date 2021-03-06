<?php

declare(strict_types = 1);

namespace rarksdesk\form\element;


class Toggle extends Element{

	private string $text;
	private bool $default;

	public function __construct(string $text = '', bool $default = false){
		$this->text = $text;
		$this->default = $default;
	}

	public function jsonSerialize(){
		return [
			'type' => 'toggle',
			'text' => $this->text,
			'default' => $this->default
		];
	}
}