<?php declare(strict_types=1);

namespace App\Models;

class BaseModel
{
    private static function getObjectVarsRecursive($obj) {
        $arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($arr as $key => $val) {
            if (is_object($val) && \method_exists($val, 'toArray')) {
                $arr[$key] = $val->toArray();
            } elseif (is_array($val)) {
                $arr[$key] = self::getObjectVarsRecursive($val);
            } else {
                $arr[$key] = $val;
            }
        }
        return $arr;
    }

    public function toArray(): array
    {
        return static::getObjectVarsRecursive($this);
    }
}