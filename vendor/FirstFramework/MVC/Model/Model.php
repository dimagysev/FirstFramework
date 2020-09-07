<?php


namespace FirstFramework\MVC\Model;


use FirstFramework\DB\DBConnection;

abstract class Model implements ActiveRecords
{
    private $attributes = [];
    private $original = [];
    protected $fillable;
    protected static $table;
    protected static $idName = 'id';

    public function __construct($attributes = [])
    {
        if (count($attributes)){
            $this->fill($attributes);
            $this->attributes[$this->getIdName()] = $this->save();
        }
        $this->original = $this->attributes;
    }

    public function __set($attr, $value)
    {
        $this->attributes[$attr] = $value;
    }

    public function __get($attr)
    {
        if (property_exists($this, $attr)) {
            return $this->$attr;
        }
        return $this->attributes[$attr] ?? null;
    }

    public static function create(array $attributes): ActiveRecords
    {
        return new static($attributes);
    }

    public static function find(int $id, array $fields = ['*']): ?ActiveRecords
    {
        $sql = "SELECT " . implode(',', $fields)
            . " FROM " . static::$table
            . " WHERE " . "`" . static::$idName . "`" . "= ? LIMIT 1";
        $pstm = DBConnection::instance()->pdo()->prepare($sql);
        $pstm->execute([$id]);
        $pstm->setFetchMode(\PDO::FETCH_CLASS, static::class);
        
        return $pstm->fetch() ? $pstm->fetch() : null;
    }

    public static function findAll(array $fields = ['*']): array
    {
        $sql = "SELECT " . implode(',', $fields)
            . " FROM " . static::$table;
        $pstm = DBConnection::instance()->pdo()->prepare($sql);
        $pstm->execute();
        return $pstm->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function builder()
    {
        // TODO: Implement builder() method.
    }

    public function update(array $atrributes) : bool
    {
        $this->fill($atrributes);
        return $this->save();
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->getTable()} WHERE `{$this->getIdName()}` = {$this->id}";
        return DBConnection::instance()->pdo()->exec($sql);
    }

    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $attribute) {
            $this->attributes[$key] = $attribute;    
        }
    }

    public function save()
    {
        if (!$this->isFillable()) {
            throw new \Exception('Property is not fillable');
        }

        $values = array_values($this->attributes);
        $fields = $this->quoteFields(array_keys($this->attributes));

        if ($this->id && $this->isDirty()) {

            $setStr = implode(',', array_map(function ($field){
                return $field . '= ?';
            }, $fields));

            $sql = "UPDATE {$this->getTable()} SET {$setStr}";
            $pstm = DBConnection::instance()->pdo()->prepare($sql);

            if ($updated = $pstm->execute($values)){
                $this->original = $this->attributes;
                return $updated;
            }

        } else if (count($this->original) === 0) {

            $fields = implode(',',$fields);
            $slots = $this->genSlots(count($values));
            $sql = "INSERT INTO {$this->getTable()} ({$fields}) VALUES ({$slots})";
            $pstm = DBConnection::instance()->pdo()->prepare($sql);
            $pstm->execute($values);

            if ($id = DBConnection::instance()->pdo()->lastInsertId()){
                $this->original = $this->attributes;
                return $id;
            }
        }
        return false;
    }

    public function getTable(): string
    {
        return static::$table;
    }

    public function getIdName(): string
    {
        return static::$idName;
    }

    private function isDirty($attributes = null): bool
    {
        $dirty = $this->getDirty();
        $attributes = is_array($attributes) ? $attributes : func_get_args();
        if (empty($attributes)) {
            return !count($attributes);
        }
        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute, $dirty)) {
                return true;
            }
        }
        return false;
    }

    private function getDirty()
    {
        $dirty = [];
        foreach ($this->attributes as $key => $attribute) {
            if ($this->original[$key] !== $attribute) {
                $dirty[$key] = $attribute;
            }
        }
        return $dirty;
    }

    private function isFillable()
    {
        foreach ($this->attributes as $key => $value) {
            if (!in_array($key, $this->fillable)) {
                return false;
            }
        }
        return true;
    }

    private function genSlots(int $count): string
    {
        return implode(',', array_fill(0, $count, '?'));
    }

    private function quoteFields(array $fields, $quote = '`')
    {
        return array_map(function ($item) use ($quote) {
            return $quote . $item . $quote;
        }, $fields);
    }
}