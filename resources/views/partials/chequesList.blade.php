@extends('layouts.app')

@section('content')
    <section class="mid-content   ">

        <div class="container">
            <div class="row">
                <div class="col-md-12"> <!-- bof  breadcrumb -->
                    <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
                        <a href="{{ route('category.show', $category->slug) }}">{{ $chequeCategoryName }}</a>&nbsp;<span class="separator">//</span>&nbsp;
                        {{ $chequeSubCategoryName }}
                    </div>
                    <div class=" col-sm-12 col-md-12 one_section">
                        <gcse:searchresults></gcse:searchresults>
                        <div class="product-listing sub-page-wrapper" id="product-listing-9">
                            <div class="product-listing-header">
                                <h1 id="productListHeading">{{ $chequeSubCategoryName }}</h1>
                            </div>
                            <div class="back" id="middle-column-wrapper">
                                <div class="centerColumn" id="indexProductList">
                                    <div class="customaddprd">
                                        <div id="productListing" class="prdfr">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                id="catArrayTable" class="tabTable">
                                                <tbody>
                                                    <tr class="productListing-rowheading">
                                                        @foreach ($chequeList as $cheque)
                                                            <td>
                                                                <div class="prd_info">
                                                                    <div class="boxy"><a
                                                                            href="{{ url('order/' . $cheque->id) }}"><img
                                                                                src="{{ asset('assets/front/img/' . $cheque->img) }}"
                                                                                alt="{{ $cheque->chequeName }}"
                                                                                title=" {{ $cheque->chequeName }} "
                                                                                width="200" height="90"
                                                                                class="listingProductImage"></a>

                                                                        <h3 class="itemTitle tld"><a
                                                                                href="/chequeDetailsForm">{{ $cheque->chequeName }}</a>
                                                                        </h3>
                                                                        <div class="listingDescription"></div>

                                                                        <p class="prcAddCart crts">${{ $cheque->price }}</p>
                                                                    </div>
                                                                    <div class="orderButton"><a
                                                                            href="{{ url('order/' . $cheque->id) }}">Order
                                                                            Now</a></div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="tools-product-listing tools-bottom">
                                                <span class="quantity-products1">
                                                    <div class="links-pagination"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- add by gagan end dynamic category-->
                    </div><!-- top-inr-part -->
                </div>
            </div><!-- row -->
        </div><!-- container-->
    </section>
@endsection
