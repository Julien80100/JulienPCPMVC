<?php

namespace Models;

class Competences extends \Spot\Entity
{
    protected static $table = 'Competences';

    public static function fields()
    {
      return [
        'id'           => ['type' => 'integer', 'primary'  => true, 'autoincrement' => true],
        'type'         => ['type' => 'string',  'required' => true],
        'Label'        => ['type' => 'string',  'required' => true],
        'ActivityID'   => ['type' => 'string',  'required' => false],
        'CompetenceID' => ['type' => 'string',  'required' => false],
        'epreuve'      => ['type' => 'string',  'required' => false],
      ];
    }
}