<?php

namespace Models;

class Imagem {
    public string $name;
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

    public function getNameFormatted()
    {
        date_default_timezone_set("America/Sao_Paulo");
        return date("H-i-s")."_".date("d-m-Y")."_".$this->name;
    }

    public static function createByName(string $name) 
    {
        return new Imagem(array(
            'name' => $name,
            'type' => null,
            'tmp_name' => null
        ));
    }
}