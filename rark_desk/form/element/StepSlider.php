<?php

declare(strict_types = 1);

namespace rarksdesk\form\element;


class StepSlider extends Element{

	private string $text;
	private int $default;
	private array $steps;

	public function __construct(string $text, int $default = 0, string ...$steps){
		$this->text = $text;
		$this->default = $default;
		$this->steps = $steps;
	}

	public function jsonSerialize(){
		return [
			'type' => 'step_slider',
			'text' => $this->text,
			'steps' => $this->steps,
			'default' => $this->default
		];
	}
}