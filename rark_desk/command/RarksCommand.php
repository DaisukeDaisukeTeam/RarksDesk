<?php


final class RarksCommand{
	private static array $commands = [];

	public static function __construct(string $command, string $description, array $aliases, Permission $permission){
		self::$commands[$command] = [
			'description' => $description,
			'aliases' => $aliases,
			'permission' => $permission
		];
	}
}