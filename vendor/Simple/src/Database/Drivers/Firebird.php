<?php 
	namespace Simple\Database\Drivers;

	use Simple\Database\Drivers\PDODriver;

	class Firebird extends PDODriver
	{
		private static $dsn = 'firebird:dbname=%host%:%path%; charset=%encode%';

		public function __construct(array $configs)
		{
			$this->setPdoConfigs($this->mountPdoConfig($configs));
		}

		protected function mountPdoConfig(array $configs)
		{
			return [
				'dsn' => replaceRecursive(static::$dsn, [
					'%host%' => $configs['host'],
					'%path%' => $configs['path'],
					'%encode%' => $configs['encoding']
				]),
				'user' => $configs['user'],
				'password' => $configs['password']
			];
		}
	}	