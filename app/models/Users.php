<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
class Users extends Eloquent implements UserInterface {
	public $timestamps = true;
	public $table = 'users';
	public $includes = array('roles', 'rules');

	public function roles()
    {
        return $this->belongsToMany('Role', 'role_user');
    }

    public function rules() {
    	return $this->belongsToMany('Rule', 'rule_user');
    }

    public function has_rule($key) {
    	foreach($this->rules as $rule) {
    		if($rule->name == $key)
    			return true;
    	}
    	return false;
    }

    public function has_role($key) {
        foreach($this->roles as $role) {
            if($role->name == $key)
                return true;
        }
        return false;
    }

    public function hasAny_role($keys) {
        if( ! isArray($keys)) {
            $keys = func_getArgs();
        }

        foreach($this->roles as $role) {
            if(inArray($role->name, $keys)) {
                return true;
            }
        }
        return false;
    }

    public function getRoleList() {
    	$roleList = array();
		foreach($this->roles as $role) {
			array_push($roleList, $role->name);
		}
		return $roleList;
    }

    public function getRuleList() {
    	$ruleList = array();
		foreach($this->rules as $role) {
			array_push($ruleList, $role->name);
		}
		return $ruleList;
    }

    public function passwordTokens() {
    	return $this->hasOne('PasswordTokens', 'user_id');
    }

    public function getAuthPassword() {
    	return $this->password;
    }

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}
}
?>