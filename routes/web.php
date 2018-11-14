<?php

/**
 * 后台路由
 */

/**后台模块**/
Route::group(['namespace' => 'Admin','prefix' => 'admin'], function (){

    Route::get('login','AdminsController@showLoginForm')->name('login');  //后台登陆页面

    Route::post('login-handle','AdminsController@loginHandle')->name('login-handle'); //后台登陆逻辑

    Route::get('logout','AdminsController@logout')->name('admin.logout'); //退出登录

    /**需要登录认证模块**/
    Route::middleware(['auth:admin','rbac'])->group(
        /**
         * @Title :
         * @User  : company_windows_locahost_wm
         * @Date  : 2018/11/6
         * @Time  : 15:05
         */
        function (){

        Route::resource('index', 'IndexsController', ['only' => ['index']]);  //首页

        Route::get('index/main', 'IndexsController@main')->name('index.main'); //首页数据分析

        Route::get('admins/status/{statis}/{admin}','AdminsController@status')->name('admins.status');

        Route::get('admins/delete/{admin}','AdminsController@delete')->name('admins.delete');

        Route::resource('admins','AdminsController',['only' => ['index', 'create', 'store', 'update', 'edit']]); //管理员

        Route::get('roles/access/{role}','RolesController@access')->name('roles.access');

        Route::post('roles/group-access/{role}','RolesController@groupAccess')->name('roles.group-access');

        Route::resource('roles','RolesController',['only'=>['index','create','store','update','edit','destroy'] ]);  //角色

        Route::get('rules/status/{status}/{rules}','RulesController@status')->name('rules.status');

        Route::resource('rules','RulesController',['only'=> ['index','create','store','update','edit','destroy'] ]);  //权限

        Route::resource('actions','ActionLogsController',['only'=> ['index','destroy'] ]);  //日志

            /**
             * 账单
             */
        Route::group(
            ['namespace' => 'Bank','prefix' => 'bank'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){
                Route::resource('lists','ListsController');
            }
        );
            /**
             * 用户
             */
        Route::group(
             ['namespace' => 'Users','prefix' => 'users'],
                /**
                 * @Title :
                 * @User  : company_windows_locahost_wm
                 * @Date  : 2018/11/6
                 * @Time  : 15:16
                 */
             function (){
                 Route::resource('/user','UsersController');
             }
        );
            /**
             * 设备
             */
        Route::group(
            ['namespace' => 'Equipment','prefix' => 'equipment'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){

                Route::resource('/equipment','EquipmentController');
            }
        );
            /**
             * 分组
             */
        Route::group(
            ['namespace' => 'Group','prefix' => 'group'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){

                Route::resource('/group','GroupController');
            }
        );
            /**
             * 停车
             */
        Route::group(
            ['namespace' => 'Parking','prefix' => 'parking'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){

                Route::resource('/parking','ParkingController');
                /**
                 * 停车设置
                 */
                Route::resource('/parksetup','ParkingSetUpController');

                Route::resource('/parking-lot','ParkingLotController');
            }
        );
            /**
             * 网点
             */
        Route::group(
            ['namespace' => 'Dot','prefix' => 'dot'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){

                Route::resource('/dot','DotController');
            }
        );
        Route::group(
            ['namespace' => 'Card','prefix' => 'card'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){

                Route::resource('/household','DoorCardController');
            }
        );
        Route::group(
            ['namespace' => 'Park','prefix' => 'park'],
            /**
             * @Title :
             * @User  : company_windows_locahost_wm
             * @Date  : 2018/11/6
             * @Time  : 15:16
             */
            function (){

                Route::resource('/park','ParkController');
            }
        );
    });
});
