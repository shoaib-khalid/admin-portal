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
<link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
<script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
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
            <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-reporting" data-collapse-toggle="dropdown-reporting">
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Reporting</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>

            <ul id="dropdown-reporting" class="hidden py-2 space-y-2">

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

            </ul>

            <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-activitity" data-collapse-toggle="dropdown-activitity">
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Merchant Status</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            
            <ul id="dropdown-activitity" class="hidden py-2 space-y-2">
               <li class="{{ Request::routeIs('merchantappactivity') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ route('merchantappactivity') }}"><i class="fas fa-store"></i><span>Merchant App Activity</span></a>
               </li>
            </ul>

             <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-refund" data-collapse-toggle="dropdown-refund">
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Refund</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
           
            <ul id="dropdown-refund" class="hidden py-2 space-y-2">
               <li class="{{ Request::routeIs('pendingrefund') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ route('pendingrefund') }}"><i class="fas fa-credit-card"></i><span>Pending Refund</span></a>
               </li>

               <li class="{{ Request::routeIs('refundhistory') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ route('refundhistory') }}"><i class="fas fa-check-square"></i><span>Refund History</span></a>
               </li>
            </ul>

            <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-analytic" data-collapse-toggle="dropdown-analytic">
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Analytic</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            
            <ul id="dropdown-analytic" class="hidden py-2 space-y-2">
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
            </ul>

            <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-voucher" data-collapse-toggle="dropdown-voucher">
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Voucher</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            
            <ul id="dropdown-voucher" class="hidden py-2 space-y-2">
               <li class="{{ Request::routeIs('voucheradd') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ route('voucheradd') }}"><i class="fas fa-percent"></i><span>Create New Voucher</span></a>
               </li>
               <li class="{{ Request::routeIs('voucherlist') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ route('voucherlist') }}"><i class="fas fa-gift"></i><span>Available Voucher</span></a>
               </li>
            </ul>

            <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-config" data-collapse-toggle="dropdown-config">
                      <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                      <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Sys Config</span>
                      <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>

            <ul id="dropdown-config" class="hidden py-2 space-y-2">

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
            
        </ul>
    </aside>
</div>