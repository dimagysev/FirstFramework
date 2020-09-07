<?php


namespace FirstFramework\MVC\Model;


interface ActiveRecords
{
    /**
     * @param  array  $attributes
     *
     * @return ActiveRecords
     */
    public static function create(array $attributes): ActiveRecords;

    /**
     * @param  int  $id
     * @param  array  $fields
     *
     * @return ActiveRecords|null
     */
    public static function find(int $id, array $fields = []): ?ActiveRecords;

    /**
     * @param  array  $fields
     *
     * @return array
     */
    public static function findAll(array $fields = []): array;

    public static function builder();

    /**
     * @param  array  $atrributes
     *
     * @return bool
     */
    public function update(array $atrributes):bool;

    /**
     * @return mixed|false|int
     */
    public function delete();

    /**
     * @param  array  $attributes
     */
    public function fill(array $attributes): void;

    /**
     * @return mixed|int|bool
     */
    public function save();

    /**
     * @return string
     */
    public function getTable(): string;

    /**
     * @return string
     */
    public function getIdName(): string;
}