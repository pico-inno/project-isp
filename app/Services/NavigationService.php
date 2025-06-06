<?php

namespace App\Services;

class NavigationService
{
    protected array $mainItems = [
        [
            'key' => 'dashboard',
            'title' => 'Dashboard',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" /><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" /></svg>'
        ],
        [
            'key' => 'user',
            'title' => 'User',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" /></svg>'
        ],
        [
            'key' => 'router',
            'title' => 'Router',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="size-5" id="router"><path d="M11.45 5.55c.19.19.5.21.72.04C13.3 4.69 14.65 4.2 16 4.2s2.7.49 3.84 1.39c.21.17.52.15.72-.04l.04-.05c.22-.22.21-.59-.03-.8C19.24 3.57 17.62 3 16 3s-3.24.57-4.57 1.7c-.24.21-.26.57-.03.8l.05.05zm1.7.76c-.25.2-.26.58-.04.8l.04.04c.2.2.5.2.72.04.63-.48 1.38-.69 2.13-.69s1.5.21 2.13.68c.22.17.53.16.72-.04l.04-.04c.23-.23.21-.6-.04-.8-.83-.64-1.84-1-2.85-1s-2.02.36-2.85 1.01zM19 13h-2v-3c0-.55-.45-1-1-1s-1 .45-1 1v3H5c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2zM8 18H6v-2h2v2zm3.5 0h-2v-2h2v2zm3.5 0h-2v-2h2v2z"></path></svg>'
        ],
        [
            'key' => 'info',
            'title' => 'Info',
            'icon' => '<i class="fa-solid fa-circle-info"></i>',
            'route' => 'about'
        ]
    ];

    protected array $contentSections = [
        'dashboard' => [
            'title' => 'Home',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'routePattern' => 'dashboard'
                ]
            ]
        ],
        'user' => [
            'title' => 'User Management',
            'items' => [
                [
                    'label' => 'Users',
                    'route' => 'users.index',
                    'routePattern' => 'users.*'
                ],
                [
                    'label' => 'Roles & Permissions',
                    'route' => 'role-permissions.index',
                    'routePattern' => 'role-permissions.*'
                ]
            ]
        ],
        'router' => [
            'title' => 'Router Management',
            'items' => function() {
                if (!request()->routeIs('routers.dashboard') && !request()->routeIs('radius.index') && !request()->routeIs('radacct.index')) {
                    return [
                        [
                            'label' => 'Routers',
                            'route' => 'routers.index',
                            'routePattern' => 'routers.index'
                        ]
                    ];
                }

                return [
                    [
                        'label' => 'Dashboard',
                        'route' => ['routers.dashboard', ['router' => request()->route('router')]],
                        'routePattern' => 'routers.dashboard'
                    ],
                    [
                        'label' => 'Radius',
                        'route' => ['radius.index', ['router' => request()->route('router')]],
                        'routePattern' => 'radius.index'
                    ],
                    [
                        'label' => 'User Account',
                        'route' => ['radacct.index', ['router' => request()->route('router')]],
                        'routePattern' => 'radacct.index'
                    ],
                    [
                        'label' => 'Back Router List',
                        'route' => 'routers.index',
                        'routePattern' => 'routers.index'
                    ]
                ];
            }
        ],
        'info' => [
            'title' => 'Information',
            'items' => [
                [
                    'label' => 'About',
                    'route' => 'about',
                    'routePattern' => 'about'
                ]
            ]
        ]
    ];

    public function getMainItems(): array
    {
        return $this->mainItems;
    }

    public function getContentSections(): array
    {
        $sections = [];

        foreach ($this->contentSections as $key => $section) {
            $sections[$key] = [
                'key' => $key,
                'title' => $section['title'],
                'items' => is_callable($section['items']) ? call_user_func($section['items']) : $section['items']
            ];
        }

        return $sections;
    }

    public function isActive(string $routePattern): bool
    {
        return request()->routeIs($routePattern);
    }

    public function setContentSections(array $contentSections): NavigationService
    {
        $this->contentSections = $contentSections;
        return $this;
    }
}
