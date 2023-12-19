<!-- Design Shipping Calculator Form Template -->
<div class="custom-form-container container-box-main row">
  <div class="first-div col-md-5">
    <div class="table">
      <div class="form1">
        <form method="POST" action="javascript:void(0);" class="needs-validation shipping-calculator-form" novalidate>
          <div class="container-box" id="addressDetails">
            <div class="where">
              <h1> 1. where and when ?</h1>
            </div>
            <h4>Ship From</h4>
            <div class="form-group">
              <label for="country">Country or Territory </label>
              <select class="form-control" id="countries" name="countries" required></select>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="input-element">
              <div class="form-group w-100">
                <label for="city"> City*</label>
                <input type="text" class="form-control" id="city" value="" name="formCity" required>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="imgd">
                <i class="fa fa-search"></i>
              </div>
            </div>
            <div class="input-element">
              <div class="form-group">
                <label for="postalCode"> ZIP Code*</label>
                <input type="text" class="form-control" id="postalCode" value="" name="postalCode" required>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="imgd">
                <i class="fa fa-search"></i>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="residentialAddress" name="residentialAddress" value="Residential Address">
                <label class="form-check-label" for="residentialAddress">Residential Address</label>
              </div>
            </div>
            <hr class="ship-to-hr">
            <h4>Ship To</h4>
            <div class="form-group">
              <label for="countryTo">Destination Country</label>
              <select class="form-control" id="destinationCountriesTo" name="countriesTo" required></select>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="input-element">
              <div class="form-group w-100">
                <label for="cityTo"> City*</label>
                <input type="text" class="form-control" id="cityTo" value="" name="cityTo" required>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="imgd">
                <i class="fa fa-search"></i>
              </div>
            </div>
            <div class="input-element">
              <div class="form-group">
                <label for="postalCodeTo"> ZIP Code*</label>
                <input type="text" class="form-control" id="postalCodeTo" value="" name="postalCodeTo" required>
                <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="imgd">
                <i class="fa fa-search"></i>
              </div>
            </div>
            <div class="form-group service_type_element">
              <label for="service_type"> Service Type </label>
              <select class="form-control" id="service_type" name="service_type" required></select>
              <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <label for="radio">Destination Type: </label>
            <br>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="residentialAddressTo" name="residentialAddressTo" value="Residential Address">
                <label class="form-check-label" for="residentialAddressTo">Residential Address</label>
              </div>
            </div>
            <label for="calendar">When are you shipping? </label>
            <div id="sandbox-container" class="sandbox-container-date">
              <div class="input-group date">
                <input type="text" class="form-control" name="shippingDateValue" id="shippingDateValue" required>
                <span class="input-group-addon">
                  <i class="fa fa-calendar calender__icon"></i>
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col d-flex justify-content-between buttonm">
                <button type="submit" name="clearButton" class="btn float-left clearb clearButtonSubmit">Clear</button>
                <input type="submit" name="updateButton" class="btn updateb float-right updateButtonSubmit" value="Update">
              </div>
            </div>
          </div>
          <div class="container-box" id="myDiv">
            <div class="where">
              <h1>2. Enter Detail to Show Cost <span class="editForm"><i class="fa fa-pencil"></i></span></h1>
              
            </div>
            <div class="where-box">
              <div class="shiping-address" style="display:none">
                <div class="row">
                  <div class="col-sm-12 shipping-info">
                    <h3>Ship To:</h3>
                    <p id="shippinTo"></p>
                    <p id="shippinToType"></p>
                  </div>
                  <div class="col-sm-12 shipping-info">
                    <h3>Ship From:</h3>
                    <p id="shippinForm"></p>
                    <p id="shippinFormType"></p>
                  </div>
                  <div class="col-sm-12 shipping-info">
                    <h3>Shipment Date:</h3>
                    <p id="shippinDate"></p>
                  </div>
                </div>
                <hr>
              </div>
              <div class="box-details box-details-element" id="weightDetails" style="display:none">
                <div class="form-group">
                  <label for="itemType">Select No. of Item </label>
                  <select class="form-control shipping-dropdown" id="itemType" name="itemType">
                    <option value="single">Single</option>
                    <option value="multiple">Multiple</option>
                  </select>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                
                <div class="form-group packagingTypeList">
                  <label for="packagingTypeListSR">Select a Simple Rate Size</label>
                  <select name="containerSR" class="shipping-dropdown form-control" id="packagingTypeListSR">
                    <option value="10">Extra Small - 1 to 10 pound. </option>
                    <option value="20">Small - 11 to 20 pound. </option>
                    <option value="30">Medium - 21 to 30 pound. </option>
                    <option value="40">Large - 31 to 40 pound. </option>
                    <option value="50">Extra Large - 41 to 50 pound. </option>
                  </select>
                </div>
                <a href="javascript:void(0)" class="calculateSize">Help me calculate my size?</a>
                <div class="box-details-element-item">

                </div>
              </div>
              
              <p class="weight-error-message-details" style="display:none" id="error-messgage-weight"></p>
              <div class="row" id="submitDetails" style="display:none">
                <div class="col d-flex justify-content-between buttonm">
                  <button type="submit" name="clearButton" class="btn float-left clearb">Clear</button>
                  <input type="button" name="updateButton" class="btn updateb float-right buttonSubmit" value="Update">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="second-div col-md-7">
    <div class="container-box second-container-box">
      <div class="box1">
        
        <div>
          <p>Showing Results For: </p>
          <p>Spain to United States</p>

          <span class="totalCartItem" data-count="0">
            <svg  class="addtoCartLogo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
            <defs>
            </defs>
            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
              <path d="M 72.975 58.994 H 31.855 c -1.539 0 -2.897 -1.005 -3.347 -2.477 L 15.199 13.006 H 3.5 c -1.933 0 -3.5 -1.567 -3.5 -3.5 s 1.567 -3.5 3.5 -3.5 h 14.289 c 1.539 0 2.897 1.005 3.347 2.476 l 13.309 43.512 h 36.204 l 10.585 -25.191 h -6.021 c -1.933 0 -3.5 -1.567 -3.5 -3.5 s 1.567 -3.5 3.5 -3.5 H 86.5 c 1.172 0 2.267 0.587 2.915 1.563 s 0.766 2.212 0.312 3.293 L 76.201 56.85 C 75.655 58.149 74.384 58.994 72.975 58.994 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
              <circle cx="28.88" cy="74.33" r="6.16" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
              <circle cx="74.59" cy="74.33" r="6.16" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
              <path d="M 62.278 19.546 H 52.237 V 9.506 c 0 -1.933 -1.567 -3.5 -3.5 -3.5 s -3.5 1.567 -3.5 3.5 v 10.04 h -10.04 c -1.933 0 -3.5 1.567 -3.5 3.5 s 1.567 3.5 3.5 3.5 h 10.04 v 10.04 c 0 1.933 1.567 3.5 3.5 3.5 s 3.5 -1.567 3.5 -3.5 v -10.04 h 10.041 c 1.933 0 3.5 -1.567 3.5 -3.5 S 64.211 19.546 62.278 19.546 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            </g>
            </svg>
          </span>
        </div>
      </div>
      <div class="box">
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Service</th>
              <th>Time</th>
              <th>Cost</th>
            </tr>
          </thead>
          <tbody id="parcel_send_calculated">
           
            
          </tbody>
          <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="totalPrice"></td>
          </tr>
        </tfoot>
        </table>
      </div>
    </div>
    <div class="div-p">
      <p>Result estimates calculated by UPS: Monday, December 11, 2023 5:41 A.M. Eastern Time (USA) Guarantees and Notices</p>
    </div>
  </div>
</div>
<script type="text/javascript">
    const apiUrl = "<?= esc_url_raw(rest_url('/shipping-calculator/countries/v1')); ?>";
</script>
