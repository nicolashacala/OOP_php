<?php
require_once('Manager.php');
class CharacterManager extends Manager{
    
    public function add(Character $charac){
        $q = $this->db->prepare('INSERT INTO characters_minifight(name) VALUES(:name)');
        $q->bindValue(':name', $charac->name());
        $q->execute();

        $charac->hydrate([
            'id' => $this->db->lastInsertId(),
            'damage' => 0,
            'experience' => 0,
            'level' => 1,
            'expCap' => 100,
        ]);
    }
    public function count(){
        return $this->db->query('SELECT COUNT(*) FROM characters_minifight')->fetchColumn();
    }
    public function delete(Character $charac){
        $this->db->exec('DELETE FROM characters_minifight WHERE id = ' .$charac->id());
    }
    public function exists($info){
        if(is_int($info)){
            return (bool) $this->db->query('SELECT COUNT(*) FROM characters_minifight WHERE id='.$info)->fetchColumn();
        }
        $q = $this->db->prepare('SELECT COUNT(*) FROM characters_minifight WHERE name= :name');
        $q->execute([':name' => $info]);

        return (bool) $q->fetchColumn();
    }
    public function get($info){
        if(is_int($info)){
            $q = $this->db->query('SELECT id, name, damage, experience, level, expCap FROM characters_minifight WHERE id=' .$info);
            $data = $q->fetch(PDO::FETCH_ASSOC);

            return new Character($data);
        }
        else{
            $q = $this->db->prepare('SELECT id, name, damage, experience, level, expCap FROM characters_minifight WHERE name= :name');
            $q->execute([':name'=>$info]);

            return new Character($q->fetch(PDO::FETCH_ASSOC));
        }
    }
    public function getList($name){
        $characterList = [];
        $q = $this->db->prepare('SELECT id, name, damage, experience, level, expCap FROM characters_minifight WHERE name<> :name ORDER BY name DESC');
        $q->execute([':name'=> $name]);
        while($data = $q->fetch(PDO::FETCH_ASSOC)){
            $characterList[] = new Character($data);
        }

        return $characterList;
    }
    public function update(Character $charac){
        $q = $this->db->prepare('UPDATE characters_minifight SET damage = :damage, experience = :experience, level = :level, expCap = :expCap WHERE id = :id');
        $q->bindValue(':damage', $charac->damage(), PDO::PARAM_INT);
        $q->bindValue(':experience', $charac->experience(), PDO::PARAM_INT);
        $q->bindValue(':level', $charac->level(), PDO::PARAM_INT);
        $q->bindValue(':expCap', $charac->expCap(), PDO::PARAM_INT);
        $q->bindValue(':id', $charac->id(), PDO::PARAM_INT);
        
        $q->execute();
    }
    
}