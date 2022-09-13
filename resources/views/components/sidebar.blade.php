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

            <!--
            <li class="{{ Request::routeIs('detail') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('detail') }}"><i class="fas fa-search-dollar"></i><span>Daily Detail Sales (Individual)</span></a>
            </li>
            !-->
            
            <li class="{{ Request::routeIs('groupsales') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('groupsales') }}"><i class="fas fa-search-dollar"></i><span>Daily Detail Sales</span></a>
            </li>

            <li class="{{ Request::routeIs('voucherredemption') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('voucherredemption') }}"><i class="fas fa-search-dollar"></i><span>Voucher Redemption</span></a>
            </li>
<!--
            <li class="{{ Request::routeIs('settlement') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('settlement') }}"><i class="fas fa-file-invoice-dollar"></i><span>Settlement</span></a>
            </li>
!-->
             <li class="{{ Request::routeIs('settlement2') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('settlement2') }}"><i class="fas fa-file-invoice-dollar"></i><span>Settlement</span></a>
            </li>

            <li class="{{ Request::routeIs('merchant') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('merchant') }}"><i class="fas fa-store"></i><span>Merchant</span></a>
            </li>

            <li class="menu-header">Merchant Status</li>

            <li class="{{ Request::routeIs('merchantappactivity') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('merchantappactivity') }}"><i class="fas fa-store"></i><span>Merchant App Activity</span></a>
            </li>

            <li class="menu-header">Refund</li>

            <li class="{{ Request::routeIs('pendingrefund') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pendingrefund') }}"><i class="fas fa-credit-card"></i><span>Pending Refund</span></a>
            </li>

            <li class="{{ Request::routeIs('refundhistory') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('refundhistory') }}"><i class="fas fa-check-square"></i><span>Refund History</span></a>
            </li>

            <li class="menu-header">Analytic</li>

            <li class="{{ Request::routeIs('useractivitylog') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('useractivitylog') }}"><i class="fas fa-users"></i><span>Customer Activity Log</span></a>
            </li>
            <li class="{{ Request::routeIs('userdata') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userdata') }}"><i class="fas fa-user"></i><span>Customer Data</span></a>
            </li>
            <li class="{{ Request::routeIs('usersitemap') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('usersitemap') }}"><i class="fas fa-sitemap"></i><span>Customer Site Map</span></a>
            </li>
            <li class="{{ Request::routeIs('visitchannel') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('visitchannel') }}"><i class="fas fa-mouse-pointer"></i><span>Customer Visits Channel</span></a>
            </li>
            <li class="{{ Request::routeIs('useractivitysummary') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('useractivitysummary') }}"><i class="fas fa-calculator"></i><span>Customer Summary</span></a>
            </li>
            <li class="{{ Request::routeIs('useractivitysummarydate') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('useractivitysummarydate') }}"><i class="fas fa-calculator"></i><span>Customer Summary By Date</span></a>
            </li>
            <li class="{{ Request::routeIs('userabandoncartsummary') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userabandoncartsummary') }}"><i class="fas fa-cart-arrow-down"></i><span>Abandon Cart</span></a>
            </li>
            <li class="{{ Request::routeIs('userincompleteorder') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userincompleteorder') }}"><i class="fas fa-exclamation-circle"></i><span>Incomplete Order</span></a>
            </li>

            <li class="menu-header">Voucher</li>

            <li class="{{ Request::routeIs('voucheradd') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('voucheradd') }}"><i class="fas fa-percent"></i><span>Create New Voucher</span></a>
            </li>
            <li class="{{ Request::routeIs('voucherlist') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('voucherlist') }}"><i class="fas fa-gift"></i><span>Available Voucher</span></a>
            </li>

           <li class="menu-header">Sys Config</li>

            <li class="{{ Request::routeIs('promotext') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('promotext') }}"><i class="fas fa-bullhorn"></i><span>Promo Text</span></a>
            </li>
            <li class="{{ Request::routeIs('featuredstore') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('featuredstore') }}"><i class="fas fa-bullhorn"></i><span>Featured Store</span></a>
            </li>
            <li class="{{ Request::routeIs('featuredproduct') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('featuredproduct') }}"><i class="fas fa-bullhorn"></i><span>Featured Product</span></a>
            </li>
           
           <!--
            <li class="{{ Request::routeIs('featuredlocation') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('featuredlocation') }}"><i class="fas fa-bullhorn"></i><span>Featured Location</span></a>
            </li>!-->

            <li class="{{ Request::routeIs('parentcategory') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('parentcategory') }}"><i class="fas fa-bullhorn"></i><span>Parent Category</span></a>
            </li>
            <li class="{{ Request::routeIs('featuredcategory') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('featuredcategory') }}"><i class="fas fa-bullhorn"></i><span>Category Sequence</span></a>
            </li>
            <li class="{{ Request::routeIs('citylocation') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('citylocation') }}"><i class="fas fa-bullhorn"></i><span>Locations</span></a>
            </li>
            <li class="{{ Request::routeIs('cityregion') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cityregion') }}"><i class="fas fa-bullhorn"></i><span>City Region</span></a>
            </li>
           
            <li class="{{ Request::routeIs('marketbanner') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('marketbanner') }}"><i class="fas fa-bullhorn"></i><span>Marketplace Banner</span></a>
            </li>
            
            <li class="{{ Request::routeIs('marketpopup') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('marketpopup') }}"><i class="fas fa-bullhorn"></i><span>Marketplace Popup</span></a>
            </li>
            
        </ul>
    </aside>
</div>
