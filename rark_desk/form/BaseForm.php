<?php

declare(strict_types = 1);


abstract class BaseForm implements Form{

	public const FORM_TYPE = 'unknown';

	public string $title = 'form.name.unknown';
	private array $content = [];
	private array $elements = [];
	/** @var callable|null */
	private $func;

	abstract protected function onSubmit(Player $player, $data):bool;

	public function __construct(?callable $func = null){
		$this->func = $func;
	}

	final protected function addElement(Element ...$elements):void{
		foreach($elements as $element){
			$this->elements[] = $element;
			$this->content[] = json_encode($element);
		}
	}

	final public function jsonSerialize():array{
		return array_merge(
			[
				'type' => static::FORM_TYPE,
				'title' => $this->title,
			],
			$this->content
		);
	}

	final public function handleResponce(Player $player, $data):void{
		if($data === null){
			$this->onCancelled($player);
			return;
		}
		if(!$this->onSubmit($player, $data)) return;
		foreach($this->elements as $element){
			$element->onSubmit($player, $data);
		}
	}
}