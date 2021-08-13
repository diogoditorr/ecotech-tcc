<?php

namespace Models;

class Imagem {
    public string $name;
    public string $type;
    public string $tmpNamePath;
    public string $extension;
    public string $nameFormated;

    public function __construct(array $image) {
        $this->name = $image['name'];
        $this->type = $image['type'];
        $this->tmpNamePath = $image['tmp_name'];
        
        $exploded = explode('.', $this->name);
        $this->extension = end($exploded);
        
        date_default_timezone_set("America/Sao_Paulo");
        $this->nameFormated = date("H-i-s")."_".date("d-m-Y")."_".$this->name;
    }
}