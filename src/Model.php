<?php

namespace Zed\Framework;

use Zed\Framework\Model\QueryBuilder;
use ReflectionClass;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
abstract class Model
{
    /**
     * Get model's table name from property "table" inside model's class.
     * If it's not defined, it'll be gotten from reflection class on called
     * class's instance.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    final private function getTable(): string
    {
        return $this->table ?? strtolower((new ReflectionClass(static::class))->getShortName());
    }

    /**
     * Fetch column(s) from database using a key value pairs.
     * 
     * @since 1.0.1
     * 
     * @param string $column
     * @param string $match
     * 
     * @return QueryBuilder
     */
    public function where(string $column, string $match): QueryBuilder
    {
        return Application::$manager
            ->setTable((new static)->getTable())
            ->setModel(static::class)
            ->where($column, $match);
    }

    /**
     * Fetch a column from database using their unique id.
     * 
     * @since 1.0.1
     * 
     * @param int $id
     * 
     * @return Model
     */
    public function find(int $id): Model
    {
        return Application::$manager
            ->setTable((new static)->getTable())
            ->setModel(static::class)
            ->find($id);
    }

    /**
     * Create a model and store it into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @return Model
     */
    public function create(array $information): Model
    {
        return Application::$manager
            ->setTable((new static)->getTable())
            ->setModel(static::class)
            ->create($information);
    }

    /**
     * Update a model's information and store them into database.
     * 
     * @since 1.0.1
     * 
     * @param array $information
     * 
     * @return bool
     */
    public function update(array $information): bool
    {
        return Application::$manager
            ->setTable($this->getTable())
            ->setId($this->id)
            ->update($information);
    }

    /**
     * Delete a model from database.
     * 
     * @since 1.0.1
     * 
     * @return bool
     */
    public function delete(): bool
    {
        return Application::$manager
            ->setTable($this->getTable())
            ->setId($this->id)
            ->delete();
    }
}
