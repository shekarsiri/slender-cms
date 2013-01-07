<?php

//use Enjoyit\Mongo\Model;

class Role extends extends Mongor\Model {

    public function Users()
    {
        return $this->has_and_belongs_to_many('User');
    }

}