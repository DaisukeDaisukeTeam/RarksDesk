<?php

declare(strict_types = 1);

namespace rarksdesk\form\element;


class ButtonImage extends Element{

	private string $type;
	private string $data;

	public function __construct(bool $type, string $data){
		$this->type = $type? 'path': 'url';
		$this->data = $data;
	}

	public function jsonSerialize(){
		return[
			'image' => [
				'type' => $this->type,
				'data' => $this->data
			]
		];
	}
}