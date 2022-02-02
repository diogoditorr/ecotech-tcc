<?php declare(strict_types=1);

namespace App\Models;

use App\Models\BaseModel;

class Image extends BaseModel {
    public string $name;
    public string|null $nameFormatted;
    public string|null $type;
    public string|null $tmpNamePath;
    public string $extension;

    public function __construct(array $image) {
        $this->name = $image['name'];
        $this->type = $image['type'];
        $this->tmpNamePath = $image['tmp_name'];
        
        $exploded = explode('.', $this->name);
        $this->extension = end($exploded);
    }

    public function setNameFormatted()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $this->nameFormatted = date("H-i-s")."_".date("d-m-Y")."_".$this->name;
    }

    public static function createByName(string $name) 
    {
        return new Image(array(
            'name' => $name,
            'type' => null,
            'tmp_name' => null
        ));
    }
}