@extends('layouts.app')

@section('content')
    <section class="mid-content   ">

        <div class="container">
            <div class="row">
                <div class="col-md-12"> <!-- bof  breadcrumb -->
                    <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
                        <a href="">My Account</a>&nbsp;<span class="separator">//</span>&nbsp;
                        Customer List
                    </div>
                    <gcse:searchresults></gcse:searchresults>
                    <div class="centerColumn" id="accountHistoryDefault">
                        <h1 id="accountHistoryDefaultHeading">Customer List</h1>
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
                                                    <li class="active"> <a href="{{ url('/customer-history') }}">Customer
                                                            List</a></li>
                                                </ul>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul id="account-menu" class="list chayyiyan">
                                <li class="account-history first-link active"> <a
                                        href="{{ url('/customer-history') }}">Customer
                                        List</a></li>
                            </ul>

                            <div class="clearBoth"></div>
                            <div class="customer_list_add_button text-center">
                                <a href="{{ url('customer') }}">
                                    <input class="btn btn-default add_customer" value="Add Customer">
                                </a>
                                 <a href="{{ url('manual-cheque-list/1') }}">
                                    <input class="btn btn-default add_customer mx-1" value="Order Cheque">
                                </a>
                            </div>
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
                                                <!-- <th class="order-date">First Name</th>
                                                <th class="order-number">Last Name</th>
                                                <th class="Email-id">Email ID</th> -->
                                                <th class="shipping-to">Company Info</th>
                                                <th class="total">Address</th>
                                                <th class="total">Telephone</th>
                                                <th class="status">City</th>
                                                <th class="status">State</th>
                                                <!-- <th class="status ">Country</th> -->
                                                <th class="status ">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                <tr>
                                                    <!-- <td class="order-date">{{ $customer->firstname }}</td>
                                                    <td class="order-number">{{ $customer->lastname }}</td>
                                                    <td class="shipping-to">{{ $customer->email }}</td> -->
                                                    <td class="quantity">{{ $customer->company }}</td>
                                                    <td class="total">{{ $customer->street_address }}</td>
                                                    <td class="status">{{ $customer->telephone }}</td>
                                                    <td class="status">{{ $customer->city }}</td>
                                                    <td class="status ">{{ $customer->state }}</td>
                                                    <!-- <td class="status ">{{ $customer->country }}</td> -->
                                                    <td class="actions">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('customer.edit', $customer->id) }}"
                                                            class="btn btn-lg">
                                                            <i class="bx bx-edit"></i>
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('customer.destroy', $customer->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-lg"
                                                                onclick="return confirm('Are you sure you want to delete this customer?')">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($customers->isEmpty())
                                <div class="centerColumn" id="noAcctHistoryDefault">
                                    You have not yet created Customer.</div>
                            @endif
                        </div>
                    </div><!-- top-inr-part -->
                </div>
            </div><!-- row -->
        </div><!-- container-->
    </section>
@endsection
