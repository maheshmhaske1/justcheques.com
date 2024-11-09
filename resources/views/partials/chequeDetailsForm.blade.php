@extends('layouts.app')
@section('content')
    <section class="mid-content   ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- bof  breadcrumb -->
                    <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
                        <a href="/computerCheques">{{ $chequeCategoryName }}</a>&nbsp;<span class="separator">//</span>&nbsp;
                        <a href="/chequeOnTop">{{ $chequeSubCategoryName }}</a>&nbsp;<span class="separator">//</span>&nbsp;
                        {{ $chequeList->chequeName }}
                    </div>
                    <gcse:searchresults></gcse:searchresults>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="centerColumn" id="productGeneral">
                        <!--bof Form start-->
                        @if (auth()->check())
                            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!--eof Form start-->
                                <div class="desktopPrd">
                                    <div class="two-col-left back">
                                        <div class="info-rating">
                                        </div>
                                        <!--averageReviews-->
                                        <div class="tabs minimal-2">
                                            <div class="two-col-right forward">
                                                <h1 id="productName" class="productGeneral">Laser Cheques / Computer Cheques
                                                    on top
                                                </h1>
                                                <div id="price-wrapper" class="back">
                                                    <span id="price-label" class="back">Price:</span>
                                                    <span id="productPrices"
                                                        class="productGeneral">${{ $chequeList->price }}</span>
                                                    <!--eof Product Price block -->
                                                </div>
                                                <div id="productAttributes">
                                                    <div class="form-item">
                                                        <label class="form-label my-3 choose_customer">Choose
                                                            Customer<sup>*</sup></label>
                                                        <div class="customer_css">
                                                            <select name="customer_id" id="customer_id"
                                                                onchange="updateFormAction()"
                                                                class="form-control selectCustomer">
                                                                <option selected>Choose Customer</option>
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->id }}">
                                                                        {{ $customer->company }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if (Auth::check() && Auth::user()->role === 'vendor')
                                                                <a href="{{ url('customer') }}">
                                                                    <input class="btn btn-default add_customer"
                                                                        value="Add Customer">
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <button type="button" id="reorder-button" class="btn btn-primary"
                                                        data-toggle="modal" data-target="#reorder"
                                                        style="display: none;">Reorder</button>

                                                    <h3 id="attribsOptionsText" class="field-to-hide">Options</h3>
                                                    <div class="wrapperAttribsOptions 2 field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="attribsSelect 14"
                                                                            for="attrib-17">Select
                                                                            Quantity
                                                                    </th>
                                                                    <td>
                                                                        <select name="quantity" id="quantity"
                                                                            class="form-control" required
                                                                            onchange="updateTotalAmount()">
                                                                            <option value="65" data-quantity="0"
                                                                                selected>
                                                                                Please Select Quantity - Free
                                                                                shipping within ON &amp; QC
                                                                            </option>
                                                                            <option value="21" data-quantity="50"
                                                                                data-price="69">50 ( +$69.00 )</option>
                                                                            <option value="22" data-quantity="100"
                                                                                data-price="79">100 ( +$79.00 )</option>
                                                                            <option value="23" data-quantity="250"
                                                                                data-price="139">250 ( +$139.00 )</option>
                                                                            <option value="175" data-quantity="500"
                                                                                data-price="169">250 + 250 Cheque
                                                                                Envelopes ★ Sale ★ ( +$169.00 )
                                                                            </option>
                                                                            <option value="24" data-quantity="500"
                                                                                data-price="219">500 ( +$219.00 )</option>
                                                                            <option value="25" data-quantity="1000"
                                                                                data-price="319">1000 ★ BEST SELLER ★ (
                                                                                +$319.00 )
                                                                            </option>
                                                                            <option value="276" data-quantity="2000"
                                                                                data-price="429">1000 + 1000 Cheque
                                                                                Envelopes ★ Sale ★ ( +$429.00 )
                                                                            </option>
                                                                            <option value="26" data-quantity="2000"
                                                                                data-price="479">2000 ( +$479.00 )
                                                                            </option>
                                                                            <option value="27" data-quantity="2500"
                                                                                data-price="539">2500 ( +$539.00 )
                                                                            </option>
                                                                            <option value="28" data-quantity="3000"
                                                                                data-price="599">3000 ( +$599.00 )
                                                                            </option>
                                                                            <option value="29" data-quantity="4000"
                                                                                data-price="759">4000 ( +$759.00 )
                                                                            </option>
                                                                            <option value="30" data-quantity="5000"
                                                                                data-price="929">5000 ( +$929.00 )
                                                                            </option>
                                                                            <option value="64" data-quantity="10000"
                                                                                data-price="1499">10,000 ( +$1,499.00 )
                                                                            </option>
                                                                            <option value="244" data-quantity="15000"
                                                                                data-price="1799">15000 ( +$1,799.00 )
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        Select Colour
                                                                    </th>
                                                                    <td>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo Prdselected "><label
                                                                    class="attribsRadioButton four" for="attrib-34-60"><a
                                                                        class="fancybox radP"
                                                                        href="{{ asset('assets/front/img/economical-top_03.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/Burgundy.jpg') }}"
                                                                        alt="60" title=" 60 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Burgundy</label><br><input
                                                                    type="radio" name="color" value="Purple"
                                                                    checked="checked" id="attrib-34-60"
                                                                    class="rdo attimgRad"></div>
                                                        </div>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo "><label
                                                                    class="attribsRadioButton four" for="attrib-34-58"><a
                                                                        class="fancybox radP 1"
                                                                        href="{{ asset('assets/front/img/economical-top_05.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/Blue.jpg') }}"
                                                                        alt="58" title=" 58 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Blue</label><br><input
                                                                    type="radio" name="color" value="Blue"
                                                                    id="attrib-34-58" class="rdo attimgRad"></div>
                                                        </div>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo "><label
                                                                    class="attribsRadioButton four" for="attrib-34-59"><a
                                                                        class="fancybox radP 1"
                                                                        href="{{ asset('assets/front/img/economical-top_06.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/green.jpg') }}"
                                                                        alt="59" title=" 59 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Green</label><br><input
                                                                    type="radio" name="color" value="Green"
                                                                    id="attrib-34-59" class="rdo attimgRad"></div>
                                                        </div>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo "><label
                                                                    class="attribsRadioButton four" for="attrib-34-61"><a
                                                                        class="fancybox radP 1"
                                                                        href="{{ asset('assets/front/img/economical-top_01.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/tan.jpg') }}"
                                                                        alt="61" title=" 61 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Tan</label><br><input
                                                                    type="radio" name="color" value="Tan"
                                                                    id="attrib-34-61" class="rdo attimgRad"></div>
                                                        </div>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo "><label
                                                                    class="attribsRadioButton four" for="attrib-34-169"><a
                                                                        class="fancybox radP 1"
                                                                        href="{{ asset('assets/front/img/economical-top_04.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/grey.jpg') }}"
                                                                        alt="169" title=" 169 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Grey</label><br><input
                                                                    type="radio" name="color" value="gray"
                                                                    id="attrib-34-169" class="rdo attimgRad"></div>
                                                        </div>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo "><label
                                                                    class="attribsRadioButton four" for="attrib-34-170"><a
                                                                        class="fancybox radP 1"
                                                                        href="{{ asset('assets/front/img/economical-top.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/purple.jpg') }}"
                                                                        alt="170" title=" 170 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Purple</label><br><input
                                                                    type="radio" name="color" value="purple"
                                                                    id="attrib-34-170" class="rdo attimgRad"></div>
                                                        </div>
                                                        <div class="main-img radiobtns">
                                                            <div class="attribImg pdInfo "><label
                                                                    class="attribsRadioButton four" for="attrib-34-212"><a
                                                                        class="fancybox radP 1"
                                                                        href="{{ asset('assets/front/img/economical-top_02.jpg') }}"><i
                                                                            class="fa fa-search-plus"
                                                                            aria-hidden="true"></i></a><img
                                                                        src="{{ asset('assets/front/img/orange.jpg') }}"
                                                                        alt="212" title=" 212 " width="100"
                                                                        height="80"
                                                                        class="attimg"><br>Orange</label><br><input
                                                                    type="radio" name="color" value="orange"
                                                                    id="attrib-34-212" class="rdo attimgRad"></div>
                                                        </div>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="attribsInput"
                                                                            for="attrib-21-0">Company
                                                                            Info
                                                                        </label>
                                                                    </th>
                                                                    <td>
                                                                        <textarea class="attribsTextarea" name="company_info" rows="7" cols="50"
                                                                            onkeydown="characterCount(this.form['id[txt_21]'],this.form.remainingtxt_21,2000);"
                                                                            onkeyup="characterCount(this.form['id[txt_21]'],this.form.remainingtxt_21,2000);" id="attrib-21-0"></textarea>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <h3 class="attributesComments field-to-hide">For accuracy please upload
                                                        or
                                                        fax a voided
                                                        cheque, if you cannot supply a voided cheque we may request that you
                                                        obtain a MICR SPEC SHEET from your bank.
                                                    </h3>
                                                    <div class="wrapperAttribsOptions 2 field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsSelect 14"
                                                                            for="attrib-50">Voided
                                                                            Cheque Sample</label>
                                                                    </th>
                                                                    <td>
                                                                        <select name="voided_cheque" id="voided_cheque"
                                                                            onchange="toggleFileInput()">
                                                                            <option value="">Please Select</option>
                                                                            <option value="upload">Upload</option>
                                                                            <option value="notVoidCheck">I Do Not Have A
                                                                                Void
                                                                                Cheque</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2" id="file-upload-field"
                                                        style="display: none; margin-top: 10px;">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="attribsUploads"
                                                                            for="attrib-31-0">Please
                                                                            upload a voided cheque</label>:
                                                                    </th>
                                                                    <td>
                                                                        <input type="file" name="voided_cheque_file"
                                                                            id="attrib-31-0" class="filestyle"
                                                                            tabindex="-1"
                                                                            style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;">
                                                                        <div class="bootstrap-filestyle input-group">
                                                                            <div name="filedrag"
                                                                                style="position: absolute; width: 100%; height: 0px; z-index: -1;">
                                                                            </div>
                                                                            <span
                                                                                class="group-span-filestyle input-group-btn"
                                                                                tabindex="0"><label for="attrib-31-0"
                                                                                    style="margin-bottom: 0;"
                                                                                    class="btn btn-outline-primary "><span
                                                                                        class="buttonText">Choose
                                                                                        File</span></label></span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 hide_class field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsInput"
                                                                            for="institution_number">Institution
                                                                            Number
                                                                        </label>
                                                                    </th>
                                                                    <td><input type="text" name="institution_number"
                                                                            id="institution_number" class="form-control"
                                                                            size="32" maxlength="3"
                                                                            title="Please enter exactly 3 digits"
                                                                            aria-required="true"
                                                                            placeholder="Enter 3 digits">
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 hide_class field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsInput" for="attrib-27-0">Transit
                                                                            Number
                                                                        </label>
                                                                    </th>
                                                                    <td> <input type="text" name="transit_number"
                                                                            id="transit_number" class="form-control"
                                                                            size="32" maxlength="5"
                                                                            title="Please enter exactly 5 digits"
                                                                            aria-required="true"
                                                                            placeholder="Enter 5 digits">
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 hide_class field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsInput" for="attrib-25-0">Account
                                                                            Number
                                                                        </label>
                                                                    </th>
                                                                    <td><input type="password" name="account_number"
                                                                            size="32" maxlength="32" value=""
                                                                            id="account_number" aria-required="true">

                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 hide_class field-to-hide"
                                                        id="26_sep">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsInput" for="attrib-26-0">Confirm
                                                                            Account Number
                                                                        </label>
                                                                    </th>
                                                                    <td>
                                                                        <div class="field-in 26_p"><input type="text"
                                                                                name="confirm_account_number"
                                                                                size="32" maxlength="32"
                                                                                value="" id="confirm_account_number"
                                                                                aria-required="true">

                                                                        </div>
                                                                        <div> <span class="invalid-feedback"
                                                                                id="error-message"
                                                                                style=" color: red; display:none; float: inline-start;">Account
                                                                                numbers do not match.</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 hide_class field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsInput" for="attrib-28-0">Cheque
                                                                            Start Number
                                                                        </label>
                                                                    </th>
                                                                    <td><input alpha="23" type="text"
                                                                            data-rule-required="true"
                                                                            name="cheque_start_number" size="10"
                                                                            maxlength="10" value=""
                                                                            id="attrib-28-0" aria-required="true">
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 hide_class field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="jgattrib3">*</label><label
                                                                            class="attribsInput" for="attrib-28-0">Cheque
                                                                            End Number
                                                                        </label>
                                                                    </th>
                                                                    <td><input alpha="23" type="text"
                                                                            data-rule-required="true"
                                                                            name="cheque_end_number" size="10"
                                                                            maxlength="10" value=""
                                                                            id="cheque_end_number" aria-required="true">
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wrapperAttribsOptions 2 field-to-hide">
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <th>
                                                                        <label class="attribsUploads"
                                                                            for="attrib-24-0">Upload
                                                                            your logo
                                                                    </th>
                                                                    <td>
                                                                        <input type="file" name="company_logo"
                                                                            id="attrib-24-0" class="filestyle"
                                                                            tabindex="-1"
                                                                            style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;">
                                                                        <div class="bootstrap-filestyle input-group">
                                                                            <div name="filedrag"
                                                                                style="position: absolute; width: 100%; height: 0px; z-index: -1;">
                                                                            </div>
                                                                            <span
                                                                                class="group-span-filestyle input-group-btn"
                                                                                tabindex="0"><label for="attrib-24-0"
                                                                                    style="margin-bottom: 0;"
                                                                                    class="btn btn-outline-primary "><span
                                                                                        class="buttonText">Choose
                                                                                        File</span></label></span>
                                                                        </div>
                                                                        <br>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!--eof Attributes Module -->
                                                <div id="price-cart-wrapper">
                                                    <!--bof Add to Cart Box -->
                                                    <div id="cartAdd" class="back field-to-hide">
                                                        <input type="hidden" name="cart_quantity" id="cart_quantity"
                                                            value="1">
                                                        <input type="hidden" name="cheque_img" id="cheque_img"
                                                            value="{{ $chequeList->img }}">
                                                        <input type="hidden" name="vendor_id" id="vendor_id"
                                                            value="{{ auth()->user()->id }}">
                                                        <input type="hidden" name="cheque_category_id"
                                                            id="cheque_category_id" value="{{ $chequeList->id }}"><input
                                                            class="cssButton submit_button button  button_in_cart"
                                                            id="previewButton" type="submit" value="Preview"
                                                            data-toggle="modal" data-target="#exampleModalCenter">
                                                        <span id="loadBar"></span><br><span id="button_cart"></span>
                                                    </div>

                                                    <!-- Modal -->
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        Preview Cheque Data</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="container-fluid">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div id="productAdditionalImages">
                                                                                    <!-- Image preview section -->
                                                                                    <section id="demos">
                                                                                        <div class="sliderRow">
                                                                                            <div class="large-12 columns">
                                                                                                <div
                                                                                                    class="owl-carousel owl-theme owl-loaded owl-drag">
                                                                                                    <div
                                                                                                        class="owl-stage-outer">
                                                                                                        <div
                                                                                                            class="owl-stage">
                                                                                                            <div
                                                                                                                class="owl-item active">
                                                                                                                <div
                                                                                                                    class="item">
                                                                                                                    <a class="fancybox-buttons"
                                                                                                                        data-fancybox-group="button"
                                                                                                                        id="mainProductImage"
                                                                                                                        rel="productImages">
                                                                                                                        <img id="chequeImgPreview"
                                                                                                                            src="{{ asset('assets/front/img/' . $chequeList->img) }}"
                                                                                                                            alt="Product Image"
                                                                                                                            style="width: 100%; height: auto;">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 ml-auto">
                                                                                <div class="card mt-5">
                                                                                    <div class="card-body">
                                                                                        <h5 class="card-title">Order
                                                                                            Details</h5>
                                                                                        <p><strong>Customer ID:</strong>
                                                                                            <span
                                                                                                id="previewCustomerID"></span>
                                                                                        </p>
                                                                                        <p><strong>Quantity:</strong> <span
                                                                                                id="previewQuantity"></span>
                                                                                        </p>
                                                                                        <p><strong>Color:</strong> <span
                                                                                                id="previewColor"></span>
                                                                                        </p>
                                                                                        <p><strong>Company Info:</strong>
                                                                                            <span
                                                                                                id="previewCompanyInfo"></span>
                                                                                        </p>
                                                                                        <p><strong>Institution
                                                                                                Number:</strong> <span
                                                                                                id="previewInstitutionNumber"></span>
                                                                                        </p>
                                                                                        <p><strong>Transit Number:</strong>
                                                                                            <span
                                                                                                id="previewTransitNumber"></span>
                                                                                        </p>
                                                                                        <p><strong>Account Number:</strong>
                                                                                            <span
                                                                                                id="previewAccountNumber"></span>
                                                                                        </p>
                                                                                        <p><strong>Cheque Start
                                                                                                Number:</strong> <span
                                                                                                id="previewChequeStartNumber"></span>
                                                                                        </p>
                                                                                        <p><strong>Cheque End
                                                                                                Number:</strong> <span
                                                                                                id="previewChequeEndNumber"></span>
                                                                                        </p>
                                                                                        <p><strong>Cart Quantity:</strong>
                                                                                            <span
                                                                                                id="previewCartQuantity"></span>
                                                                                        </p>
                                                                                        <p><strong>Cheque Category
                                                                                                ID:</strong> <span
                                                                                                id="previewChequeCategoryID"></span>
                                                                                        </p>
                                                                                        <p><strong>Vendor ID:</strong> <span
                                                                                                id="previewVendorID"></span>
                                                                                        </p>

                                                                                        <div id="previewVoidedChequeFile"
                                                                                            style="display:none;">
                                                                                            <p><strong>Voided Cheque
                                                                                                    File:</strong></p>
                                                                                            <img id="voidedChequeFilePreview"
                                                                                                src=""
                                                                                                alt="Voided Cheque"
                                                                                                style="width: 100px;">
                                                                                        </div>

                                                                                        <div id="previewCompanyLogo"
                                                                                            style="display:none;">
                                                                                            <p><strong>Company
                                                                                                    Logo:</strong></p>
                                                                                            <img id="companyLogoPreview"
                                                                                                src=""
                                                                                                alt="Company Logo"
                                                                                                style="width: 100px;">
                                                                                        </div>

                                                                                        <div id="previewChequeImg"
                                                                                            style="display:none;">
                                                                                            <p><strong>Cheque
                                                                                                    Image:</strong></p>
                                                                                            <img id="chequeImgPreview"
                                                                                                src=""
                                                                                                alt="Cheque Image"
                                                                                                style="width: 100px;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Edit</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        onclick="return check_account_num();">Place
                                                                        Order</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="clearBoth"></div>
                                                    <!--eof Add to Cart Box-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--EOF .tabs-minimal-->
                                        <div class="left-prd-img">
                                            <div class="extra-mobile">
                                                <div id="faq-list">
                                                    <div class="card">
                                                        <div class="card-header" role="tab" id="headingOnermo">
                                                            <h5 class="mb-0">
                                                                <a data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapseOnermo" aria-expanded="true"
                                                                    aria-controls="collapseOne" class="collapsed">
                                                                    <h4>Reviews</h4>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseOnermo" class="collapse collapseing"
                                                            role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="card-block">
                                                                <span>
                                                                    <section id="map-reviews">
                                                                        <h3>Customer Reviews</h3>
                                                                        <div class="review-container">
                                                                            <div class="overallRating">
                                                                                <span class="overall-rating-label">Overall
                                                                                    Rating</span>
                                                                                <span class="stars">
                                                                                    <span class="on"><img
                                                                                            src="{{ asset('assets/front/img/stars_5.gif') }}"
                                                                                            alt="Star Rating"
                                                                                            title=" Star Rating "></span>
                                                                                </span>
                                                                            </div>
                                                                            <div class="review-buttons">
                                                                                <a href="/business-cheques/cheque-on-top/laser-cheques-computer-cheques-on-top/write-a-review"
                                                                                    class="writeAReview">Write a Review</a>
                                                                            </div>
                                                                            <ul class="reviewsList">
                                                                                <li>
                                                                                    <div class="client-stars">
                                                                                        <span class="on"><img
                                                                                                src="{{ asset('assets/front/img/stars_5.gif') }}"
                                                                                                alt="Star Rating"
                                                                                                title=" Star Rating "></span>
                                                                                    </div>
                                                                                    <div class="revtit">
                                                                                        I am very impressed
                                                                                    </div>
                                                                                    <div class="review-comment">
                                                                                        Hi,
                                                                                        This is my first time ordering with
                                                                                        your
                                                                                        company, and I wanted to let you
                                                                                        know
                                                                                        that your service is exceptional!!
                                                                                        Thank
                                                                                        you!
                                                                                        I ordered Wednesday, and I have the
                                                                                        cheques in my hand today – Monday!!
                                                                                        WOW!
                                                                                        Great job, I am very happy with the
                                                                                        product, and the service was
                                                                                        AWESOME!
                                                                                        I will be sure to recommend you to
                                                                                        others, as I am very impressed.
                                                                                    </div>
                                                                                    <div class="review-user-details">
                                                                                        <span class="review-author">By: Ann
                                                                                            H.</span> |
                                                                                        <span class="review-date">Date:
                                                                                            October
                                                                                            03, 2018</span>
                                                                                    </div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="client-stars">
                                                                                        <span class="on"><img
                                                                                                src="{{ asset('assets/front/img/stars_5.gif') }}"
                                                                                                alt="Star Rating"
                                                                                                title=" Star Rating "></span>
                                                                                    </div>
                                                                                    <div class="revtit">
                                                                                        Good product for the price
                                                                                    </div>
                                                                                    <div class="review-comment">
                                                                                        Cheques were printed correctly and
                                                                                        arrived super fast!
                                                                                    </div>
                                                                                    <div class="review-user-details">
                                                                                        <span class="review-author">By:
                                                                                            Mukash
                                                                                            E.</span> |
                                                                                        <span class="review-date">Date:
                                                                                            August
                                                                                            08, 2018</span>
                                                                                    </div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="client-stars">
                                                                                        <span class="on"><img
                                                                                                src="{{ asset('assets/front/img/stars_5.gif') }}"
                                                                                                alt="Star Rating"
                                                                                                title=" Star Rating "></span>
                                                                                    </div>
                                                                                    <div class="revtit">
                                                                                        Cheques arrived quickly
                                                                                    </div>
                                                                                    <div class="review-comment">
                                                                                        I was looking to get cheques ASAP, I
                                                                                        came across the ChequesPlus website
                                                                                        and
                                                                                        the rep told me over the phone he
                                                                                        will
                                                                                        rush out my ordered cheques as soon
                                                                                        as
                                                                                        possible, I got it the next morning
                                                                                        and
                                                                                        was very happy with their service.
                                                                                    </div>
                                                                                    <div class="review-user-details">
                                                                                        <span class="review-author">By:
                                                                                            Monish
                                                                                            K.</span> |
                                                                                        <span class="review-date">Date:
                                                                                            July
                                                                                            07, 2017</span>
                                                                                    </div>
                                                                                </li>
                                                                                <a href="/business-cheques/cheque-on-top/laser-cheques-computer-cheques-on-top/reviews?number_of_uploads=2&amp;"
                                                                                    class="read-review">Read More
                                                                                    Reviews</a>
                                                                            </ul>
                                                                        </div>
                                                                    </section>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="faq-list">
                                                    <div class="card">
                                                        <div class="card-header" role="tab" id="headingOne2">
                                                            <h5 class="mb-0">
                                                                <a data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapseOn2" aria-expanded="true"
                                                                    aria-controls="collapseOne" class="collapsed">
                                                                    <h4>Frequently Asked Questions</h4>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseOn2" class="collapse collapseing"
                                                            role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="card-block">
                                                                <div id="faq">
                                                                    <a href="#faq-content" id="faq-link">
                                                                        <img alt=""
                                                                            src="{{ asset('assets/front/img/faq.png') }}">
                                                                    </a>
                                                                </div>
                                                                <span>
                                                                    <div id="faq-list">
                                                                        <div id="accordion" class="faq-questions"
                                                                            role="tablist" aria-multiselectable="true">
                                                                            <div class="card">
                                                                                <div data-prt="1"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne1">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne1"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>Are
                                                                                                these cheques compatible
                                                                                                with
                                                                                                quickbooks software?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne1"
                                                                                    class="collapse collapseing myTogIn1"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>Yes,
                                                                                            they are 100% compatible with
                                                                                            quickbooks and with all popular
                                                                                            accounting programs</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="2"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne2">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne2"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>how
                                                                                                many cheques on a
                                                                                                page?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne2"
                                                                                    class="collapse collapseing myTogIn2"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>This
                                                                                            is a single cheque per page with
                                                                                            stubs. Looking for 3 per page?
                                                                                            Click
                                                                                            here:
                                                                                            https://www.chequesplus.com/business-cheques/three-per-page-cheques/three-to-a-page</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="3"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne3">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne3"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>Do
                                                                                                the business cheques have
                                                                                                security features?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne3"
                                                                                    class="collapse collapseing myTogIn3"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>The
                                                                                            logo can be the size you like
                                                                                            and a
                                                                                            proof for approval is sent for
                                                                                            each
                                                                                            order before printing.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="4"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne4">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne4"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>Will
                                                                                                my bank honour your
                                                                                                cheques?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne4"
                                                                                    class="collapse collapseing myTogIn4"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>Absolutely,
                                                                                            our cheques meet the Canadian
                                                                                            Payments Association (CPA)
                                                                                            guidelines and are guaranteed to
                                                                                            be
                                                                                            accepted at all banks, credit
                                                                                            unions
                                                                                            and financial
                                                                                            institutions.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="5"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne5">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne5"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>Would
                                                                                                it be possible to see a
                                                                                                sample
                                                                                                of the cheque before
                                                                                                printing if
                                                                                                it corresponds to our
                                                                                                layout?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne5"
                                                                                    class="collapse collapseing myTogIn5"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>The
                                                                                            logo can be the size you like
                                                                                            and a
                                                                                            proof for approval is sent for
                                                                                            each
                                                                                            order before printing.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="6"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne6">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne6"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>How
                                                                                                big will the logo be on the
                                                                                                cheque?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne6"
                                                                                    class="collapse collapseing myTogIn6"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>Yes.
                                                                                            A PDF sample will be emailed to
                                                                                            you
                                                                                            before printing asking your
                                                                                            approval.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="7"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne7">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne7"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>Are
                                                                                                the " on
                                                                                                special" cheque envelopes
                                                                                                self
                                                                                                seal or lick?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne7"
                                                                                    class="collapse collapseing myTogIn7"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>They
                                                                                            are self seal, no licking or
                                                                                            peeling
                                                                                            just flip and seal</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="8"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne8">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne8"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>What
                                                                                                printer can I use to print
                                                                                                the
                                                                                                cheques?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne8"
                                                                                    class="collapse collapseing myTogIn8"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>The
                                                                                            logo can be the size you like
                                                                                            and a
                                                                                            proof for approval is sent for
                                                                                            each
                                                                                            order before printing.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="9"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne9">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne9"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>Can
                                                                                                you print cheques for U.S.
                                                                                                Dollar accounts?</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne9"
                                                                                    class="collapse collapseing myTogIn9"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>Laser
                                                                                            cheques are compatible with
                                                                                            laser
                                                                                            and ink jet printers. They are
                                                                                            printed on an 8.5" x 11"
                                                                                            pages.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card">
                                                                                <div data-prt="10"
                                                                                    class="card-header myToggle"
                                                                                    role="tab" id="headingOne10">
                                                                                    <h5 class="mb-0">
                                                                                        <a data-toggle="collapse"
                                                                                            data-parent="#accordion"
                                                                                            href="#collapseOne10"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne"
                                                                                            class="collapsed">
                                                                                            <span
                                                                                                class="quest">Q</span><span>How
                                                                                                long will it take my order
                                                                                                to
                                                                                                arrive?&nbsp;</span>
                                                                                        </a>
                                                                                    </h5>
                                                                                </div>
                                                                                <div id="collapseOne10"
                                                                                    class="collapse collapseing myTogIn10"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="headingOne">
                                                                                    <div class="card-block">
                                                                                        <span
                                                                                            class="ans">A</span><span>Please
                                                                                            see our Shipping Policy page for
                                                                                            detailed information on shipping
                                                                                            times and arrivals.</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div id="faq">
                                                                    <a href="#faq-content" id="faq-link">
                                                                        <img alt=""
                                                                            src="{{ asset('assets/front/img/faq.png') }}">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--bof Main Product Image -->
                                            <div id="productAdditionalImages">
                                                <section id="demos">
                                                    <div class="sliderRow">
                                                        <div class="large-12 columns">
                                                            <div class="owl-carousel owl-theme owl-loaded owl-drag">
                                                                <div class="owl-stage-outer">
                                                                    <div class="owl-stage"
                                                                        style="transform: translate3d(0px, 0px, 0px); transition: all; width: 408px;">
                                                                        <div class="owl-item active"
                                                                            style="width: 388px; margin-right: 20px;">
                                                                            <div class="item"><a
                                                                                    class="fancybox-buttons"
                                                                                    data-fancybox-group="button"
                                                                                    id="mainProductImage"
                                                                                    rel="productImages"
                                                                                    href="{{ asset('assets/front/img/' . $chequeList->img) }}"><img
                                                                                        src="{{ asset('assets/front/img/' . $chequeList->img) }}"
                                                                                        alt="Laser Cheques / Computer Cheques on top"
                                                                                        title=" Laser Cheques / Computer Cheques on top "
                                                                                        width="100" height="80"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="owl-nav disabled">
                                                                    <div class="owl-prev disabled"><i
                                                                            class="fa fa-chevron-left"></i></div>
                                                                    <div class="owl-next disabled"><i
                                                                            class="fa fa-chevron-right"></i></div>
                                                                </div>
                                                                <div class="owl-dots disabled">
                                                                    <div class="owl-dot active"><span></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br class="clearBoth">
                            </form>
                            <div class="modal fade" id="reorder" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                Reorder</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <form id="reorderForm" action="{{ url('reorder') }}" method="POST">
                                                        @csrf
                                                        <!-- eof Form start-->
                                                        <div class="form-group">
                                                            <label for="quantity">Select
                                                                Quantity</label>
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 100%; margin-left: 0px;">
                                                                            <select name="quantity" id="quantity"
                                                                                class="form-control" required
                                                                                onchange="updateTotalAmount()">
                                                                                <option value="65" data-quantity="0"
                                                                                    selected>
                                                                                    Please Select
                                                                                    Quantity - Free
                                                                                    shipping within
                                                                                    ON &amp; QC
                                                                                </option>
                                                                                <option value="21" data-quantity="50"
                                                                                    data-price="69">
                                                                                    50 ( +$69.00 )
                                                                                </option>
                                                                                <option value="22" data-quantity="100"
                                                                                    data-price="79">
                                                                                    100 ( +$79.00 )
                                                                                </option>
                                                                                <option value="23" data-quantity="250"
                                                                                    data-price="139">
                                                                                    250 ( +$139.00 )
                                                                                </option>
                                                                                <option value="175" data-quantity="500"
                                                                                    data-price="169">
                                                                                    250 + 250 Cheque
                                                                                    Envelopes ★ Sale
                                                                                    ★ ( +$169.00 )
                                                                                </option>
                                                                                <option value="24" data-quantity="500"
                                                                                    data-price="219">
                                                                                    500 ( +$219.00 )
                                                                                </option>
                                                                                <option value="25"
                                                                                    data-quantity="1000" data-price="319">
                                                                                    1000 ★ BEST
                                                                                    SELLER ★ (
                                                                                    +$319.00 )
                                                                                </option>
                                                                                <option value="276"
                                                                                    data-quantity="2000" data-price="429">
                                                                                    1000 + 1000
                                                                                    Cheque
                                                                                    Envelopes ★ Sale
                                                                                    ★ ( +$429.00 )
                                                                                </option>
                                                                                <option value="26"
                                                                                    data-quantity="2000" data-price="479">
                                                                                    2000 ( +$479.00
                                                                                    )
                                                                                </option>
                                                                                <option value="27"
                                                                                    data-quantity="2500" data-price="539">
                                                                                    2500 ( +$539.00
                                                                                    )
                                                                                </option>
                                                                                <option value="28"
                                                                                    data-quantity="3000" data-price="599">
                                                                                    3000 ( +$599.00
                                                                                    )
                                                                                </option>
                                                                                <option value="29"
                                                                                    data-quantity="4000" data-price="759">
                                                                                    4000 ( +$759.00
                                                                                    )
                                                                                </option>
                                                                                <option value="30"
                                                                                    data-quantity="5000" data-price="929">
                                                                                    5000 ( +$929.00
                                                                                    )
                                                                                </option>
                                                                                <option value="64"
                                                                                    data-quantity="10000"
                                                                                    data-price="1499">
                                                                                    10,000 (
                                                                                    +$1,499.00 )
                                                                                </option>
                                                                                <option value="244"
                                                                                    data-quantity="15000"
                                                                                    data-price="1799">
                                                                                    15000 (
                                                                                    +$1,799.00 )
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cheque_start_number">Cheque Start
                                                                Number</label>
                                                            <input type="text" class="form-control"
                                                                id="cheque_start_number" name="cheque_start_number"
                                                                placeholder="Cheque Start Number" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cheque_last_number">Cheque End
                                                                Number</label>
                                                            <input type="text" class="form-control"
                                                                id="cheque_last_number" name="cheque_last_number"
                                                                placeholder="Cheque End Number" required>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancle</button>
                                            <button type="button" class="btn btn-primary" id="submitReorderForm"
                                                onclick="return check_account_num();">Place
                                                Re-Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Show alert if user is not logged in -->
                            <script>
                                window.onload = function() {
                                    if (!{{ auth()->check() ? 'true' : 'false' }}) {
                                        let alertDiv = document.createElement('div');
                                        alertDiv.style.position = 'fixed';
                                        alertDiv.style.top = '20%';
                                        alertDiv.style.left = '50%';
                                        alertDiv.style.transform = 'translate(-50%, -50%)';
                                        alertDiv.style.padding = '20px';
                                        alertDiv.style.backgroundColor = '#f8d7da';
                                        alertDiv.style.border = '1px solid #f5c6cb';
                                        alertDiv.style.color = '#721c24';
                                        alertDiv.style.zIndex = '9999';
                                        alertDiv.style.width = '300px';
                                        alertDiv.style.textAlign = 'center';
                                        alertDiv.innerHTML = `
                        <h4>You need to login first!</h4>
                        <p>Please log in to proceed.</p>
                        <button id="loginButton" class="btn btn-primary">Login</button>
                    `;

                                        document.body.appendChild(alertDiv);

                                        // Add click event to login button to redirect to login page
                                        document.getElementById('loginButton').onclick = function() {
                                            window.location.href = '{{ route('login') }}';
                                        };
                                    }
                                };
                            </script>
                        @endif
                        <!--eof Form close-->
                        <div class="clearBoth"></div>
                    </div>
                    <style>
                        .fancybox-outer {
                            overflow-x: scroll;
                            overflow-y: hidden;
                        }

                        .fancybox-inner {
                            min-width: 700px;
                        }
                    </style>
                </div>
                <!-- top-inr-part -->
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function toggleFileInput() {
                var selectBox = document.getElementById('voided_cheque');
                var fileUploadField = document.getElementById('file-upload-field');
                var hideFields = document.getElementsByClassName('hide_class'); // Corrected method

                if (selectBox.value === 'upload') {
                    fileUploadField.style.display = 'block';
                    // Hide elements with class 'hide'
                    for (var i = 0; i < hideFields.length; i++) {
                        hideFields[i].style.display = 'none';
                    }
                } else {
                    fileUploadField.style.display = 'none';
                    // Show elements with class 'hide'
                    for (var i = 0; i < hideFields.length; i++) {
                        hideFields[i].style.display = 'block';
                    }
                }
            }




            $(document).ready(function() {
                // Function to validate account numbers
                function validateAccountNumbers() {
                    var accountNumber = $('#account_number').val();
                    var confirmAccountNumber = $('#confirm_account_number').val();
                    var errorMessage = $('#error-message');

                    if (accountNumber !== confirmAccountNumber) {
                        errorMessage.show();
                    } else {
                        errorMessage.hide();
                    }
                }

                // Attach the function to the input event on the confirm_account_number field
                $('#confirm_account_number').on('input', function() {
                    validateAccountNumbers();
                });
            });


            // document.getElementById('institution_number').addEventListener('input', function(e) {
            //     var value = e.target.value;
            //     if (!/^\d{0,3}$/.test(value)) {
            //         e.target.value = value.replace(/\D/g, ''); // Remove non-digit characters
            //     }
            // });



            // document.getElementById('transit_number').addEventListener('input', function(e) {
            //     var value = e.target.value;
            //     if (!/^\d{0,5}$/.test(value)) {
            //         e.target.value = value.replace(/\D/g, ''); // Remove non-digit characters
            //     }
            // });


            //reorder
            document.getElementById('customer_id').addEventListener('change', function() {
                var customerId = this.value;
                var reorderButton = document.getElementById('reorder-button');
                var allFields = document.querySelectorAll('.field-to-hide'); // Use a common class for fields to hide

                if (customerId) {
                    fetch(`/check-orders/${customerId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.hasOrders) {
                                reorderButton.style.display = 'block';
                                allFields.forEach(function(field) {
                                    field.style.display = 'none'; // Hide all fields
                                });
                                reorderButton.dataset.customerId = customerId; // Store customer ID for reorder
                            } else {
                                reorderButton.style.display = 'none';
                                allFields.forEach(function(field) {
                                    field.style.display = 'block'; // Show all fields if no orders
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            reorderButton.style.display = 'none';
                            allFields.forEach(function(field) {
                                field.style.display = 'block'; // Show all fields in case of error
                            });
                        });
                } else {
                    reorderButton.style.display = 'none';
                    allFields.forEach(function(field) {
                        field.style.display = 'block'; // Show all fields if no customer selected
                    });
                }
            });

            //preview 

            document.addEventListener('DOMContentLoaded', function() {
                // Handle preview button click
                document.getElementById('previewButton').addEventListener('click', function() {
                    // Get form values
                    document.getElementById('previewCustomerID').innerText = document.getElementById(
                        'customer_id').value;
                    document.getElementById('previewQuantity').innerText = document.getElementById('quantity')
                        .value;

                    // Get the selected color radio button value
                    const selectedColor = document.querySelector('input[name="color"]:checked');
                    if (selectedColor) {
                        document.getElementById('previewColor').innerText = selectedColor.value;
                    }

                    document.getElementById('previewCompanyInfo').innerText = document.getElementById(
                        'attrib-21-0').value;
                    document.getElementById('previewInstitutionNumber').innerText = document.getElementById(
                        'institution_number').value;
                    document.getElementById('previewTransitNumber').innerText = document.getElementById(
                        'transit_number').value;
                    document.getElementById('previewAccountNumber').innerText = document.getElementById(
                        'account_number').value;
                    document.getElementById('previewChequeStartNumber').innerText = document.getElementById(
                        'attrib-28-0').value;
                    document.getElementById('previewChequeEndNumber').innerText = document.getElementById(
                        'cheque_end_number').value;
                    document.getElementById('previewCartQuantity').innerText = document.getElementById(
                        'cart_quantity').value;
                    document.getElementById('previewChequeCategoryID').innerText = document.getElementById(
                        'cheque_category_id').value;
                    document.getElementById('previewVendorID').innerText = document.getElementById('vendor_id')
                        .value;

                    // Handle file previews
                    previewFile('attrib-31-0', 'voidedChequeFilePreview', 'previewVoidedChequeFile');
                    previewFile('company_logo', 'companyLogoPreview', 'previewCompanyLogo');
                    previewFile('cheque_img', 'chequeImgPreview', 'previewChequeImg');
                });

                // Function to preview file
                function previewFile(inputId, imgId, previewSectionId) {
                    const fileInput = document.getElementById(inputId);
                    const file = fileInput.files[0];
                    const preview = document.getElementById(imgId);
                    const previewSection = document.getElementById(previewSectionId);

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            previewSection.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        previewSection.style.display = 'none';
                    }
                }
            });


            //reorder
            let customerId; // Declare a global variable

            // Capture customerId when the 'reorder-button' is clicked
            document.getElementById('reorder-button').addEventListener('click', function() {
                customerId = this.dataset.customerId; // Set customerId globally
            });

            $(document).ready(function() {
                $('#submitReorderForm').click(function(event) {
                    event.preventDefault(); // Prevent default form submission
                    // Ensure customerId is set
                    if (!customerId) {
                        alert('Customer ID not found.');
                        return;
                    }

                    // Collect form data
                    var formData = {
                        _token: $('input[name=_token]').val(), // Add CSRF token
                        quantity: $('#quantity').val(),
                        cheque_start_number: $('#cheque_start_number').val(),
                        cheque_end_number: $('#cheque_last_number').val(),
                    };
                    console.log(formData);

                    $.ajax({
                        url: "{{ url('reorder') }}/" + customerId, // Append customerId to the URL
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            // Handle success response here
                            alert('Reorder placed successfully!');
                            // Close the modal
                            $('#reorder').modal('hide');
                            window.location.href = "{{ route('success') }}";
                        },
                        error: function(xhr, status, error) {
                            // Handle error response here
                            console.log(xhr.responseText);
                            alert('An error occurred. Please try again.');
                        }
                    });
                });
            });
        </script>
        <!-- row -->
    </section>
@endsection
