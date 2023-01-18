<?php

/**
 * Application menu here
 */

use App\Models\RawMaterialIncomeHistory;
use App\Models\User;
use App\Models\Vozvrat;

/**
 * MENU structure
 * title @string
 * route @string
 * roles @integer-array
 * children @menu-array
 */
/**
 * ROLES
 */

return [
        'applicationMenu'=>[
            [
                'title'=>'Заказы',
                'roles'=>[User::ADMIN],
                'children'=>[
                    [
                        'title'=>'Розничный заказ',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.order.new',
                        'params'=>['type'=>2]             
                    ]
                    ,
                    [
                        'title'=>'Принятые Заказы',
                        'roles'=>[User::ADMIN],
                        'route'=> 'dashboard.orders.index',
                        'params'=>['status'=>1]
                    ]
                    ,
                    [
                        'title'=>'Завершенные Заказы',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.orders.index',
                        'params'=>['status'=>2]
                        
                    ]
                    ,
                    [
                        'title'=>'Отбр. Заказы',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.orders.index',
                        'params'=>['status'=>3]
                    ]
                    ,
                    [
                        'title'=>'Заказы от др.',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.orders.index',
                        'params'=>['status'=>2, 'other_shop'=>1]
                    ]
                ]
            ]
            ,
            [
                'title'=>'Клиенты',
                'roles'=>[User::ADMIN],
                'route'=>'dashboard.client.index',
            ]
            ,
            [
                'title'=>'Приход товаров',
                'roles'=>[User::ADMIN],
                'route'=>'dashboard.party.index',
            ]
            ,
            [
                'title'=>'Перемешения товаров',
                'roles'=>[User::ADMIN],
                'route'=>'dashboard.transfer.index',
            ]
            ,
            [
                'title'=>'Отчеты',
                'roles'=>[User::ADMIN],
                'route'=>'dashboard.reports.main',
            ]
            ,
            [
                'title'=>'Расходы',
                'roles'=>[User::ADMIN],
                'route'=>'dashboard.expense.index',
            ]
            ,
            [
                'title'=>'Справочники',
                'roles'=>[User::ADMIN],
                'children'=>[
                    [
                        'title'=>'Единицы измерение',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.metric.index',
                    ]
                    ,
                    [
                        'title'=>'Категории',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.category.index',
                    ]
                    ,
                    [
                        'title'=>'Бренды',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.brand.index',
                    ]
                    ,
                    [
                        'title'=>'Магазины и склады',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.point.index',
                    ]
                    ,
                    [
                        'title'=>'Продукты',
                        'roles'=>[User::ADMIN],
                        'route'=>'dashboard.product.index',
                    ]
                ]
            ]
            ,
            [
                'title'=>'Персонал',
                'roles'=>[User::ADMIN],
                'route'=>'dashboard.user.index',
            ]            
        ]
];