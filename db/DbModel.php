<?php


namespace app\core\db;


use app\core\App;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($n) => ":$n", $attributes);
        $SQL = "INSERT INTO $tableName (".implode(',',$attributes).")VALUES(".implode(',',$params).")";
        $statement = self::prepare($SQL);

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attribute = array_keys($where);
        $sql = implode("AND ",array_map(fn($attr)=>"$attr = :$attr",$attribute));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key",$value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return App::$app->db->pdo->prepare($sql);
    }
}