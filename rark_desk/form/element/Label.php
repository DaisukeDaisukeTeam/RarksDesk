<?php

declare(strict_types = 1);

namespace rark_desk\form\element;


class Label extends Element{

	private string $text;

	public function __construct(string $text = ''){
		$this->text = $text;
		parent::__construct();
	}

	public function jsonSerialize(){
		return [
			'type' => 'label',
			'text' => $this->text
		];
	}
}