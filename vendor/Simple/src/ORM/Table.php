<?php
	namespace Simple\ORM;
	
	use Simple\ORM\Interfaces\EntityInterface;
	use Simple\ORM\Components\QueryBuilder;
	use Simple\Util\Builder;

	abstract class Table extends QueryBuilder
	{
		const ENTITY_NAMESPACE = 'App\\Model\\Entity\\';

		private $belongsTo = [];

		private $table;
		
		private $primaryKey;

		public function setDatabase(string $databaseProfile)
		{
			$this->configureDatabase($databaseProfile, $this->getEntityName());
		}

		public function newEntity()
		{
			$entity = new Builder($this->getEntityName());

			return $entity->getBuiltInstance();
		}

		public function patchEntity(EntityInterface $entity, array $data)
		{
			foreach ($data as $attribute => $value) {
				if (is_string($attribute)) {
					$entity->$attribute = $value;
				}
			}

			return $entity;
		}

		protected function getEntityName()
		{
			$entityName = replace(splitNamespace(get_class($this)), 'Table', '');

			return Table::ENTITY_NAMESPACE . $entityName;
		}

		protected function setBelongsTo(string $fieldName, array $options)
		{
			$this->belongsTo[$fieldName] = $options;
		}

		protected function getBelongsTo(string $fieldName)
		{	
			if (isset($this->belongsTo[$fieldName])) {
				return $this->belongsTo[$fieldName];
			}
			return false;
		}

		protected function setTable(string $table)
		{
			$this->table = $table;
		}

		protected function getTable()
		{
			return $this->table;
		}

		protected function setPrimaryKey(string $primaryKey)
		{
			$this->primaryKey = $primaryKey;
		}

		protected function getPrimaryKey()
		{
			return $this->primaryKey;
		}

		public function find(array $fields)
		{
			if (!empty($this->getTable())) {
				return $this->select($fields)
					->from([$this->getTable()]);
			}
			return false;
		}

		public function get($key)
		{
			if (!empty($key) && !empty($this->getTable())) {
				if ($key === 'all') {
					return $this->find(['*'])
							->fetch('all');
				}
				else if (!empty($this->getPrimaryKey())) {
					return $this->find(['*'])
						->where([$this->getPrimaryKey() . ' = ' => $key])
						->fetch('class');
				}
			}
			return false;
		}

		public function save(EntityInterface $entity)
		{	
			if (!empty($this->getTable())) {
				$primaryKey = $this->getPrimaryKey();

				if (isset($entity->$primaryKey)) {
					if (!$this->get($entity->$primaryKey)) {
						return $this->insert($this->getTable())
							->values((array) $entity)
							->fetch('rowCount');
					}
					$primaryKeyValue = $entity->$primaryKey;
					unset($entity->$primaryKey);

					return $this->update($this->getTable())
						->set((array) $entity)
						->where([$primaryKey . ' = ' => $primaryKeyValue])
						->fetch('rowCount');
				}
			}
			return false;
		}

		public function remove(EntityInterface $entity) 
		{
			$primaryKey = $this->getPrimaryKey();

			if (isset($entity->$primaryKey) && !empty($this->getTable())) {
				return $this->delete($this->getTable())
					->where([$primaryKey . ' = ' => $entity->$primaryKey])
					->fetch('rowCount');
			}
			return false;
		}
	}