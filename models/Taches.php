<?php

namespace Models;

class Competences extends \Spot\Entity
{
    protected static $table = 'Competences';

    public static function fields()
    {
      return [
        'id'           => ['type' => 'integer', 'primary'  => true, 'autoincrement' => true],
        'description'  => ['type' => 'string',  'required' => true],
        'date'        =>  ['type' => 'string',  'required' => true],
      ];
    }
}