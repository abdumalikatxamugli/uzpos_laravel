<?php
namespace App\PermissionManagement;

class MenuItem{
    public function render($structure){
        if(!in_array(auth()->user()->role_id, $structure['roles'] ) && !in_array("*", $structure['roles'] )){
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
        if(isset($structure['children'])){
            $icon = "far fa-plus-square";
        }else{
            $icon = "fas fa-th";
        }
        
        
        $item =  <<<ITEM
                <li class="nav-item">
                    <a class="nav-link {$active}" href="{$href}">
                        <i class="material-icons">library_books</i>
                        <p> {$structure['title']}</p>
                    </a>
                    {$children}
                </li>  
        ITEM;
        return $item;
    }
}