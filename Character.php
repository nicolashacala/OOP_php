<?php
class Character{
    private $_id,
            $_damage,
            $_name,
            $_experience,
            $_level,
            $_expCap;
        

    const ME = 1;
    const CHARACTER_KILLED = 2;
    const CHARACTER_HIT = 3;

    public function hit(Character $charac){
        if($charac->id() == $this->_id){
            return self::ME;
        }
        return $charac->receiveDamages($this);
    }
    public function receiveDamages(Character $charac){
        $this->_damage += 5 * $charac->level();
        if($this->_damage >= 100){
            return self::CHARACTER_KILLED;
        }
        return self::CHARACTER_HIT;
    }
    public function earnExperience($experience, Character $charac){
        $this->_experience += $experience * $charac->level();
        if($this->_experience >= $this->_expCap){
            $this->_experience -= $this->_expCap;
            $this->_level += 1;
            $this->_expCap += $this->_level * 10;
        }
    }
    public function damage(){ return $this->_damage; }
    public function id(){ return $this->_id; }
    public function name(){ return $this->_name; }
    public function experience(){ return $this->_experience; }
    public function level(){ return $this->_level; }
    public function expCap(){ return $this->_expCap; }

    public function setDamage($damage){
        $damage = (int)$damage;
        if($damage>=0 && $damage <=100){
            $this->_damage = $damage;
        }
    }
    public function setId($id){
        $id = (int)$id;
        if($id>0){
            $this->_id = $id;
        }
    }
    public function setName($name){
        if (is_string($name)){
            $this->_name = $name;
        }
    }
    public function setLevel($level){
        $level = (int)$level;
        if($level>0){
            $this->_level = $level;
        }
    }
    public function setExpCap($expCap){
        $expCap = (int)$expCap;
        if($expCap>0){
            $this->_expCap = $expCap;
        }
    }
    public function setExperience($experience){
        $experience = (int)$experience;
        if($experience>=0 && $experience<100){
            $this->_experience = $experience;
        }
    }
    public function validName(){
        return !empty($this->_name);
    }
    public function hydrate(array $data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    public function __construct(array $data){
        if(!empty($data)){ $this->hydrate($data); }
    }
}