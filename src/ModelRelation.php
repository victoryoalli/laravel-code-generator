<?php

namespace VictorYoalli\LaravelCodeGenerator;

use VictorYoalli\LaravelCodeGenerator\Structure\Model;

class ModelRelation
{
    public $type;
    public $model;
    public $local_key;
    public $foreign_key;
    public $name;

    public function __construct($name, $type, $model, $localKey = null, $foreignKey)
    {
        $model = app($model);
        $this->model = new Model($model,false);
        $this->type = $type;
        $this->local_key = $localKey;
        $this->foreign_key = $foreignKey;
        $this->name = $name;
    }

    public function getModel()
    {
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
        return ($this->_type === 'BelongsTo');
    }

    public function belongsToMany(){
        return ($this->_type === 'BelongsToMany');
    }


}