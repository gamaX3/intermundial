$(function(){
	var listt = [];
	$("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        transitionEffectSpeed: 300,
        labels: {
            next: "Next",
            previous: "Back"
        },
				onFinishing: function(event, currentIndex){
					console.log('sfsf');
					var cdb = $('.itemseleccionado').attr("id");
					console.log(cdb);
					console.log(listt);

					$.ajax({
							url: "intermundial.php",
							type: 'POST',
							headers: {
									"content-type": "application/x-www-form-urlencoded"
							},
							data: {
								"type": "confirm",
								"init": $('#dinit').val(),
								"end": $('#dend').val(),
								"product": $('#product').val(),
								"sellContract": $('#sellContract').val(),
								"sellTariff": $('#sellTariff').val(),
								"sellPriceSheet": $('#sellPriceSheet').val(),
								"modality": cdb,
								"adultNumber": 1,
								"name": $('#name').val(),
								"surname": $('#surname').val(),
								"age": $('#age').val()
							},
							dataType: "json",
							error: function(xhr, status, error) {
								console.log(xhr.responseText);
								$alert(xhr.responseText);
							},
							success: function(res) {
									console.log(res);
									
							}
					});



				},
        onStepChanging: function (event, currentIndex, newIndex) {
					console.log(currentIndex, newIndex);
					if(currentIndex == 1 && newIndex == 2){
						var cdb = $('.itemseleccionado').attr("id");
						console.log(cdb);
					}

					if(currentIndex == 0 && newIndex == 1){
						console.log('pppooo', $('#dinit').val() , $('#dend').val() );
						if(!$('#dinit').val() || !$('#dend').val()){
							console.log('ingresar fecha de inicio y fecha final');
							return false;
						}


						$('.payment-block').html('<p>Obteniendo datos ... </p>');

						$.ajax({
				        url: "intermundial.php",
				        type: 'POST',
								headers: {
				            "content-type": "application/x-www-form-urlencoded"
				        },
				        data: {
									"type": "getPrices",
				          "init": $('#dinit').val(),
				          "end": $('#dend').val()
				        },
				        dataType: "json",
								error: function(xhr, status, error) {
									console.log(xhr.responseText);
									$('.payment-block').html('<center style="color: red;">'+xhr.responseText+'</center>');
								},
								success: function(res) {
				            console.log(res);
										console.log(res.msg.availableProducts.varietyCombinations.varietyDistributions.priceInfo);
				            //alert(res);
										var jtm = '';
										$.each(res.msg.availableProducts.varietyCombinations.varietyDistributions.priceInfo,function ( index, repo ) {
												jtm = jtm+ `
													<div class="payment-item" id="${repo.modality.code}">
															<div class="payment-logo">
																	${repo.currencyCode}
															</div>
															<div class="payment-content">
																	<p>$ ${repo.price} ${repo.currencyCode}</p>
																	<p>${repo.modality.shortName}</p>
															</div>
													</div>
				                    `;
				            });

										$('.payment-block').html(jtm);
				        }
				    });
					}else{

					}

					if ( newIndex === 1 ) {
							$('.steps').addClass('step-2');
					} else {
							$('.steps').removeClass('step-2');
					}

					if ( newIndex === 2 ) {
							$('.steps').addClass('step-3');
					} else {
							$('.steps').removeClass('step-3');
					}
					return true;


        }
    });
    // Custom Jquery Steps
    $('.forward').click(function(){
    	$("#wizard").steps('next');
    })
    $('.backward').click(function(){
        $("#wizard").steps('previous');
    })
    // Select
    $('html').click(function() {
        $('.select .dropdown').hide();
    });
    $('.select').click(function(event){
        event.stopPropagation();
    });
    $('.select .select-control').click(function(){
        $(this).parent().next().toggle().toggleClass('active');
    })
    $('.select .dropdown li').click(function(){
        $(this).parent().toggle();
        var text = $(this).attr('rel');
        $(this).parent().prev().find('div').text(text);
    })
    // Payment
		$(document).on('click', '.payment-block .payment-item', function(){
			$('.payment-block .payment-item').removeClass('active');
			$(this).addClass('active');

			$('.payment-block .payment-item').removeClass('itemseleccionado');
			$(this).addClass('itemseleccionado');
		});

    $('.payment-block .payment-item').click(function(){
			console.log('ddfggg');
        $('.payment-block .payment-item').removeClass('active');
        $(this).addClass('active');
    })
    // Date Picker
    var dp1 = $('#dp1').datepicker().data('datepicker');
		var dinit = $('#dinit').datepicker().data('datepicker');
		var dend = $('#dend').datepicker().data('datepicker');
})
