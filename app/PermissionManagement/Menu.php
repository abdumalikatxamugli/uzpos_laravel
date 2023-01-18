<?php
namespace App\PermissionManagement;

class Menu{
    public function render(){
        $menuStructures = config('menu.applicationMenu');
        $menuString = "";
        foreach($menuStructures as $menuStructure){
            $menuItem = new MenuItem();
            $menuString.=$menuItem->render($menuStructure);
        }
        return $menuString;
    }
}