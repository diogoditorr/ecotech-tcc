<?php declare(strict_types=1);

namespace App\Models;

class BaseModel
{
    private static array $defaultAttributes = ['hidden'];
    protected array $hidden = [];

    private static function getObjectVarsRecursive(object|array $obj) {
        $arr = is_object($obj) ? get_object_vars($obj) : $obj;
        $newArray = [];
        foreach ($arr as $key => $val) {
            if (\in_array($key, self::$defaultAttributes))
                continue;

            if (is_object($val) && \method_exists($val, 'toArray'))
                $newArray[$key] = $val->toArray();
                
            elseif (is_array($val))
                $newArray[$key] = self::getObjectVarsRecursive($val);

            elseif(!\in_array($key, $obj->hidden))
                $newArray[$key] = $val;
        }
        return $newArray;
    }

    public function makeHidden(array $attributes)
    {
        $this->hidden = [...$this->hidden, ...$attributes];
        return $this;
    }

    public function toArray(): array
    {
        return static::getObjectVarsRecursive($this);
    }
}