@extends('layouts.app')

@section('content')
    <section class="mid-content   ">

        <div class="container">
            <div class="row">
                <div class="col-md-12"> <!-- bof  breadcrumb -->
                    <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
                        {{ $chequeName }}
                    </div>
                    <div class=" col-sm-12 col-md-12 one_section">
                        <gcse:searchresults></gcse:searchresults>
                        <div class="product-listing sub-page-wrapper" id="product-listing-1">
                            <div class="product-listing-header">
                                <h1 id="productListHeading">{{ $chequeName }}</h1>
                            </div>
                            <div class="back" id="middle-column-wrapper">
                                <div class="centerColumn category-page" id="indexCategories">
                                    <div id="categoryDescription" class="catDescContent">
                                        <div class="content" id="indexProductListCatDescription">
                                            <h3>
                                            </h3>
                                            <h3>Customized {{ $chequeName }} have become a standard in Canada. All of our
                                                {{ $chequeName }} are CPA approved and comply with all the banking
                                                standards.
                                            </h3>
                                        </div>
                                    </div>
                                    <!-- BOF: Display grid of available sub-categories, if any -->
                                    <ul class="productsContainer">
                                        <div class="product-listing-main">
                                            @if ($chequeName == 'Laser Cheques')
                                                @foreach ($chequesCategory as $cheque)
                                                    <li class="productListing twoColOne threeColOne fourColOne back "><a
                                                            href="{{ url('laser-cheque-list/' . $cheque->id) }}"><img
                                                                src="{{ asset('assets/front/img/' . $cheque->img) }}"
                                                                alt="{{ $cheque->categoriesName }}"
                                                                title=" {{ $cheque->categoriesName }} " width="100"
                                                                height="80">
                                                            <br>{{ $cheque->categoriesName }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @elseif ($chequeName == 'Personal Cheques')
                                                @foreach ($chequesCategory as $cheque)
                                                    <li class="productListing twoColOne threeColOne fourColOne back "><a
                                                            href="{{ url('personal-cheque-list/' . $cheque->id) }}"><img
                                                                src="{{ asset('assets/front/img/' . $cheque->img) }}"
                                                                alt="{{ $cheque->categoriesName }}"
                                                                title=" {{ $cheque->categoriesName }} " width="100"
                                                                height="80">
                                                            <br>{{ $cheque->categoriesName }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </div>
                                    </ul><!-- EOF: Display grid of available sub-categories -->
                                    <hr>
                                    <p><strong>Easily Order {{ $chequeName }} Online</strong><br>
                                        Create personalized secure and stylish {{ $chequeName }} at JustCheque and save
                                        money with our custom cheques incredible prices at the same time. Pay your employees
                                        and vendors quickly and easily. Add your business logo free of charge and get the
                                        cheques delivered to any address in Canada quickly. Rush processing and delivery to
                                        most of Canada available.</p>

                                    <p>Just Cheque offers a selection of professional-looking <a href="">Laser
                                            cheques</a>, <a href="">Manual cheques</a>
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
                                        hundreds of online reviews from real customers and a 97% reorder rate, we’ve
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
