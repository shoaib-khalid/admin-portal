@php
$links = [
    [
        "href" => "dashboard",
        "text" => "Dashboard",
        "is_multi" => false,
    ],
    [
        "href" => [
            [
                "section_text" => "User",
                "section_list" => [
                    ["href" => "user", "text" => "Data User"],
                    ["href" => "user.new", "text" => "Buat User"]
                ]
            ]
        ],
        "text" => "User",
        "is_multi" => true,
    ],
];
$navigation_links = array_to_object($links);

@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="./img/symbol.png" alt="">
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-header">Reporting</li>
            
            <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-hand-holding-usd"></i><span>Sales Summary</span></a>
            </li>

            <li class="{{ Request::routeIs('detail') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('detail') }}"><i class="fas fa-search-dollar"></i><span>Daily Detail Sales</span></a>
            </li>

            <li class="{{ Request::routeIs('settlement') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('settlement') }}"><i class="fas fa-file-invoice-dollar"></i><span>Settlement</span></a>
            </li>

            <li class="{{ Request::routeIs('merchant') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('merchant') }}"><i class="fas fa-store"></i><span>Merchant</span></a>
            </li>
            
        </ul>
    </aside>
</div>
