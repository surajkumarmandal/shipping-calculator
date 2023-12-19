$(document).ready(function() {
	let shippingCartList = localStorage.getItem('shippingCart');
	if (shippingCartList) {
		let itemTypeSelcted = localStorage.getItem('itemTypeSelcted');
		if(itemTypeSelcted) {
			let cartDataList = JSON.parse(shippingCartList);
			$('.totalCartItem').attr('data-count', cartDataList.length)
			showItemCart(cartDataList, itemTypeSelcted, true);
		}
	}
	
    let destination_country = [];
	//const apiUrl = "<?= esc_url_raw(rest_url('/shipping-calculator/countries/v1')); ?>";

	// Make AJAX call when the DOM is ready
	$.ajax({
		url: apiUrl + '/countries', // URL of the custom API endpoint
		type: 'GET',
		success: function(response) {
			// Handle the API response
			destination_country = response;
			if (destination_country.length > 0) {
				let option = '<option value="">Select Countries</option>';
				response.forEach(item => {
					option += `<option value="${item.id}">${item.destination_countries}</option>`
				});
				$('#countries,#destinationCountriesTo').html(option);
			}
			// You can use the data as needed in your admin panel
		},
		error: function(error) {
			console.error('Error making AJAX request:', error);
		}
	});
	let itemNumeber = 0;
	var forms = document.getElementsByClassName('needs-validation');
	// Loop over them and prevent submission
	var validation = Array.prototype.filter.call(forms, function(form) {
		$(document).on('click', '.updateButtonSubmit', function(event) {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();

			} else {

				$('#addressDetails').hide();
                $('.editForm').show();
                
				
                let destinationCountriesTo = destination_country.filter(item => item.id === $('#destinationCountriesTo').val())[0];
               
                let isResidentialAddressTo = $("#residentialAddressTo").is(":checked");
                let cityTo = $('#cityTo').val();
                let postalCodeTo = $('#postalCodeTo').val();
                $('#shippinTo').html(`${cityTo}, ${postalCodeTo} ${destinationCountriesTo.destination_countries}`);
                $('#shippinToType').html(isResidentialAddressTo ? $('#residentialAddressTo').val() : 'Commercial');
               

                let destinationCountriesForm = destination_country.filter(item => item.id === $('#countries').val())[0];
            
                let isResidentialAddressForm = $("#residentialAddress").is(":checked");
                let cityForm = $('#city').val();
                let postalCodeForm = $('#postalCode').val();
                $('#shippinForm').html(`${cityForm}, ${postalCodeForm} ${destinationCountriesForm.destination_countries}`);
                $('#shippinFormType').html(isResidentialAddressForm ? $('#residentialAddress').val() : 'Commercial');

                let shippingDate = new Date($('#shippingDateValue').val());
                let shippingDateFormat = moment.utc(shippingDate).format("dddd, LL");
                $('#shippinDate').html(`${shippingDateFormat}`);
                
                
				$('#weightDetails, #submitDetails, .shiping-address').show();
				event.preventDefault();
				event.stopPropagation();
			}
			form.classList.add('was-validated');
		});
	});
	$(document).on('keyup', '.item-box-input', function(e) {
		if (/\D/g.test(this.value)) {
			// Filter non-digits from input value.
			this.value = this.value.replace(/\D/g, '');
		}
	});
	
	$('#sandbox-container .input-group.date').datepicker({
		autoclose: true,
		startDate: new Date()
	});


	$('#destinationCountriesTo').change(function() {

		let selected_country = $('#destinationCountriesTo').val();

		let service_type_list = destination_country.find(item => item.id === selected_country);
		let service_type = service_type_list.service_type.split(',');
		let service_type_option = '<option value="">Select Service type</option>';
		service_type.forEach(item => {
			service_type_option += `<option value="${item}">${item}</option>`
		});
		$('#service_type').html(service_type_option);
	})

	$(document).on("click", '.btnAdd', function() {
		addItem(itemNumeber)

		itemNumeber++;
	})
	$(document).on("click", ".btnDelete", function() {
		let dataId = $(this).data('id');
        $(`#error-messgage-${dataId}`).remove();
		$(`#input-ds-bx${dataId}`).remove();
		itemNumeber--;

	});
	let weightDetailsobjArry = [];
	$(document).on('click', '.buttonSubmit', function() {


		let formValue = $(".shipping-calculator-form").serializeArray();

		let shippingValue = {};
		let shippingDetails = $("#weightDetails :input").serializeArray();
		let isValid = true;
		
		let weightDetailsObj = {};
		let itemTypeSelcted =  $('#itemType').val();
		if (itemTypeSelcted !== 'single') {
			weightDetailsobjArry = [];
		}
		console.log(weightDetailsObj)
		for (let i = 0; i < shippingDetails.length; i++) {
			const input = $(`#${shippingDetails[i].name}`);
			const errorMessage = $(`#error-messgage-${shippingDetails[i].name}`);

			if (!input.val()) {
				isValid = false;
				if (shippingDetails[i].name.includes('width')) {
					errorMessage.text("Width is required.");
				} else if (shippingDetails[i].name.includes('height')) {
					errorMessage.text("Height is required.");
				} else {
					errorMessage.text("This field is required.");
				}
				errorMessage.show();
				errorMessage.addClass("is-invalid");
				input.addClass("is-invalid"); // Add error class for styling
			} else {
				if(itemTypeSelcted !== 'single') {
					if (!!shippingDetails[i].name.includes('width') ) {
						weightDetailsObj['width'] = shippingDetails[i].value;
					} else if (!!shippingDetails[i].name.includes('height')) {
						weightDetailsObj['height'] = shippingDetails[i].value;
					} else if (!!shippingDetails[i].name.includes('depth')) {
						weightDetailsObj['depth'] = shippingDetails[i].value;
					}
				}
				errorMessage.hide();
				errorMessage.removeClass("is-invalid");
				input.removeClass("is-invalid"); // Remove error class
			}
			if (Object.keys(weightDetailsObj).length === 3) {
				weightDetailsobjArry.push(weightDetailsObj);
				weightDetailsObj = {};
			}
		}
		const packagingTypeListSRValue = $('#packagingTypeListSR').val();
		
		const errorWeightMessage = $(`#error-messgage-weight`);
		console.log("weightDetailsobjArry", weightDetailsobjArry)
		let weightError = [];
		weightDetailsobjArry.forEach(item => {
			
			let weigthCal = 0;
			if (!!item.width && !!item.height && !!item.depth) {
				weigthCal = ((Number(item.width) * Number(item.height) * Number(item.depth)) / 165);
			}

			
			if(itemTypeSelcted === 'single') {
				if (weigthCal && ( weigthCal > packagingTypeListSRValue)) {
					isValid = false;
					errorWeightMessage.text(`SORRY BUT WE ARE NOT ABLE TO CARRY BOXES HEAVIER THAN ${packagingTypeListSRValue} POUNDS! CALL US TO HELP YOU FIND AVAILABLE OPTIONS`);
					errorWeightMessage.show();
				} else {
					isValid = true;
				}
			} else {
				console.log('weigthCal', item, weigthCal, isValid)
				weightError.push(weigthCal)
				if (weigthCal > 50) {
					errorWeightMessage.text("SORRY BUT WE ARE NOT ABLE TO CARRY BOXES HEAVIER THAN 50 POUNDS! CALL US TO HELP YOU FIND AVAILABLE OPTIONS");
					errorWeightMessage.show();
				}
			}
			
		});
		if(itemTypeSelcted !== 'single') {
			if(weightError.length > 0 && weightError.findIndex(weigthValue => typeof weigthValue === 'object' || weigthValue > 50) !== -1) {
				isValid = false;
			} else if (weightError.length === 0 ) {
				isValid = false;
			} else {
				isValid = true;
			}
		}
		if (isValid || itemTypeSelcted === 'single') {
			errorWeightMessage.text('');
			errorWeightMessage.hide();
			formValue.forEach(item => {
				if (item.name !== "width" || item.name !== "height" || item.name !== "weight") {
					shippingValue[item.name] = item.value;
				}

			});
			if(itemTypeSelcted !== 'single') {
				shippingValue['shippingDetails'] = weightDetailsobjArry;
			}
			
			$.ajax({
				url: apiUrl + '/shipping-form', // URL of the custom API endpoint
				type: 'POST',
				data: shippingValue,
				success: function(response) {
					// Handle the API response
					console.log(response);
					localStorage.setItem('shippingCart' , JSON.stringify(response));
					localStorage.setItem('itemTypeSelcted' , itemTypeSelcted);
					
					showItemCart(response, itemTypeSelcted);
				 
				},
				error: function(error) {
					console.error('Error making AJAX request:', error);
				}
			});
		}
	})
	$(document).on('keyup', '.item-box-input', function() {
		let dataId = $(this).data('id');
		const input = $(`#${dataId}`);
		const errorMessage = $(`#error-messgage-${dataId}`);
		if (!input.val() || input.val() <= 0) {
			if (dataId.includes('width')) {
				errorMessage.text("Width is required.");
			} else if (dataId.includes('height')) {
				errorMessage.text("Height is required.");
			} else {
				errorMessage.text("This field is required.");
			}
			errorMessage.show();
			errorMessage.addClass("is-invalid");
			input.addClass("is-invalid"); // Add error class for styling
		} else {
			errorMessage.hide();
			errorMessage.removeClass("is-invalid");
			input.removeClass("is-invalid"); // Remove error class
		}
	})

	function addItem(item, edit=true) {
		let templatehtml = `<div class="row">
                    <div class="col-md-12">
                    <div class="input-element" id="input-ds-bx${item}" data-id="${item}">
                        <div class="form-group box-input">
                            <label for="height${item}"> Height</label>
                            <input type="text" maxlength="2" class="form-control item-box-input box-input2" id="height${item}" value="" name="height${item}" data-id="height${item}">
                        </div>
                        <div class="form-group box-add">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="form-group box-input">
                            <label for="Width${item}"> Width </label>
                            <input type="text"  maxlength="2" class="form-control item-box-input box-input1" id="width${item}" value="" name="width${item}" data-id="width${item}">
                        </div>
                        <div class="form-group box-add">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="form-group box-input">
                            <label for="depth${item}"> Depth</label>
                            <input type="text"  maxlength="2" class="form-control item-box-input box-input3" id="depth${item}" value="" name="depth${item}" data-id="depth${item}">
                        </div>
                     `;

		if (item !== 0) {
			templatehtml += `<button type="button" class="btn btnDelete" id="btnDelete${item}" data-id="${item}">
                      <i class="fa fa-minus text-danger"></i>
                    </button>
                    <button type="button" class="btn btnAdd" id="btnAdd${item}" data-id="${item}">
                      <i class="fa fa-plus text-primary"></i>
                    </button>
                  </div>
                  </div>
                  <div class="col-md-12" id="error-messgage-${item}">
                        <p class="error-message-details" id="error-messgage-height${item}"></p>
                        <p class="error-message-details" id="error-messgage-width${item}"></p>
                        <p class="error-message-details" id="error-messgage-depth${item}"></p>
                    </div>
                </div>
                  `;
		} else {
            if (edit === true) {
                templatehtml += `
                <button type="button" class="btn btnAdd" id="btnAdd${item}" data-id="${item}">
                  <i class="fa fa-plus text-primary"></i>
                </button>
                </div>
                </div>
                <div class="col-md-12" id="error-messgage-${item}">
                        <p class="error-message-details" id="error-messgage-height${item}"></p>
                        <p class="error-message-details" id="error-messgage-width${item}"></p>
                        <p class="error-message-details" id="error-messgage-depth${item}"></p>
                    </div>
                    </div>`;
            } else {
                templatehtml += `
                </div>
                </div>
                <div class="col-md-12" id="error-messgage-${item}">
                        <p class="error-message-details" id="error-messgage-height${item}"></p>
                        <p class="error-message-details" id="error-messgage-width${item}"></p>
                        <p class="error-message-details" id="error-messgage-depth${item}"></p>
                    </div>
                    </div>`;
            }
			
		}
		$('.box-details-element-item').append(templatehtml);
	}
 

    $('.editForm').click(function (){
        $('.shiping-address , .box-details-element, .weight-error-message-details, #submitDetails').hide();
        $('#addressDetails').show();
        $('.editForm').hide();
    })

    $('#itemType').change(function(){
		$('.totalCartItem').attr('data-count', 0)
		weightDetailsobjArry = [];
		const errorWeightMessage = $(`#error-messgage-weight`);
        let itemNoValue = $(this).val();
        if(itemNoValue === 'single') {
            $('.packagingTypeList').show();
            $('.calculateSize').show();
            $('.box-details-element-item').empty();
            itemNumeber = 0;
        } else {
            itemNumeber = 0;
            $('.box-details-element-item').empty();
            $('.packagingTypeList').hide();
            $('.calculateSize').hide();
			errorWeightMessage.text('');
			errorWeightMessage.hide();
            if (itemNumeber === 0) {
                addItem(0);
                itemNumeber++;
            }
        }
    })

    $(document).on('click', '.calculateSize', function(){
        itemNumeber = 0;
        addItem(0, false);
    })

	function showItemCart(responseItem, itemTypeSelcted, isAddToCart=false) {
		$('#parcel_send_calculated').html('');
		let totalPrice = 0;
		for (let i = 0; i < responseItem.length; i++) {
			let addCardDeleteBtn = isAddToCart ? `<a href="javascript:void(0)" class="deleteaddToCard" data-id="${i}"><i class="fa fa-trash-o" style="font-size:30px;color:red"></i></a>` : '';
			let costDetailsCal = `<tr>
				<td>${addCardDeleteBtn}</td><td>${responseItem[i].shippingData.service_type} <br> Latest Pickup Time: ${moment.utc(new Date(responseItem[i].shippingData.shippingDateValue)).format("dddd, LL")}<br> Schedule by : ${moment.utc(new Date(responseItem[i].shippingData.shippingDateValue)).format("dddd, LL")}</td>
				<td>Days In Transit : Delivered By: <br><b>Total Weight:</b> ${itemTypeSelcted !== 'single' ? responseItem[i].totalWeight.toFixed(2) : responseItem[i].totalWeight} Pound</td>
				<td><img src="${responseItem[i].parcel_file_url}" height="50" width="50"><br>$${responseItem[i].totalCost.toFixed(2)}</td>
			</tr>
			`;
			totalPrice +=  Number(responseItem[i].totalCost.toFixed(2));
			
			$('#parcel_send_calculated').append(costDetailsCal);
		}
		if (totalPrice > 0) {
			$('.totalPrice').html(`<b>Total:</b> $${totalPrice}<br><button type="button" class="btn btn-primary payNow">Check out</button>`);
		} else {
			$('.totalPrice').html('');
		}
		
	}

	$(document).on('click', '.deleteaddToCard', function (){
		let cartId = $(this).data('id');
		let shippingCartList = localStorage.getItem('shippingCart');
		let cartDataList = JSON.parse(shippingCartList);
		cartDataList.splice(cartId, 1);
		$('.totalCartItem').attr('data-count', cartDataList.length)
		localStorage.setItem('shippingCart',JSON.stringify(cartDataList));
		let itemTypeSelcted = localStorage.getItem('itemTypeSelcted');
		showItemCart(cartDataList, itemTypeSelcted, true);
	})

});