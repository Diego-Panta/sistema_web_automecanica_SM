<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Admin</b>ASM',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'buscar',
        ],
        [
            'text' => 'blog',
            'url' => 'admin/blog',
            'can' => 'manage-blog',
        ],
        // Todos (sera personalizado para cada rol)
        [
            'text' => 'Panel',
            'url' => 'admin/pages',
            'icon' => 'far fa-fw fa-file',
            'label' => 4,
            'label_color' => 'success',
        ],
        // Configuración de cuenta (común a todos)
        ['header' => 'MI CUENTA'],
        [
            'text' => 'Perfil',
            'url' => 'user/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'Cambiar contraseña',
            'url' => 'user/password',
            'icon' => 'fas fa-fw fa-lock',
        ],

        // Módulos específicos por rol
        ['header' => 'MÓDULOS PRINCIPALES'],

        // Leads - común pero con diferentes permisos
        [
            'text' => 'Gestión de Leads',
            'icon' => 'fas fa-fw fa-user-tag',
            'submenu' => [
                [
                    'text' => 'Mis Leads',
                    'url' => 'leads',
                    'icon' => 'fas fa-fw fa-list',
                    //'can' => ['asesor', 'jefe-ventas', 'marketing'],
                ],
                [
                    'text' => 'Nuevo Lead',
                    'url' => 'leads/create',
                    'icon' => 'fas fa-fw fa-plus-circle',
                    //'can' => ['marketing'],
                    'submenu' => [
                        [
                            'text' => 'Registro Manual',
                            'url' => 'leads/create/manual',
                            'icon' => 'fas fa-fw fa-keyboard',
                        ],
                        [
                            'text' => 'Importar Leads',
                            'url' => 'leads/import',
                            'icon' => 'fas fa-fw fa-file-import',
                        ],
                    ],
                ],
                [
                    'text' => 'Asignación de Leads',
                    'url' => 'leads/assign',
                    'icon' => 'fas fa-fw fa-users',
                    //'can' => ['jefe-ventas', 'marketing'],
                ],
                [
                    'text' => 'Configuración',
                    'url' => '#',
                    'icon' => 'fas fa-fw fa-cog',
                    //'can' => ['admin', 'marketing'],
                    'submenu' => [
                        [
                            'text' => 'Estados',
                            'url' => 'leads/status',
                            'icon' => 'fas fa-fw fa-tags',
                        ],
                        [
                            'text' => 'Tipos de Lead',
                            'url' => 'leads/types',
                            'icon' => 'fas fa-fw fa-filter',
                        ],
                        [
                            'text' => 'Canales',
                            'url' => 'leads/channels',
                            'icon' => 'fas fa-fw fa-road',
                        ],
                    ],
                ],
            ],
        ],

        // Actividades - para asesores
        [
            'text' => 'Mis Actividades',
            'icon' => 'fas fa-fw fa-tasks',
            //'can' => ['asesor'],
            'submenu' => [
                [
                    'text' => 'Leads Asignados',
                    'url' => 'my-leads',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Registrar Acción',
                    'url' => 'actions/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
                [
                    'text' => 'Historial',
                    'url' => 'my-history',
                    'icon' => 'fas fa-fw fa-history',
                ],
                [
                    'text' => 'Calendario',
                    'url' => 'calendar',
                    'icon' => 'fas fa-fw fa-calendar',
                ],
            ],
        ],

        // Reportes - para jefes
        [
            'text' => 'Reportes',
            'icon' => 'fas fa-fw fa-chart-bar',
            //'can' => ['jefe-ventas', 'marketing'],
            'submenu' => [
                [
                    'text' => 'Embudo de Ventas',
                    'url' => 'reports/funnel',
                    'icon' => 'fas fa-fw fa-filter',
                ],
                [
                    'text' => 'Desempeño Asesores',
                    'url' => 'reports/performance',
                    'icon' => 'fas fa-fw fa-user-graduate',
                ],
                [
                    'text' => 'Conversiones',
                    'url' => 'reports/conversions',
                    'icon' => 'fas fa-fw fa-exchange-alt',
                ],
                [
                    'text' => 'Tendencias',
                    'url' => 'reports/trends',
                    'icon' => 'fas fa-fw fa-chart-line',
                ],
            ],
        ],

        // Configuración - solo admin
        ['header' => 'ADMINISTRACIÓN'],//, 'can' => ['admin']],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users',
            //'can' => ['admin'],
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url' => 'users',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Nuevo Usuario',
                    'url' => 'users/create',
                    'icon' => 'fas fa-fw fa-user-plus',
                ],
                [
                    'text' => 'Roles y Permisos',
                    'url' => 'roles',
                    'icon' => 'fas fa-fw fa-user-shield',
                ],
                [
                    'text' => 'Configuración',
                    'url' => '#',
                    'icon' => 'fas fa-fw fa-cog',
                    //'can' => ['admin', 'marketing'],
                    'submenu' => [
                        [
                            'text' => 'Estados',
                            'url' => 'users/status',
                            'icon' => 'fas fa-fw fa-tags',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Configuración General',
            'icon' => 'fas fa-fw fa-cogs',
            //'can' => ['admin'],
            'submenu' => [
                [
                    'text' => 'Clientes',
                    'url' => 'clients',
                    'icon' => 'fas fa-fw fa-address-book',
                    'submenu' => [
                        [
                            'text' => 'Listado',
                            'url' => 'clients/list',
                            'icon' => 'fas fa-fw fa-list',
                        ],
                        [
                            'text' => 'Configuración',
                            'url' => '#',
                            'icon' => 'fas fa-fw fa-cog',
                            //'can' => ['admin', 'marketing'],
                            'submenu' => [
                                [
                                    'text' => 'Estados',
                                    'url' => 'clients/status',
                                    'icon' => 'fas fa-fw fa-tags',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Vehículos',
                    'url' => 'vehicles',
                    'icon' => 'fas fa-fw fa-car',
                    'submenu' => [
                        [
                            'text' => 'Modelos',
                            'url' => 'vehicles/models',
                            'icon' => 'fas fa-cogs',
                        ],
                        [
                            'text' => 'Marcas',
                            'url' => 'vehicles/brands',
                            'icon' => 'fas fa-car-side',
                        ],
                    ],
                ],
                [
                    'text' => 'Sedes y Turnos',
                    'url' => 'locations',
                    'icon' => 'fas fa-fw fa-map-marker-alt',
                    'submenu' => [
                        [
                            'text' => 'Sedes',
                            'url' => 'locations/sedes',
                            'icon' => 'fas fa-fw fa-building',
                            /*'submenu' => [
                                [
                                    'text' => 'Listado',
                                    'url' => 'locations/sedes',
                                ],
                                [
                                    'text' => 'Crear',
                                    'url' => 'locations/sedes/create',
                                ],
                            ],*/
                        ],
                        [
                            'text' => 'Turnos',
                            'url' => 'locations/turnos',
                            'icon' => 'fas fa-fw fa-clock',
                            /*'submenu' => [
                                [
                                    'text' => 'Listado',
                                    'url' => 'locations/turnos',
                                ],
                                [
                                    'text' => 'Crear',
                                    'url' => 'locations/turnos/create',
                                ],
                            ],*/
                        ],
                    ],
                ],
            ],
        ],
        /*[
            'text' => 'multilevel',
            'icon' => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url' => '#',
                ],
                [
                    'text' => 'level_one',
                    'url' => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url' => '#',
                        ],
                        [
                            'text' => 'level_two',
                            'url' => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url' => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url' => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url' => '#',
                ],
            ],
        ],*/
        /*['header' => 'labels'],
        [
            'text' => 'important',
            'icon_color' => 'red',
            'url' => '#',
        ],
        [
            'text' => 'warning',
            'icon_color' => 'yellow',
            'url' => '#',
        ],
        [
            'text' => 'information',
            'icon_color' => 'cyan',
            'url' => '#',
        ],

        ['header' => 'MODULOS'],
        [
            'text' => 'TURNOS',
            'icon' => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url' => '#',
                ],
                [
                    'text' => 'level_one',
                    'url' => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url' => '#',
                        ],
                        [
                            'text' => 'level_two',
                            'url' => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url' => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url' => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url' => '#',
                ],
            ],
        ],*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
