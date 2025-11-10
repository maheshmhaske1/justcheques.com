@extends('layouts.app')

@section('content')
    <section class="mid-content   ">

        <div class="container">
            <div class="row">
                <div class="col-md-12"> <!-- bof  breadcrumb -->
                    <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
                        {{ $category->name }}
                    </div>
                    <div class=" col-sm-12 col-md-12 one_section">
                        <gcse:searchresults></gcse:searchresults>
                        <div class="product-listing sub-page-wrapper" id="product-listing-1">
                            <div class="product-listing-header">
                                <h1 id="productListHeading">{{ $category->name }}</h1>
                            </div>
                            <div class="back" id="middle-column-wrapper">
                                <div class="centerColumn category-page" id="indexCategories">
                                    <div id="categoryDescription" class="catDescContent">
                                        <div class="content" id="indexProductListCatDescription">
                                            <h3>
                                            </h3>
                                            <h3>Customized {{ $category->name }} have become a standard in Canada. All of our
                                                {{ $category->name }} are CPA approved and comply with all the banking
                                                standards.
                                            </h3>
                                        </div>
                                    </div>
                                    <!-- BOF: Display grid of available sub-categories, if any -->
                                    <ul class="productsContainer">
                                        <div class="product-listing-main">
                                            @foreach ($subcategories as $subcategory)
                                                <li class="productListing twoColOne threeColOne fourColOne back ">
                                                    <a href="{{ url('make-order/' . $subcategory->id) }}">
                                                        @if($subcategory->image)
                                                            <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                                                alt="{{ $subcategory->name }}"
                                                                title=" {{ $subcategory->name }} "
                                                                width="100"
                                                                height="80">
                                                        @else
                                                            <img src="{{ asset('assets/front/img/default-cheque.jpg') }}"
                                                                alt="{{ $subcategory->name }}"
                                                                title=" {{ $subcategory->name }} "
                                                                width="100"
                                                                height="80">
                                                        @endif
                                                        <br>{{ $subcategory->name }}
                                                        @if($subcategory->lowest_price)
                                                            <br><span style="color: #093a7e; font-weight: bold;">Starting at ${{ number_format($subcategory->lowest_price, 2) }}</span>
                                                        @endif
                                                    </a>
                                                    <div style="margin-top: 15px !important;">
                                                        <a href="{{ url('make-order/' . $subcategory->id) }}"
                                                           class="btn btn-danger btn-sm"
                                                           style="padding: 5px 15px; font-size: 12px;">Order Now</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </div>
                                    </ul><!-- EOF: Display grid of available sub-categories -->
                                    <hr>
                                    <p><strong>Easily Order {{ $category->name }} Online</strong><br>
                                        Create personalized secure and stylish {{ $category->name }} at JustCheque and save
                                        money with our custom cheques incredible prices at the same time. Pay your employees
                                        and vendors quickly and easily. Add your business logo free of charge and get the
                                        cheques delivered to any address in Canada quickly. Rush processing and delivery to
                                        most of Canada available.</p>

                                    <p>Just Cheque offers a selection of professional-looking cheques
                                        and forms to choose from. Our laser cheques are compatible
                                        and guaranteed to work with your accounting software including <a
                                            href="">Peachtree</a>,
                                        <a href="">Quickbooks</a>, <a href="">Quicken</a>
                                        and more, our cheques are accepted at all Canadian bank institutions and credit
                                        unions.
                                    </p>

                                    <p><strong>Safe And Secure Business Cheques</strong><br>
                                        When ordering cheques online from Just Cheque, you are guaranteed the highest
                                        standards of quality cheques, including security and fraud-prevention features like
                                        chemically sensitive paper, watermarks, and other security features.</p>

                                    <p>Feel safe and secure when you order cheques online with JustCheque's secure checkout
                                        knowing that your business cheques will be ordered safely. With our Secure Socket
                                        Layer (SSL) encryption, your sensitive information will always be safe and protected
                                        and will never fall into the wrong hands.</p>

                                    <p>Our reputation precedes us as the top-rated cheque printer in all of Canada. With
                                        hundreds of online reviews from real customers and a 97% reorder rate, we've
                                        cemented ourselves as the premier source of custom printer cheques in Canada.</p>
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
