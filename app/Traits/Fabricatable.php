<?php
namespace App\Traits;

trait Fabricatable{
    public static function createFromArray($data){
        $object = new self();
        foreach($data as $attr=>$value){
            $object->$attr = $value;
        }
        $object->save();
        return $object;
    }
    public static function updateFromArray($data, $id){
        $object = self::findOrFail($id);
        foreach($data as $attr=>$value){
            $object->$attr = $value;
        }
        $object->save();
        return $object;
    }
    public static function createFromArrayWithUser($data, $user){
        $object = new self();
        foreach($data as $attr=>$value){
            $object->$attr = $value;
        }
        $object->created_by_id = $user->id;
        $object->save();
        return $object;
    }
    public static function updateFromArrayWithUser($data, $id, $user){
        $object = self::findOrFail($id);
        foreach($data as $attr=>$value){
            $object->$attr = $value;
        }
        $object->created_by_id = $user->id;
        $object->save();
        return $object;
    }
}
