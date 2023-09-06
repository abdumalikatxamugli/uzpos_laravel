<?php
namespace App\PermissionManagement;

class MenuItem{
    public function render($structure){
        if(!in_array(auth()->user()->user_role, $structure['roles'] ) && !in_array("*", $structure['roles'] )){
            return "";
        }
        $children = "";
        $menuOpen = "";
        if(isset($structure['children'])){
            $children = '<ul class="my-nav-treeview">';
            foreach($structure['children'] as $childStructure){
                $childItem = new self();
                $children = $children . $childItem->render($childStructure);
                if($menuOpen == "" && isset($childStructure['route']) && isMenuOpen($childStructure['route'])){
                    $menuOpen = "menu-open";
                }
            }
            $children.='</ul>';
        }
        $href = "#";
        $active = "";
        if(isset($structure['route'])){
            $href = route($structure['route'], $structure['params']??[]);
            if(isActive($structure['route'], $structure['params']??[])){
                $active = "active";
            }
        }
        
        
        if(isset($structure['modal']) && $structure['modal'])
        {
            $anchor = <<<ANCHOR
                <a href="#" class="nav-link" data-href="{$href}" onclick='openModal(this)'>
                    <i class="material-icons">library_books</i>
                    <p> {$structure['title']}</p>
                </a>
            ANCHOR;
        }else{
            $anchor = <<<ANCHOR
                <a class="nav-link " href="{$href}">
                    <i class="material-icons">library_books</i>
                    <p> {$structure['title']}</p>
                </a>
            ANCHOR;
        }
        
        
        $item =  <<<ITEM
                <li class="nav-item {$active} {$menuOpen}">
                    $anchor
                    {$children}
                </li>  
        ITEM;
        return $item;
    }
}