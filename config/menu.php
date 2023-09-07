<?php

/**
 * Application menu here
 */

use App\Models\User;

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
                'roles'=>[User::ADMIN, User::SELLER, User::WAREHOUSE_MANAGER],
                'children'=>[
                    [
                        'title'=>'Розничный заказ',
                        'roles'=>[User::ADMIN, User::SELLER],
                        'route'=>'dashboard.order.new',
                        'params'=>['type'=>"2"],
                        'modal'=>true
                    ]
                    ,
                    [
                        'title'=>'Принятые Заказы',
                        'roles'=>[User::ADMIN, User::SELLER],
                        'route'=> 'dashboard.orders.index',
                        'params'=>['status'=>"1"]
                    ]
                    ,
                    [
                        'title'=>'Завершенные Заказы',
                        'roles'=>[User::ADMIN, User::SELLER],
                        'route'=>'dashboard.orders.index',
                        'params'=>['status'=>"2"]
                        
                    ]
                    // ,
                    // [
                    //     'title'=>'Отбр. Заказы',
                    //     'roles'=>[User::ADMIN],
                    //     'route'=>'dashboard.orders.index',
                    //     'params'=>['status'=>"3"]
                    // ]
                    ,
                    // [
                    //     'title'=>'Новый заказы от др.',
                    //     'roles'=>[User::ADMIN],
                    //     'route'=>'dashboard.orders.index',
                    //     'params'=>['status'=>"1", 'other_shop'=>1]
                    // ]
                    // ,
                    // [
                    //     'title'=>'Зав. заказы от др.',
                    //     'roles'=>[User::ADMIN],
                    //     'route'=>'dashboard.orders.index',
                    //     'params'=>['status'=>"2", 'other_shop'=>1]
                    // ]
                ]
            ]
            ,
            [
                'title'=>'Клиенты',
                'roles'=>[User::ADMIN, User::SELLER],
                'route'=>'dashboard.client.index',
            ]
            ,
            [
                'title'=>'Приход товаров',
                'roles'=>[User::ADMIN, User::WAREHOUSE_MANAGER],
                'route'=>'dashboard.party.index',
            ]
            ,
            [
                'title'=>'Перемешения товаров',
                'roles'=>[User::ADMIN, User::SELLER, User::WAREHOUSE_MANAGER],
                'route'=>'dashboard.transfer.index',
            ]
            ,
            [
                'title'=>'Запросы на перемешения',
                'roles'=>[User::ADMIN],
                'route'=>'transfer.request.get',
            ]            
            ,
            [
                'title'=>'Отчеты',
                'roles'=>[User::ADMIN, User::SELLER, User::WAREHOUSE_MANAGER],
                'route'=>'dashboard.reports.main',
            ]
            ,
            [
                'title'=>'Расходы',
                'roles'=>[User::ADMIN, User::SELLER],
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