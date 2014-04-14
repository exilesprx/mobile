<?php
class Rule extends Eloquent {

    public function users()
    {
        return $this->belongsToMany('Users');
    }

}