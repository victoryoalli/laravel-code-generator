<?php

namespace VictorYoalli\LaravelCodeGenerator;

use VictorYoalli\LaravelCodeGenerator\Structure\Model;

class ModelRelation
{
    private $_type;
    private $_model;
    public $local_key;
    public $foreign_key;
    public $name;

    public function __construct($name, $type, $model, $localKey = null, $foreignKey)
    {
        $this->_type = $type;
        $this->_model = $model;
        $this->local_key = $localKey;
        $this->foreign_key = $foreignKey;
        $this->name = $name;
    }

    public function getModel()
    {
        $model = app($this->_model);
        return new Model($model,false);
    }

    public function getModelNodeName()
    {
        return str_slug($this->_model);
    }

    public function getType()
    {
        return $this->_type;
    }

    public function hasOne(){
        return ($this->_type === 'HasOne');
    }

    public function hasMany(){
        return ($this->_type === 'HasMany');
    }

    public function belongsTo(){
        return ($this->_type === 'belongsTo');
    }

    public function belongsToMany(){
        return ($this->_type === 'belongsToMany');
    }


}