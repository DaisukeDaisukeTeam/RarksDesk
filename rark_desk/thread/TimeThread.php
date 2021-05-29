<?php

declare(strict_types = 1);

namespace rark_desk\thread;

use pocketmine\{
	Thread
};


final class TimeThread extends Thread{

	private int $run_time;
	private int $count;
	private bool $is_countdown;

	public function __construct(float $run_time = 1.0, int $default_time = 0, bool $is_countdown = false){
		$time = (int)$run_time*1000000;
		if($time<0) throw new \ErrorException('Runtime must be 0 or more');
		$this->run_time = $time;
		$this->count = $default_time;
		$this->is_countdown = $is_countdown;
	}

	public function run():void{
		while(!$this->isKilled){
			$this->is_countdown ? --$this->count : ++$this->count;
			usleep($this->run_time);
		}
	}

	public function getTime():int{
		return $this->count;
	}

	public function reset(?int $time = 0):void{
		$this->count = $time;
	}
}