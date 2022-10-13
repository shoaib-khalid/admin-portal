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
        
        <ul class="list-unstyled components">           

            <li class="menu-header p-2">
                <a href="#subMenuReport" id="tabreport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-gray-400">Reporting</a>
            </li>
            
            <ul class="collapse list-unstyled" id="subMenuReport">

                <li class="">
                    <a class="nav-link {{ Request::routeIs('dashboard') ? '' : 'text-gray-400' }}" href="{{ route('dashboard') }}"><i class="fas fa-hand-holding-usd pr-3"></i><span>Sales Summary</span></a>
                </li>

                <!--
                <li class="{{ Request::routeIs('detail') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('detail') }}"><i class="fas fa-search-dollar"></i><span>Daily Detail Sales (Individual)</span></a>
                </li>
                !-->
                
                <li class="">
                    <a class="nav-link {{ Request::routeIs('groupsales') ? '' : 'text-gray-400' }}" href="{{ route('groupsales') }}"><i class="fas fa-search-dollar pr-3"></i><span>Daily Detail Sales</span></a>
                </li>

                <li class="">
                    <a class="nav-link {{ Request::routeIs('voucherredemption') ? '' : 'text-gray-400' }}" href="{{ route('voucherredemption') }}"><i class="fas fa-search-dollar pr-3"></i><span>Voucher Redemption</span></a>
                </li>
    <!--
                <li class="{{ Request::routeIs('settlement') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('settlement') }}"><i class="fas fa-file-invoice-dollar"></i><span>Settlement</span></a>
                </li>
    !-->
                 <li class="">
                    <a class="nav-link {{ Request::routeIs('settlement2') ? '' : 'text-gray-400' }}" href="{{ route('settlement2') }}"><i class="fas fa-file-invoice-dollar pr-3"></i><span>Settlement</span></a>
                </li>

                <li class="">
                    <a class="nav-link {{ Request::routeIs('merchant') ? '' : 'text-gray-400' }}" href="{{ route('merchant') }}"><i class="fas fa-store pr-3"></i><span>Merchant</span></a>
                </li>

            </ul>


            <li class="menu-header p-2" >
                <a id="tabmerchant" href="#subMenuMerchantStatus" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-gray-400">Merchant Status</a>
            </li>

            <ul class="collapse list-unstyled" id="subMenuMerchantStatus">

                <li class="">
                    <a class="nav-link {{ Request::routeIs('merchantappactivity') ? '' : 'text-gray-400' }}" href="{{ route('merchantappactivity') }}"><i class="fas fa-store pr-3"></i><span>Merchant App Activity</span></a>
                </li>
            </ul>

           
            <li class="menu-header p-2" >
                <a id="tabrefund" href="#subMenuRefund" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-gray-400">Refund</a>
            </li>

            <ul class="collapse list-unstyled" id="subMenuRefund">
                <li class="{">
                    <a class="nav-link {{ Request::routeIs('pendingrefund') ? '' : 'text-gray-400' }}" href="{{ route('pendingrefund') }}"><i class="fas fa-credit-card pr-3"></i><span>Pending Refund</span></a>
                </li>

                <li class="">
                    <a class="nav-link {{ Request::routeIs('refundhistory') ? '' : 'text-gray-400' }}" href="{{ route('refundhistory') }}"><i class="fas fa-check-square pr-3"></i><span>Refund History</span></a>
                </li>
            </ul>


            <li class="menu-header p-2" >
                <a id="tabanalytic" href="#subMenuAnalytic" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-gray-400">Analytic</a>
            </li>

            <ul class="collapse list-unstyled" id="subMenuAnalytic">

                <li class="">
                    <a class="nav-link {{ Request::routeIs('useractivitylog') ? '' : 'text-gray-400' }}" href="{{ route('useractivitylog') }}"><i class="fas fa-users pr-3"></i><span>Customer Activity Log</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('userdata') ? '' : 'text-gray-400' }}" href="{{ route('userdata') }}"><i class="fas fa-user pr-3"></i><span>Customer Data</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('usersitemap') ? '' : 'text-gray-400' }}" href="{{ route('usersitemap') }}"><i class="fas fa-sitemap pr-3"></i><span>Customer Site Map</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('visitchannel') ? '' : 'text-gray-400' }}" href="{{ route('visitchannel') }}"><i class="fas fa-mouse-pointer pr-3"></i><span>Customer Visits Channel</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('useractivitysummary') ? '' : 'text-gray-400' }}" href="{{ route('useractivitysummary') }}"><i class="fas fa-calculator pr-3"></i><span>Customer Summary</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('useractivitysummarydate') ? '' : 'text-gray-400' }}" href="{{ route('useractivitysummarydate') }}"><i class="fas fa-calculator pr-3"></i><span>Customer Summary By Date</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('userabandoncartsummary') ? '' : 'text-gray-400' }}" href="{{ route('userabandoncartsummary') }}"><i class="fas fa-cart-arrow-down pr-3"></i><span>Abandon Cart</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('userincompleteorder') ? '' : 'text-gray-400' }}" href="{{ route('userincompleteorder') }}"><i class="fas fa-exclamation-circle pr-3"></i><span>Incomplete Order</span></a>
                </li>

            </ul>


            <li class="menu-header p-2" >
                <a id="tabvoucher" href="#subMenuVoucher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-gray-400">Voucher</a>
            </li>

            <ul class="collapse list-unstyled" id="subMenuVoucher">

                <li class="">
                    <a class="nav-link {{ Request::routeIs('voucheradd') ? '' : 'text-gray-400' }}" href="{{ route('voucheradd') }}"><i class="fas fa-percent pr-3"></i><span>Create New Voucher</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('voucherlist') ? '' : 'text-gray-400' }}" href="{{ route('voucherlist') }}"><i class="fas fa-gift pr-3"></i><span>Available Voucher</span></a>
                </li>

            </ul>

          
           <li class="menu-header p-2" >
                <a id="tabconfig" href="#subMenuConfig" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-gray-400">System Configuration</a>
            </li>

                <ul class="collapse list-unstyled" id="subMenuConfig">

                <li class="">
                    <a class="nav-link {{ Request::routeIs('promotext') ? '' : 'text-gray-400' }}" href="{{ route('promotext') }}"><i class="fas fa-bullhorn pr-3"></i><span>Promo Text</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('featuredstore') ? '' : 'text-gray-400' }}" href="{{ route('featuredstore') }}"><i class="fas fa-bullhorn pr-3"></i><span>Featured Store</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('featuredproduct') ? '' : 'text-gray-400' }}" href="{{ route('featuredproduct') }}"><i class="fas fa-bullhorn pr-3"></i><span>Featured Product</span></a>
                </li>
           
               <!--
                <li class="{{ Request::routeIs('featuredlocation') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('featuredlocation') }}"><i class="fas fa-bullhorn"></i><span>Featured Location</span></a>
                </li>!-->

                <li class="">
                    <a class="nav-link {{ Request::routeIs('parentcategory') ? '' : 'text-gray-400' }}" href="{{ route('parentcategory') }}"><i class="fas fa-bullhorn pr-3"></i><span>Parent Category</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('featuredcategory') ? '' : 'text-gray-400' }}" href="{{ route('featuredcategory') }}"><i class="fas fa-bullhorn pr-3"></i><span>Category Sequence</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('citylocation') ? '' : 'text-gray-400' }}" href="{{ route('citylocation') }}"><i class="fas fa-bullhorn pr-3"></i><span>Locations</span></a>
                </li>
                <li class="">
                    <a class="nav-link {{ Request::routeIs('cityregion') ? '' : 'text-gray-400' }}" href="{{ route('cityregion') }}"><i class="fas fa-bullhorn pr-3"></i><span>City Region</span></a>
                </li>
               
                <li class="">
                    <a class="nav-link {{ Request::routeIs('marketbanner') ? '' : 'text-gray-400' }}" href="{{ route('marketbanner') }}"><i class="fas fa-bullhorn pr-3"></i><span>Marketplace Banner</span></a>
                </li>
                
                <li class="">
                    <a class="nav-link {{ Request::routeIs('marketpopup') ? '' : 'text-gray-400' }}" href="{{ route('marketpopup') }}"><i class="fas fa-bullhorn pr-3"></i><span>Marketplace Popup</span></a>
                </li>

            </ul>
            
        </ul>
    </aside>
</div>

<script type="text/javascript">
    var tabid1 = "{{ (Request::routeIs('dashboard') || Request::routeIs('groupsales') || Request::routeIs('voucherredemption') || Request::routeIs('settlement2') || Request::routeIs('merchant')) ? 'tabreport' : '' }}";    
    if (tabid1) {
        openTab(tabid1);
    }

    var tabid2 = "{{ Request::routeIs('merchantappactivity') ? 'tabmerchant' : '' }}";
    if (tabid2) {
        openTab(tabid2);
    }

    var tabid3 = "{{ (Request::routeIs('pendingrefund') || Request::routeIs('refundhistory')) ? 'tabrefund' : '' }}";
    if (tabid3) {
        openTab(tabid3);
    }

    var tabid4 = "{{ (Request::routeIs('useractivitylog') || Request::routeIs('userdata') || Request::routeIs('usersitemap') || Request::routeIs('visitchannel') || Request::routeIs('useractivitysummary') || Request::routeIs('userabandoncartsummary') || Request::routeIs('userincompleteorder')) ? 'tabanalytic' : '' }}";
    if (tabid4) {
        openTab(tabid4);
    }

    var tabid5 = "{{ (Request::routeIs('voucheradd') || Request::routeIs('voucherlist')) ? 'tabvoucher' : '' }}";
    if (tabid5) {
        openTab(tabid5);
    }

    var tabid6 = "{{ (Request::routeIs('promotext') || Request::routeIs('featuredstore') || Request::routeIs('featuredproduct') || Request::routeIs('parentcategory') || Request::routeIs('featuredcategory') || Request::routeIs('citylocation') || Request::routeIs('cityregion') || Request::routeIs('marketbanner') || Request::routeIs('marketpopup')) ? 'tabconfig' : '' }}";
    if (tabid6) {
        openTab(tabid6);
    }

    function openTab(tabid) {        
        window.addEventListener('DOMContentLoaded', () => {
        document.getElementById(tabid).click()
        });     
    }
  
</script>