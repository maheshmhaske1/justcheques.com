@extends('layouts.app')

@section('content')
    <section class="mid-content   ">

        <div class="container">
            <div class="row">
                <div class="col-md-12"> <!-- bof  breadcrumb -->
                    <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
                        <a href="">My Account</a>&nbsp;<span class="separator">//</span>&nbsp;
                        Order History
                    </div>
                    <gcse:searchresults></gcse:searchresults>
                    <div class="centerColumn" id="accountHistoryDefault">
                        <h1 id="accountHistoryDefaultHeading">Order History</h1>
                        <div class="serch-order-num">
                            <div id="mobile-account-menu">
                                <div id="account-menu-header">
                                    <div class="account-menu-txt back">Account Menu</div>
                                    <div class="account-menu-icon forward"></div>
                                    <div class="clearBoth"></div>
                                </div>
                            </div>

                            <div id="mobile-accountt-menu">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne2">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOn2"
                                                aria-expanded="true" aria-controls="collapseOne" class="collapsed">
                                                <h4><span class="hamIcon"><i class="fa fa-bars"
                                                            aria-hidden="true"></i></span></h4>
                                            </a>
                                            <span data-toggle="collapse" data-target="#collapseOn2" class="textAcc">Account
                                                Menu</span>
                                        </h5>
                                    </div>

                                    <div id="collapseOn2" class="collapse collapseing" role="tabpanel"
                                        aria-labelledby="headingOne">
                                        <div class="card-block">
                                            <span>
                                                <ul>
                                                    <li class="active"> <a href="{{ url('/order-history') }}">Order
                                                            History</a></li>
                                                    <li class="active"> <a href="">Contact
                                                            Info</a></li>
                                                    <li class="active"> <a href="">Address
                                                            Book</a></li>
                                                    <li class="active"> <a href="">Communications</a>
                                                    </li>
                                                    <li class="active"> <a href="">Change
                                                            Password</a></li>
                                                </ul>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul id="account-menu" class="list chayyiyan">
                                <li class="account-history first-link active"> <a href="{{ url('/order-history') }}">Order
                                        History</a></li>
                            </ul>

                            <div class="clearBoth"></div>
                            {{-- <div class="serch-box ">
                                <form name="search_history" action="" method="post"><input type="hidden"
                                        name="securityToken" value="4d403e79f94e446a4a20bed069fd54dd">
                                    <input type="text" name="find_history" value="" placeholder="Quick Search">
                                    <input type="submit" value="Search">
                                </form>
                            </div> --}}
                        </div>
                        <div class="history-filters history-filters-top">

                            <div class="links-pagination"></div>
                            <!--EOF .pagination-->
                            <div class="navSplitPagesResult">
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                        <div class="clearBoth"></div>

                        <div class="order-history-wrapper histxt">
                            <div class="under_txt_ser">
                                <div class="table-responsive">
                                    <table class="table order-history-table test">
                                        <thead>
                                            <tr>
                                                <th class="order-date">Order Date</th>
                                                <th class="order-number">Order Number</th>
                                                <th class="shipping-to">Company Deatils</th>
                                                <th class="shipping-to">Product Deatils</th>
                                                <th class="total">Order Quantity</th>
                                                <th class="total">Order Cost</th>
                                                <th class="status">Order Status</th>
                                                <th class="status">Payment Status</th>
                                                <th class="status">Company Logo</th>
                                                <th class="status">Void Cheque</th>
                                                <th class="status ">Reorder</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($orders->isNotEmpty())
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td class="order-date">{{ $order->created_at }}</td>
                                                        <td class="order-number">{{ $order->id }}</td>
                                                        <td class="shipping-to">{{ $order->company_info }}</td>
                                                        <td class="shipping-to">
                                                            {{ $chequeData->chequeName }}<br>{{ $chequeData->manual_cheque_id != 0 ? 'Manual Cheque' : 'Laser Cheque' }}<br>{{ $chequeSubCategory }}
                                                        </td>
                                                        <td class="quantity">{{ $order->quantity }}</td>
                                                        <td class="total">${{ $totalPrices[$order->id] }}</td>
                                                        <td class="status">{{ $order->order_status }}</td>
                                                        <td class="status">{{ $order->balance_status }}</td>

                                                        <td class="status">
                                                            <div class="item"><a class="fancybox-buttons"
                                                                    data-fancybox-group="button" id="mainProductImage"
                                                                    rel="productImages"
                                                                    href="/storage/{{ $order->company_logo }}"
                                                                    target="blank"><img
                                                                        src="/storage/{{ $order->company_logo }}"
                                                                        alt="null" title="null" width="80"
                                                                        height="80"></a>
                                                            </div>
                                                        </td>
                                                        <td class="status">
                                                            <div class="item"><a class="fancybox-buttons"
                                                                    data-fancybox-group="button" id="mainProductImage"
                                                                    rel="productImages"
                                                                    href="/storage/{{ $order->voided_cheque_file }}"
                                                                    target="blank"><img
                                                                        src="/storage/{{ $order->voided_cheque_file }}"
                                                                        alt="null" title="null" width="80"
                                                                        height="80"></a>
                                                            </div>
                                                        </td>

                                                        <td class="reorder ">{{ $order->reorder }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($orders->isEmpty())
                                <div class="centerColumn" id="noAcctHistoryDefault">
                                    You have not yet made any purchases.
                                </div>
                            @endif
                        </div>
                    </div><!-- top-inr-part -->
                </div>
            </div><!-- row -->
        </div><!-- container-->
    </section>
@endsection
