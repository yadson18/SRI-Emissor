<?php 
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class PageTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('default');

			$this->setTable('tableName');

			$this->setPrimaryKey('id');

			$this->setBelongsTo('', []);
		}

		protected function defaultValidator(Validator $validator)
		{
			return $validator;
		}
	}