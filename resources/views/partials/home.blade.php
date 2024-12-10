@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="holder nopadding">
                <div class="container">
                    <div class="mainbody row  " id="mainbodystretch">
                        <div class="maincontent col-xs-12">
                            <!--BEGIN #primary .hfeed-->
                            <div id="primary" class="hfeed">
                                <!--BEGIN .hentry-->
                                <div id="post-51162"
                                    class="post-51162 page type-page status-publish hentry p publish first-page author-jon-gilchrist untagged y2017 m05 d26 h10">
                                    <!--BEGIN .entry-content .article-->
                                    <div class="entry-content article">
                                        <div class="wpb-content-wrapper">
                                            <div data-vc-full-width="true" data-vc-full-width-init="true"
                                                data-vc-stretch-content="true"
                                                class="vc_row wpb_row vc_row-fluid vc_custom_1659978310186 vc_row-has-fill">
                                                <div
                                                    class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-2/5 vc_col-md-2/5">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div
                                                                class="wpb_text_column wpb_content_element text-center home-banner-callout">
                                                                <div class="wpb_wrapper">
                                                                    <h1 style="font-size: 30px; margin-bottom: 20px">Order
                                                                        Bank Cheques</h1>
                                                                    <h2 style="font-size: 18px">Business or Personal Bank
                                                                        Cheques.<br>
                                                                        Order Online in under 5 minutes.<br>
                                                                        Next-Day Delivery Options.</h2>
                                                                    <p><a class="banner-btn"
                                                                            href="{{ url('manual-cheque-list/' . 1) }}">Manual
                                                                            Cheques</a> <a class="banner-btn"
                                                                            href="{{ url('laser-cheque') }}">Laser
                                                                            Cheques</a>
                                                                        <a class="banner-btn"
                                                                            href="{{ url('personal-cheque') }}">Personal
                                                                            Cheques</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="wpb_column vc_column_container vc_col-sm-6 vc_col-lg-3/5 vc_col-md-3/5 vc_col-has-fill">
                                                    <div class="vc_column-inner vc_custom_1659978343922">
                                                        <div class="wpb_wrapper">
                                                            <div
                                                                class="wpb_single_image wpb_content_element vc_align_right wpb_content_element  banner-img">

                                                                <figure class="wpb_wrapper vc_figure">
                                                                    <div
                                                                        class="vc_single_image-wrapper   vc_box_border_grey">
                                                                        <img fetchpriority="high" decoding="async"
                                                                            width="1280" height="776"
                                                                            src="{{ asset('assets/front/img/home-banner-1280x776-1.jpg') }}"
                                                                            class="vc_single_image-img attachment-full"
                                                                            alt="" title="home-banner-1280x776-1"
                                                                            srcset="{{ asset('assets/front/img/home-banner-1280x776-1.jpg') }} 1280w, {{ asset('assets/front/img/home-banner-1280x776-1-300x182.jpg') }} 300w, {{ asset('assets/front/img/home-banner-1280x776-1-1024x621.jpg') }} 1024w, {{ asset('assets/front/img/home-banner-1280x776-1-768x466.jpg') }} 768w"
                                                                            sizes="(max-width: 1280px) 100vw, 1280px">
                                                                    </div>
                                                                </figure>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="re-order-section" data-vc-full-width="true"
                                                data-vc-full-width-init="true"
                                                class="vc_row wpb_row vc_row-fluid vc_custom_1569530319853 vc_row-has-fill">
                                                <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-has-fill">
                                                    <div class="vc_column-inner vc_custom_1430346403163">
                                                        <div class="wpb_wrapper">
                                                            <div
                                                                class="wpb_text_column wpb_content_element text-center enlarge">
                                                                <div class="wpb_wrapper">
                                                                    <p><strong>Professional cheques printing services for businesses of all sizes.&nbsp;&nbsp;</strong> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vc_row-full-width vc_clearfix"></div>
                                            <div data-vc-full-width="true" data-vc-full-width-init="true"
                                                class="vc_row wpb_row vc_row-fluid order-cheques vc_custom_1569524641223 vc_row-has-fill">
                                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div class="vc_row wpb_row vc_inner vc_row-fluid content-width">
                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                    <div class="vc_column-inner">
                                                                        <div class="wpb_wrapper">
                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <p
                                                                                        style="text-align: center !important; font-size: 18px; color: #093a7e; margin-bottom: 0 !important;">
                                                                                        <strong>25% More Cheques
                                                                                            Free!&nbsp;</strong>
                                                                                    </p>

                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="wpb_single_image wpb_content_element vc_align_center wpb_content_element">

                                                                                <figure class="wpb_wrapper vc_figure">
                                                                                    <div
                                                                                        class="vc_single_image-wrapper   vc_box_border_grey">
                                                                                        <img decoding="async"
                                                                                            class="vc_single_image-img "
                                                                                            src="https://chequesnow.ca/wp-content/uploads/2010/06/manual-cheques-two-per-page1-350x198.png"
                                                                                            width="350" height="198"
                                                                                            alt="cheque book"
                                                                                            title="image of manual two per page cheques"
                                                                                            loading="lazy">
                                                                                    </div>
                                                                                </figure>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                    <div class="vc_column-inner">
                                                                        <div class="wpb_wrapper">
                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <h3><a
                                                                                            href="{{ url('manual-cheque-list/' . 1) }}">Manual
                                                                                            Cheques</a></h3>

                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <p>Get 25% MORE cheques* when you order
                                                                                        Manual Business Cheques. Offering a
                                                                                        complete range of quality Manual
                                                                                        Cheques. Available in 5 different
                                                                                        background colors. Rush next day
                                                                                        delivery to most of Canada
                                                                                        available.<br>
                                                                                        <em>*Compared to other cheque
                                                                                            suppliers</em>
                                                                                    </p>
                                                                                    <p><a class="btn btn-danger btn-lg"
                                                                                            href="{{ url('manual-cheque-list/' . 1) }}"
                                                                                            target=""
                                                                                            rel="noopener noreferrer">Order
                                                                                            Now</a></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vc_row-full-width vc_clearfix"></div>
                                            <div class="vc_row wpb_row vc_row-fluid order-cheques order-laser">
                                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div
                                                                class="vc_row wpb_row vc_inner vc_row-fluid content-width">
                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                    <div class="vc_column-inner">
                                                                        <div class="wpb_wrapper">
                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <h3><a title="Laser Cheques"
                                                                                            href="{{ url('laser-cheque') }}">Laser
                                                                                            Cheques</a></h3>

                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="wpb_text_column wpb_content_element no-mobile">
                                                                                <div class="wpb_wrapper">
                                                                                    <p>Get 25% MORE cheques* when you order
                                                                                        Laser Cheques. Our Laser Cheques
                                                                                        have the highest security features
                                                                                        in Canada. Cheques are 100%
                                                                                        compatible with any cheque software
                                                                                        program that you use. Order online
                                                                                        24/7.<br>
                                                                                        <em>*Compared to other cheque
                                                                                            suppliers</em>
                                                                                    </p>
                                                                                    <p><a class="btn btn-danger btn-lg"
                                                                                            href="{{ url('laser-cheque') }}">Order
                                                                                            Now</a></p>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                    <div class="vc_column-inner">
                                                                        <div class="wpb_wrapper">
                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <p
                                                                                        style="text-align: center !important; font-size: 18px; color: #093a7e; margin-bottom: 0 !important;">
                                                                                        <strong>25% More Cheques
                                                                                            Free!&nbsp;</strong>
                                                                                    </p>

                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="wpb_single_image wpb_content_element vc_align_center wpb_content_element">

                                                                                <figure class="wpb_wrapper vc_figure">
                                                                                    <div
                                                                                        class="vc_single_image-wrapper   vc_box_border_grey">
                                                                                        <img decoding="async"
                                                                                            width="420" height="172"
                                                                                            class="vc_single_image-img attachment-full entered lazyloaded"
                                                                                            alt="cheque"
                                                                                            title="LaserCheque-new"
                                                                                            data-lazy-srcset="https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new.jpg 420w, https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new-300x123.jpg 300w"
                                                                                            data-lazy-sizes="(max-width: 420px) 100vw, 420px"
                                                                                            data-lazy-src="https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new.jpg"
                                                                                            src="https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new.jpg"
                                                                                            data-ll-status="loaded"
                                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                                            srcset="https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new.jpg 420w, https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new-300x123.jpg 300w"><noscript><img
                                                                                                decoding="async"
                                                                                                width="420"
                                                                                                height="172"
                                                                                                src="https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new.jpg"
                                                                                                class="vc_single_image-img attachment-full"
                                                                                                alt="cheque"
                                                                                                title="LaserCheque-new"
                                                                                                srcset="https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new.jpg 420w, https://chequesnow.ca/wp-content/uploads/2017/06/LaserCheque-new-300x123.jpg 300w"
                                                                                                sizes="(max-width: 420px) 100vw, 420px" /></noscript>
                                                                                    </div>
                                                                                </figure>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-vc-full-width="true" data-vc-full-width-init="true"
                                                class="vc_row wpb_row vc_row-fluid order-cheques vc_custom_1569524650474 vc_row-has-fill">
                                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div
                                                                class="vc_row wpb_row vc_inner vc_row-fluid content-width">
                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                    <div class="vc_column-inner">
                                                                        <div class="wpb_wrapper">
                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <p
                                                                                        style="text-align: center !important; font-size: 18px; color: #093a7e; margin-bottom: 0 !important;">
                                                                                        <strong>25% More Cheques
                                                                                            Free!&nbsp;</strong>
                                                                                    </p>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="wpb_single_image wpb_content_element vc_align_center wpb_content_element">

                                                                                <figure class="wpb_wrapper vc_figure">
                                                                                    <div
                                                                                        class="vc_single_image-wrapper   vc_box_border_grey">
                                                                                        <img decoding="async"
                                                                                            width="420" height="184"
                                                                                            class="vc_single_image-img attachment-full entered lazyloaded"
                                                                                            alt=""
                                                                                            title="PersonalCheque-new"
                                                                                            data-lazy-srcset="https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new.jpg 420w, https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new-300x131.jpg 300w"
                                                                                            data-lazy-sizes="(max-width: 420px) 100vw, 420px"
                                                                                            data-lazy-src="https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new.jpg"
                                                                                            src="https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new.jpg"
                                                                                            data-ll-status="loaded"
                                                                                            sizes="(max-width: 420px) 100vw, 420px"
                                                                                            srcset="https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new.jpg 420w, https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new-300x131.jpg 300w"><noscript><img
                                                                                                decoding="async"
                                                                                                width="420"
                                                                                                height="184"
                                                                                                src="https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new.jpg"
                                                                                                class="vc_single_image-img attachment-full"
                                                                                                alt=""
                                                                                                title="PersonalCheque-new"
                                                                                                srcset="https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new.jpg 420w, https://chequesnow.ca/wp-content/uploads/2017/06/PersonalCheque-new-300x131.jpg 300w"
                                                                                                sizes="(max-width: 420px) 100vw, 420px" /></noscript>
                                                                                    </div>
                                                                                </figure>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                    <div class="vc_column-inner">
                                                                        <div class="wpb_wrapper">
                                                                            <div
                                                                                class="wpb_text_column wpb_content_element">
                                                                                <div class="wpb_wrapper">
                                                                                    <h3><a title="Personal Cheques"
                                                                                            href="{{ url('personal-cheque') }}">Personal
                                                                                            Cheques</a></h3>

                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="wpb_text_column wpb_content_element no-mobile">
                                                                                <div class="wpb_wrapper">
                                                                                    <p>Get 25% MORE cheques* when you order
                                                                                        Personal Cheques. Pay less compared
                                                                                        to what your bank charges. Plus
                                                                                        receive AIR MILES reward miles on
                                                                                        every order!<br>
                                                                                        <em>*Compared to other cheque
                                                                                            suppliers</em>
                                                                                    </p>
                                                                                    <p><a class="btn btn-danger btn-lg"
                                                                                            href="{{ url('personal-cheque') }}">Order
                                                                                            Now</a></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vc_row-full-width vc_clearfix"></div>
                                            <div data-vc-full-width="true" data-vc-full-width-init="true"
                                                class="vc_row wpb_row vc_row-fluid vc_custom_1569530740609 vc_row-has-fill">
                                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                                    <div class="vc_column-inner ">
                                                        <div class="wpb_wrapper">
                                                            <div
                                                                class="wpb_text_column wpb_content_element text-center text-black enlarge">
                                                                <div class="wpb_wrapper">
                                                                    <p>Not sure which cheque type is right for you?
                                                                        <strong>Call us at <span class="phone-number">+1
                                                                                778 374 7100</span></strong>
                                                                    </p><strong>

                                                                    </strong>
                                                                </div><strong>
                                                                </strong>
                                                            </div><strong>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
