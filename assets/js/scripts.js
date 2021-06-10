$(document).ready(function(){

    $('#myTable').DataTable();

    function formatNumber(num) {
  		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	}

	// if (window.location.href =="component-form-wizard-NextKin.php"){alert("1");}
	var pageUrl = window.location.href.toLowerCase();
	var re = new RegExp(/^.*\//);
	var personalPage = re.exec(window.location.href)+"personal_details.php".toLowerCase();
	var contactPage = re.exec(window.location.href)+"contact_details.php".toLowerCase();
	var idPage = re.exec(window.location.href)+"identification_details.php".toLowerCase();
	var nokPage = re.exec(window.location.href)+"next_of_kin_details.php".toLowerCase();
	
	switch (pageUrl) {
		case personalPage:
			$("#personal_form").addClass("active");
			break;
		case contactPage:
			$("#contact_form").addClass("active");
			break;
		case idPage:
			$("#id_form").addClass("active");
			break;
		case nokPage:
			$("#nok_form").addClass("active");
			break;
	
		default:
			break;
	}


	$(".submit_employment_details").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		var reg_id = $("#reg_id").val();
		if(reg_id == ''){
			var location = "verify_otp";
		}else{
			var location = "verify_otp?reg_id="+reg_id;
		}
		$.ajax({
			url:"ajax/submit_employment_details.php",
			method: "POST",
			data: $("#submit_employment_details_form").serialize(),
			beforeSend: function(){
				$('.submit_employment_details').attr('disabled', true);
				$('.submit_employment_details').text('Please wait...');
			},
			success: function(data){
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Your employment details have been successfully submitted and a verification code has been sent to your email address",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = location;}, 5000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
				}
				$('.submit_employment_details').attr('disabled', false);
				$('.submit_employment_details').text('Next');
			}
		})
	});


	$("#verify_otp").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		var reg_id = $("#reg_id").val();
		if(reg_id == ''){
			var location = "financial_details";
		}else{
			var location = "financial_details?reg_id="+reg_id;
		}
		$.ajax({
			url:"ajax/verify_otp.php",
			method: "POST",
			data: $("#verify_otp_form").serialize(),
			beforeSend: function(){
				$("#verify_otp").attr("disabled", true);
				$("#verify_otp").text("Please wait...");
			},
			success: function(data){
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Your Email Address has been verified, you will be redirected soon",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = location;}, 5000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
				}
				$("#verify_otp").attr("disabled", false);
				$("#verify_otp").text("Verify");
			}
		})
	});

	$(".agree_terms_conditions").click(function(e){
		e.preventDefault();
		let id = $(this).attr('id');
		//console.log(id);
		$.ajax({
			beforeSend: function(){
				$(".agree_terms_conditions").attr("disabled", true);
				$("#button_spinner").css('display', 'block');
				$(".agree_terms_conditions").text("Please wait....");
			},
			url:"ajax/agree_terms_conditions.php",
			method: "POST",
			data: $("#agree_terms_conditions"+id).serialize(),
			success: function(data){
				if(data == "Please try again"){
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
				// else if(data == "success"){
				// 	$("#button_spinner").css("display", "none");
				// 	$(".agree_terms_conditions").text("Done");
				// 	$(".submit_loan_application").css("display", "block");
				// }
				else{
					setTimeout( function(){ window.location.href = data;}, 1000);
				}
			}
		})
	});

	// $(".submit_loan_application").click(function(e){
	// 	e.preventDefault();
	// 	let id = $(this).attr('id');
	// 	//console.log(id);
	// 	$.ajax({
	// 		beforeSend: function(){
	// 			$(".submit_loan_application").attr("disabled", "true");
	// 			$("#button_spinner").css('display', 'block');
	// 			$(".submit_loan_application").text("Please wait....");
	// 		},
	// 		url:"ajax/submit_loan_application.php",
	// 		method: "POST",
	// 		data: $("#agree_terms_conditions"+id).serialize(),
	// 		success: function(data){
	// 			if(data == "success"){
	// 				$("#success_message").empty();
	// 				$("#success_message").html("Congrats! Your loan has been disbursed and repayment details has been sent to your email address, ");
	// 				toastbox('success_toast', 3000);
	// 				setTimeout( function(){ window.location.href = "dashboard.php"}, 6000);
	// 			}
	// 			else{
	// 				$("#error_message").empty();
	// 				$("#error_message").html("Error! " + data);
	// 				toastbox('error_toast', 6000);
	// 			}
	// 			$(".submit_loan_application").attr("disabled", false);
	// 			$(".submit_loan_application").text("Get Loan");

	// 		}
	// 	})
	// });

	$("#submit_loan_application").click(function(e){
		e.preventDefault();
		let id = $(this).attr('id');
		let loan_id = $("#loan_id").val();
		//console.log(id);
		$.ajax({
			beforeSend: function(){
				$("#submit_loan_application").attr("disabled", "true");
				$("#button_spinner").css('display', 'block');
				$("#submit_loan_application").text("Submitting...");
			},
			url:"ajax/submit_loan_application.php",
			method: "POST",
			data: $("#submit_loan_application_form").serialize(),
			success: function(data){
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Your Loan will be disbursed shortly. Loan details has been sent to your mail, you will be redirected shortly",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "okra_debit_confirmation.php?loan_id="+loan_id}, 5000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
				}
				$("#submit_loan_application").attr("disabled", false);
				$("#submit_loan_application").text("Submit");
			}
		})
	});


	$("#submit_asset_finance").click(function(e){
		e.preventDefault();
		let id = $(this).attr('id');
		//console.log(id);
		$.ajax({
			beforeSend: function(){
				$("#submit_asset_finance").attr("disabled", "true");
				$("#button_spinner").css('display', 'block');
				$("#submit_asset_finance").text("Submitting...");
			},
			url:"ajax/submit_asset_finance.php",
			method: "POST",
			data: $("#submit_asset_finance_form").serialize(),
			success: function(data){
				if(data == "success"){
					var loan_id = $("#loan_id").val();
					$("#success_message").empty();
					$("#success_message").html("Success!");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "submit_guarantors.php?loan_id="+ loan_id}, 3000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
				$("#submit_asset_finance").attr("disabled", false);
				$("#submit_asset_finance").text("Submit");

			}
		})
	});


	$("#submit_loan_purpose").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		var employment_status = $("#employment_status").val();
		if(employment_status == 1 || employment_status == 4 || employment_status == 5 || employment_status == 6){
			var location = "submit_guarantor";
		}
		else if(employment_status == 2 || employment_status == 3){
			var location = "success";
		}
		$.ajax({
			url:"ajax/submit_loan_purpose.php",
			method: "POST",
			data: $("#submit_loan_purpose_form").serialize(),
			beforeSend: function(){
				$('#submit_loan_purpose').attr('disabled', true);
				$('#submit_loan_purpose').text('Submitting...');
			},
			success: function(data){
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Your loan application has been submitted successfully",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = location;}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
				}
				$('#submit_loan_purpose').attr('disabled', false);
				$('#submit_loan_purpose').text('Submit');
			}
		})
	});


	$("#submit_asset_loan_purpose").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		$.ajax({
			url:"ajax/submit_asset_loan_purpose.php",
			method: "POST",
			data: $("#submit_asset_loan_purpose_form").serialize(),
			success: function(data){
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! Your loan application has been submitted successfully, you will be contacted soon");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "successful_loan_application.php";}, 5000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
			}
		})
	});


	/* Badmus Js Starts Kere */
	$("#submitforverification").click(function(e){
		// alert($("#email").val());
		var phone = $("#phone_number").val();
		var email = $("#email").val();
		if (phone.length == 0) {
			$("#invalid_phone").show();
			$("#DialogBasic").modal('toggle');
			return;
		}else{
			$("#invalid_phone").hide();
			$("#valid_phone").show();	
			$("#DialogBasic").modal('toggle');
		}

		if (email.length == 0) {
			$("#invalid_email").show();
			$("#DialogBasic").modal('toggle');
			return;
		}else{
			$("#invalid_email").hide();
			$("#valid_email").show();	
			$("#DialogBasic").modal('toggle');

		}

		$.ajax({
			url:"ajax/verify_user.php",
			method: "POST",
			data: {
				"email":email,
				"phone":phone
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html(`Success! OTP has  been sent to your phone number, please check your email
					 if otp not received with 60 seconds`);
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "sms_verification.php";}, 5000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 4000);
				}
			}
		})

	});

	$("#otp_submit_button").click(function(e){
		//alert("alright");
		e.preventDefault();
		var otp = $("#smscode").val();
		if (otp.length == 0) {
			$("#empty_otp").show();
			return;
		}
		$("#empty_otp").hide();

		$.ajax({
			url:"ajax/verify_otp.php",
			method: "POST",
			data: {
				"otp":otp,
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					
					$("#success_message").empty();
					$("#success_message").html("Success! Please verify your otp on the next page");
					toastbox('success_toast', 6000);
					setTimeout( function(){ window.location.href = "personal_details.php";}, 6000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
			}
		});

	});


	$("#login_admin").click(function(e){
		e.preventDefault();
		
		$.ajax({
			url:"ajax_admin/admin_login.php",
			method: "POST",
			data: $("#login_admin_form").serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! You've successfully logged in");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "index.php";}, 3000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
			}
		})
	});

	$("#disable_user").click(function(){
          $.ajax({
              url: "ajax_admin/disable_user.php",
              method: "POST",
              data:$("#disable_user_form").serialize(),
              beforeSend:function(){
                $("#disable_user").attr("disabled", true);
                $("#disable_user").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully disabled user");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_personal_details.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#disable_user").attr("disabled", false);
                $("#disable_user").text("Yes");
              }
          });
      });

	$("#enable_user").click(function(){
          $.ajax({
              url: "ajax_admin/enable_user.php",
              method: "POST",
              data:$("#enable_user_form").serialize(),
              beforeSend:function(){
                $("#enable_user").attr("disabled", true);
                $("#enable_user").text("Please wait...");
              },
              success: function(data){
                if(data == "success"){
                	$(".modal").modal('hide');
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully enabled user");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_personal_details.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#enable_user").attr("disabled", false);
                $("#enable_user").text("Yes");
              }
          });
      });


	$("#set_loan_package").click(function(){
          $.ajax({
              url: "ajax_admin/set_loan_package.php",
              method: "POST",
              data:$("#set_packages_form").serialize(),
              beforeSend:function(){
                $("#set_loan_package").attr("disabled", true);
                $("#set_loan_package").text("Creating...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Package has been created successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "set_loan_package.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#set_loan_package").attr("disabled", false);
                $("#set_loan_package").text("Create Package");
              }
          });
      });

	$("#add_vendor").click(function(){
          $.ajax({
              url: "ajax_admin/add_vendor.php",
              method: "POST",
              data:$("#add_vendor_form").serialize(),
              beforeSend:function(){
                $("#add_vendor").attr("disabled", true);
                $("#add_vendor").text("Adding...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Vendor has been added successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "add_vendor.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#add_vendor").attr("disabled", false);
                $("#add_vendor").text("Add Vendor");
              }
          });
      });


	$("#add_product").click(function(){
          $.ajax({
              url: "ajax_admin/add_product.php",
              method: "POST",
              data:$("#add_product_form").serialize(),
              beforeSend:function(){
                $("#add_product").attr("disabled", true);
                $("#add_product").text("Adding...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Product has been added successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "add_product.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#add_product").attr("disabled", false);
                $("#add_product").text("Add Product");
              }
          });
      });

	$("#edit_package_btn").click(function(){
          $.ajax({
              url: "ajax_admin/edit_package.php",
              method: "POST",
              data:$("#edit_package_form").serialize(),
              beforeSend:function(){
                $("#edit_package_btn").attr("disabled", true);
                $("#edit_package_btn").text("Editing...");
              },
              success: function(data){
              	$("#modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Package has been edited successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_loan_packages.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#edit_package_btn").attr("disabled", false);
                $("#edit_package_btn").text("Edit");
              }
          });
      });


	$("#edit_vendor_btn").click(function(){
          $.ajax({
              url: "ajax_admin/edit_vendor.php",
              method: "POST",
              data:$("#edit_vendor_form").serialize(),
              beforeSend:function(){
                $("#edit_vendor_btn").attr("disabled", true);
                $("#edit_vendor_btn").text("Editing...");
              },
              success: function(data){
              	$("#modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Vendor has been edited successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_vendors.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#edit_vendor_btn").attr("disabled", false);
                $("#edit_vendor_btn").text("Edit");
              }
          });
      });

	$("#delete_vendor_btn").click(function(){
          $.ajax({
              url: "ajax_admin/delete_vendor.php",
              method: "POST",
              data:$("#delete_vendor_form").serialize(),
              beforeSend:function(){
                $("#delete_vendor_btn").attr("disabled", true);
                $("#delete_vendor_btn").text("Deleting...");
              },
              success: function(data){
              	$("#modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Vendor has been deleted successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_vendors.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#delete_vendor_btn").attr("disabled", false);
                $("#delete_vendor_btn").text("Delete");
              }
          });
      });


	$("#edit_product_btn").click(function(){
          $.ajax({
              url: "ajax_admin/edit_product.php",
              method: "POST",
              data:$("#edit_product_form").serialize(),
              beforeSend:function(){
                $("#edit_product_btn").attr("disabled", true);
                $("#edit_product_btn").text("Editing...");
              },
              success: function(data){
              	$("#modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Product has been edited successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_vendors.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#edit_product_btn").attr("disabled", false);
                $("#edit_product_btn").text("Edit");
              }
          });
      });

	$("#delete_vendor_btn").click(function(){
          $.ajax({
              url: "ajax_admin/delete_vendor.php",
              method: "POST",
              data:$("#delete_vendor_form").serialize(),
              beforeSend:function(){
                $("#delete_vendor_btn").attr("disabled", true);
                $("#delete_vendor_btn").text("Deleting...");
              },
              success: function(data){
              	$("#modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Vendor has been deleted successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_vendors.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#delete_vendor_btn").attr("disabled", false);
                $("#delete_vendor_btn").text("Delete");
              }
          });
      });

	
	$("#set_insurance_package").click(function(){
          $.ajax({
              url: "ajax_admin/set_insurance_package.php",
              method: "POST",
              data:$("#set_packages_form").serialize(),
              beforeSend:function(){
                $("#set_insurance_package").attr("disabled", true);
                $("#set_insurance_package").text("Creating...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Insurance Package has been created successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "set_insurance_packages.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#set_insurance_package").attr("disabled", false);
                $("#set_insurance_package").text("Create Package");
              }
          });
      });

	$("#set_pricing_plan").click(function(){
          $.ajax({
              url: "ajax_admin/set_pricing_plan.php",
              method: "POST",
              data:$("#set_pricing_plan_form").serialize(),
              beforeSend:function(){
                $("#set_pricing_plan").attr("disabled", true);
                $("#set_pricing_plan").text("Creating...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Insurance Pricing Plan has been created successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "set_pricing_plan.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#set_pricing_plan").attr("disabled", false);
                $("#set_pricing_plan").text("Create Plan");
              }
          });
      });


	$("#upload_document").click(function(){
          $.ajax({
              url: "ajax_admin/upload_document.php",
              method: "POST",
              data:$("#upload_document_form").serialize(),
              beforeSend:function(){
                $("#upload_document").attr("disabled", true);
                $("#upload_document").text("Saving...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Document had been uploaded successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "upload_document.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#upload_document").attr("disabled", false);
                $("#upload_document").text("Save Document");
              }
          });
      });

	$("#delete_document").click(function(){
          $.ajax({
              url: "ajax_admin/delete_document.php",
              method: "POST",
              data:$("#delete_document_form").serialize(),
              beforeSend:function(){
                $("#delete_document").attr("disabled", true);
                $("#delete_document").text("Deleting...");
              },
              success: function(data){
              	$("#modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Document had been deleted successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "view_documents.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#delete_document").attr("disabled", false);
                $("#delete_document").text("Yes");
              }
          });
      });
      

	$("#accept_loan_application_btn").click(function(){
		let admin_selection_amount_max = $("#admin_selection_amount_max").val();
        let admin_selection_amount_min = $("#admin_selection_amount_min").val();
        if(admin_selection_amount_min > admin_selection_amount_max){
        	alert("Minimum Approval amount must be less than Maximum Approval amount");
        }
        else{
          $.ajax({
              url: "ajax_admin/accept_loan_application.php",
              method: "POST",
              data:$("#accept_loan_application_form").serialize(),
              beforeSend:function(){
                $("#accept_loan_application_btn").attr("disabled", true);
                $("#accept_loan_application_btn").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully accepted this loan application");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "personal_loan_application_requests.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#accept_loan_application_btn").attr("disabled", false);
                $("#accept_loan_application_btn").text("Yes");
              }
          });
  		}
      });

	$("#reject_loan_application_btn").click(function(){
          $.ajax({
              url: "ajax_admin/reject_loan_application.php",
              method: "POST",
              data:$("#reject_loan_application_form").serialize(),
              beforeSend:function(){
                $("#reject_loan_application_btn").attr("disabled", true);
                $("#reject_loan_application_btn").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully rejected this loan application");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "personal_loan_application_requests.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#reject_loan_application_btn").attr("disabled", false);
                $("#reject_loan_application_btn").text("Yes");
              }
          });
      });

	$("#accept_asset_finance_btn").click(function(){
          $.ajax({
              url: "ajax_admin/accept_asset_finance.php",
              method: "POST",
              data:$("#accept_asset_finance_form").serialize(),
              beforeSend:function(){
                $("#accept_asset_finance_btn").attr("disabled", true);
                $("#accept_asset_finance_btn").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully accepted this loan application");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "asset_finance_requests.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#accept_asset_finance_btn").attr("disabled", false);
                $("#accept_asset_finance_btn").text("Yes");
              }
          });
      });

	$("#reject_asset_finance_btn").click(function(){
          $.ajax({
              url: "ajax_admin/reject_asset_finance.php",
              method: "POST",
              data:$("#reject_asset_finance_form").serialize(),
              beforeSend:function(){
                $("#reject_asset_finance_btn").attr("disabled", true);
                $("#reject_asset_finance_btn").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully rejected this loan application");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "asset_finance_requests.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#reject_asset_finance_btn").attr("disabled", false);
                $("#reject_asset_finance_btn").text("Yes");
              }
          });
      });

	$("#online_bank_statement").click(function(){
		// var redirect_url = '<?php echo "http://$_SERVER[HTTP_HOST]"."zennal_callback.php?transaction_id="?>'
        $.ajax({
          url: "ajax/online_bank_statement.php",
          method: "POST",
          data: $("#submit_loan_purpose_form").serialize(),
          beforeSend:function(){
            // $("#online_bank_statement_btn").attr("disabled", true);
            $("#online_bank_statement").text("Please wait...");
          },
          success: function(data){
            $("#online_bank_statement").text("Click here to pay");
            Okra.buildWithOptions({
                name: 'Cloudware Technologies',
                env: 'production-sandbox',
                key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
                token: '5f5a2e5f140a7a088fdeb0ac', 
                source: 'link',
                color: '#ffaa00',
                limit: '24',
                // amount: 5000,
                // currency: 'NGN',
                garnish: true,
                charge: {
                  type: 'one-time',
                  amount: 2100*100,
                  note: '',
                  currency: 'NGN',
                  account: '5ecfd65b45006210350becce'
                },
                corporate: null,
                connectMessage: 'Which account do you want to connect with?',
                products: ["auth", "transactions", "balance"],
                //callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
                //callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
                //redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
                logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
                filter: {
                    banks: [],
                    industry_type: 'all',
                },
                widget_success: 'Your account was successfully linked to Cloudware Technologies',
                widget_failed: 'An unknown error occurred, please try again.',
                currency: 'NGN',
                exp: null,
                success_title: 'Cloudware Technologies!',
                success_message: 'You are doing well!',
                onSuccess: function (data) {
                    console.log('success', data);
                    // window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
                    window.location.href = 'http://localhost/new_zennal/online_generation_callback?payment_id='+data.payment_id;
                    //window.location.href = '<?php //echo $redirect_url?>';
                    //console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
                },
                onClose: function () {
                    console.log('closed')
                }
            })
          }
        });

        // function connectViaOptions3() {
        // }
    });

    $("#online_bank_statement_asset").click(function(){
        $.ajax({
              url: "ajax/online_bank_statement2.php",
              method: "POST",
              data: $("#submit_asset_loan_purpose_form").serialize(),
              beforeSend:function(){
                // $("#online_bank_statement_btn").attr("disabled", true);
                $("#online_bank_statement_asset").text("Please wait...");
              },
              success: function(data){
                // if(data == "success"){
                //   $("#success_message").empty();
                //   $("#success_message").html("Success! You've successfully rejected this loan application");
                //   toastbox('success_toast', 3000);
                setTimeout( function(){ window.location.href = data;}, 1000);
                // }
                // else{
                //   $("#error_message").empty();
                //   $("#error_message").html("Error! " + data);
                //   toastbox('error_toast', 6000);
                // }
                // $("#online_bank_statement_btn").attr("disabled", false);
                // $("#online_bank_statement_btn").text("Yes");
                $("#online_bank_statement_asset").text("Click here to pay");
              }
         });
    });

    $("#submit_guarantor").click(function(e){
		e.preventDefault();
		let id = $(this).attr('id');
		//console.log(id);
		$.ajax({
			url:"ajax/submit_guarantor.php",
			method: "POST",
			beforeSend: function(){
				$("#submit_guarantor").attr("disabled", "true");
				$("#submit_guarantor").text("Submitting...");
			},
			data: $("#submit_guarantor_form").serialize(),
			success: function(data){
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Your Guarantors details have been submitted successfully",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "success";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
				}
				$("#submit_guarantor").attr("disabled", false);
				$("#submit_guarantor").text("Submit");
			}
		})
	});

	$("#change_password").click(function(){
          $.ajax({
              url: "ajax_admin/change_password.php",
              method: "POST",
              data:$("#change_password_form").serialize(),
              beforeSend:function(){
                $("#change_password").attr("disabled", true);
                $("#change_password").text("Changing...");
              },
              success: function(data){
              	//$(".modal").modal('hide');
                if(parseInt(data) == 200){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully changed your password");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "change_password.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#change_password").attr("disabled", false);
                $("#change_password").text("Change");
              }
          });
      });

//Tosin's code ends here



	$("#form_personal").submit(function(e) {
		e.preventDefault();
		var personalObj = {};
		var personal = $(this).serializeArray();

		personal.forEach(person =>{
			personalObj[person["name"]] = person["value"];
		});

		localStorage.setItem("personalInfo", JSON.stringify(personalObj));
		window.location.href = "contact_details.php";
	});

	$("#form_contact").submit(function(e){
		e.preventDefault();
		var contact = $(this).serializeArray();
		var contactObj={};

		contact.forEach(con =>{
			contactObj[con["name"]] = con["value"];
		});

		localStorage.setItem("contactInfo", JSON.stringify(contactObj));
		window.location.href = "identification_details.php";
	});



	$("#form_id").submit(function(e){
		e.preventDefault();
		var formObj = $(this).serializeArray();
		// var pic = $(this)[0];
		var fd = new FormData(this);
		var id;
		var profile_picture;
		$.ajax({
			url:"ajax/image_upload.php",
			method: "POST",
			async: false,
			data: fd,
			contentType: false,
            processData: false,
			success: function(response){
				var res = JSON.parse(response);
                if(res["status"] == 1){
					profile_picture = res["filename"];
					
				}else{
					alert(res["msg"]);
				}
			}
		});
		
		$.each(formObj, function(i, field){
			id = field.value;
		});
		
		// console.log({"means_of_id":id, "profile_pic":profile_picture});
		localStorage.setItem("idInfo", JSON.stringify({"means_of_id":id, "profile_pic":profile_picture}));

		window.location.href = "next_of_kin_details.php";

	});

	$("#form_next_of_kin").submit(function(e){
		e.preventDefault();

		var nextOfKin = $(this).serializeArray();
		var nokObj={};

		nextOfKin.forEach(nok =>{
			nokObj[nok["name"]] = nok["value"];
		});

		if (localStorage.getItem("personalInfo") && localStorage.getItem("contactInfo") && localStorage.getItem("idInfo") != null) {
			var personalInfo = JSON.parse(localStorage.getItem("personalInfo"));
			var contactInfo = JSON.parse(localStorage.getItem("contactInfo"));
			var idInfo = JSON.parse(localStorage.getItem("idInfo"));
		}

		console.log(personalInfo);
		console.log(contactInfo);
		console.log(idInfo);
		$.ajax({
			url:"ajax/register_user.php",
			method: "POST",
			data: {
				"personal":personalInfo,
				"contact":contactInfo,
				"identity":idInfo,
				"nextofkin":nokObj,
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! Please proceed to login");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "login_user.php";}, 4000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
			}
		});

	});

	// Badmus
	$("#login_form").submit(function(e){
		e.preventDefault();
		$('#login_submit_btn').attr('disabled', true);
		$('#login_submit_btn').text('Please wait');
		$.ajax({
			url:"ajax/user_login.php",
			method: "POST",
			data: $(this).serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "You've successfully logged in",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "index";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					// location.reload();
					// $('#login_submit_btn').attr('disabled', false);
					// $('#login_submit_btn').text('Login');
				}
				$('#login_submit_btn').attr('disabled', false);
				$('#login_submit_btn').text('Submit');
			}
		});
	});

	// Badmus
	$("#phone_no").focus(function(){
		$("#phone_alert").show();
	});

	// Badmus
	$("#register_form").submit(function(e){
		e.preventDefault();
		// alert(1);
		// console.log($(this).serialize());
		$("#register_submit_btn").attr('disabled', true);
		$("#register_submit_btn").text('Please wait');

		$.ajax({
			url:"ajax/user_registration.php",
			method: "POST",
			data: $(this).serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "You've successfully registered",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "index.php";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					// location.reload();
					$('#register_submit_btn').attr('disabled', false);
					$('#register_submit_btn').text('Submit');
				}
			}
		});
	});

	// Badmus
	$("#update_profile_form").submit(function(e){
		e.preventDefault();
		$("#update_profile_btn").attr('disabled', true);
		$("#update_profile_btn").text('Please wait');

		$.ajax({
			url:"ajax/user_update_profile.php",
			method: "POST",
			data: $(this).serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "User profile has been updated successfully",
                        icon: "success",
                    });
					$('#update_profile_btn').attr('disabled', false);
					$('#update_profile_btn').text('Update Profile');
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					$('#update_profile_btn').attr('disabled', false);
					$('#update_profile_btn').text('Update Profile');
				}
			}
		});
	});

	// Badmus
	$("#forgot_password_form").submit(function(e){
		e.preventDefault();
		$("#forgot_password_btn").attr('disabled', true);
		$("#forgot_password_btn").text('Please wait');

		let url = "ajax/forgot_password.php";

		$.ajax({
			url:url,
			method: "GET",
			data: $(this).serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Password reset link has been sent to your email",
                        icon: "success",
                    });
					$('#forgot_password_btn').attr('disabled', false);
					$('#forgot_password_btn').text('Submit');
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					$('#forgot_password_btn').attr('disabled', false);
					$('#forgot_password_btn').text('Submit');
				}
			}
		});
	});

	// Badmus

	$("#password_reset_form").submit(function(e){
		e.preventDefault();
		$("#forgot_password_btn").attr('disabled', true);
		$("#forgot_password_btn").text('Please wait');

		let url = "ajax/reset_password.php";

		$.ajax({
			url:url,
			method: "GET",
			data: $(this).serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Password has been reset successfully",
                        icon: "success",
                    });
					$('#forgot_password_btn').attr('disabled', false);
					$('#forgot_password_btn').text('Submit');
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					$('#forgot_password_btn').attr('disabled', false);
					$('#forgot_password_btn').text('Submit');
				}
			}
		});
	});
	// Insurance 

	$("#vehicle_details").submit(function(e){
		e.preventDefault();
		$("#submit_vehicle_details").attr("disabled", true);
		$("#submit_vehicle_details").text("Please wait");

		const fd = new FormData(this);

		$.ajax({
			url:"ajax/submit_vehicle_details.php",
			method: "POST",
			async: false,
			data: fd,
			contentType: false,
            processData: false,
			success: function(response){
                if(response == 'success'){

					console.log(response);

					Swal.fire({
                        title: "Congratulations!",
                        text: "Vehicle details saved successfully",
                        icon: "success",
                    });
					
					setTimeout( function(){ window.location.href = "buy_package.php";}, 4000);
				}else{
					//alert(res["msg"]);
					Swal.fire({
                        title: "Error!",
                        text: response,
                        icon: "error",
                    });
					$('#submit_vehicle_details').attr('disabled', false);
					$('#submit_vehicle_details').text('Submit');
				}
			}
		});
	});

	$("#vehicle_attachments_form").submit(function(e){
		e.preventDefault();
		$("#submit_attached").attr("disabled", true);
		var fd = new FormData(this);
		var uploadedFiles;

		$.ajax({
			url:"ajax/vehicle_attachments_upload.php",
			method: "POST",
			async: false,
			data: fd,
			contentType: false,
            processData: false,
			success: function(response){
				var res = JSON.parse(response);
                if(res["status"] == 1){

					uploadedFiles = res["file"]
					console.log(uploadedFiles);
					
				}else{
					//alert(res["msg"]);
					$("#error_message").empty();
					$("#error_message").html("Error! " + res["msg"]);
					toastbox('error_toast', 6000);
				}
			}
		});
		return saveUserInsuranceDetails(uploadedFiles)
	});
	

	function saveUserInsuranceDetails(attachedFiles){
		if (localStorage.getItem("insurancePackage") == null){
			$("#error_message").empty();
			$("#error_message").html("Select insurance package");
			toastbox('error_toast', 5000);
			window.location = "insurance_package_list.php";
		}

		if (localStorage.getItem("insurancePricing") == null){
			$("#error_message").empty();
			$("#error_message").html("Select insurance pricing plan");
			toastbox('error_toast', 5000);
			window.location = "insurance_package_price.php";
		}

		var savedInsurance = JSON.parse(localStorage.getItem("insurancePackage"));
		var savedInsurancePricing = JSON.parse(localStorage.getItem("insurancePricing"));
		var vehicleBasicInfo = JSON.parse(localStorage.getItem("vehicleInfo"));

		$.ajax({
			url:"ajax/insurance_details.php",
			method: "POST",
			data: {
				savedInsurance,
				savedInsurancePricing,
				vehicleBasicInfo,
				attachedFiles:attachedFiles
			},
			success: function(data){
				//alert(data);
				var data = JSON.parse(data);
				if(data.status == 1){
					$("#success_message").empty();
					$("#success_message").html(data.msg);
					toastbox('success_toast', 1000);
					setTimeout( () => window.location.href = "account_details.php", 1000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html('Error!' + data.msg);
					toastbox('error_toast', 6000);
				}
			}
		});

	}

	$("#bank_name").click(function(){
		// alert(1);
		$.get("ajax/list_of_banks.php", function(data, status){
			var data = JSON.parse(data);
			if (data.status === true) {
				let banks = data.data;
				banks.map(bank => {
					$("#bank_name").append(`
					<option value=${bank.code}>${bank.name}</option>
					`);
				});
			}
			// alert(data);
		});

		
	});

	$("#accout_details_form").submit(function(e) {
		e.preventDefault();
		$("#submit-acc-details").attr("disabled", true);
		let bankName = $("#bank_name").children("option:selected").html();
		let bankCode = $("#bank_name").children("option:selected").val();
		let acctName = $("#account_name").val();
		let acctNo = $("#account_no").val();
		// let bankCode = $("#bank_name").children("option:selected").val();
		// alert(acctNo);
		$.post("ajax/save_account_details.php", {
			bank_name: bankName,
			bank_code: bankCode,
			account_name: acctName,
			account_no: acctNo
		}, function(data, status){
			var data = JSON.parse(data);
			if (data.status == 1){
				//alert(data.msg);
				$("#success_message").empty();
				$("#success_message").html(data.msg);
				toastbox('success_toast', 1000);
				setTimeout( () => window.location = "payment_options.php", 6000);
			}else{
				//alert(data.msg);
				$("#error_message").empty();
				$("#error_message").html('Error!' + data.msg);
				toastbox('error_toast');
				setTimeout( () => window.location = "account_details.php", 4000);
				//location.reload();
			}
		});
	});

	$("#set-payment-card").click(function () {
		// alert(1);
		$(this).attr("disabled", true);
		$(this).html("Please wait...");
		$.get("ajax/payment_full.php", function(data, status){
			var data = JSON.parse(data);
			if (data.status === true) {
				let url = data.data.authorization_url;
				setTimeout( () => window.location = url, 1000);
			}
			// alert(data);
		});
	})

	$(".installmental-pay").click(function(){
		let period = $(this).data('period');
		/*
		If okra seccessfull: Succes modal and leads to a page stating what is due now (equity cont. 30%) 
		else: Decline modal
		*/
		// $("#DialogIconedSuccess").modal("toggle");

		$.post("ajax/update_insurance_and_get_repayment.php", {
			paymentPeriod: period,
		}, function(data, status){
			if(data == "success"){
				$("#success_message").empty();
				$("#success_message").html("Success! Insurance updated");
				toastbox('success_toast', 3000);
				setTimeout( function(){ window.location.href = "installment_payment.php";}, 3000);
			}
			else{
				$("#error_message").empty();
				$("#error_message").html("Error! " + data);
				toastbox('error_toast', 6000);
			}
		});
	})
	
	// -----------------------------------------NEW-------------------------------------------------------------


	$("#edit_insurance_plan_btn").click(function(){
      $.ajax({
          url: "ajax_admin/edit_insurance_plan.php",
          method: "POST",
          data:$("#edit_insurance_plan_form").serialize(),
          beforeSend:function(){
            $("#edit_insurance_plan_btn").attr("disabled", true);
            $("#edit_insurance_plan_btn").text("Editing...");
          },
          success: function(data){
          	$("#modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! Package has been edited successfully");
              toastbox('success_toast');
              setTimeout( function(){ window.location.href = "view_insurance_plans.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 6000);
            }
            $("#edit_insurance_plan_btn").attr("disabled", false);
            $("#edit_insurance_plan_btn").text("Edit");
          }
      });
  	});


	 $("#edit_insurance_pricing_plan_btn").click(function(){
		$.ajax({
			url: "ajax_admin/edit_insurance_pricing_plan.php",
			method: "POST",
			data:$("#edit_insurance_pricing_plan_form").serialize(),
			beforeSend:function(){
			  $("#edit_insurance_pricing_plan_btn").attr("disabled", true);
			  $("#edit_insurance_pricing_plan_btn").text("Editing...");
			},
			success: function(data){
				$("#modal").modal('hide');
			  if(data == "success"){
				$("#success_message").empty();
				$("#success_message").html("Success! Package has been edited successfully");
				toastbox('success_toast');
				setTimeout( function(){ window.location.href = "view_insurance_pricing.php";}, 3000);
			  }
			  else{
				$("#error_message").empty();
				$("#error_message").html("Error! " + data);
				toastbox('error_toast', 6000);
			  }
			  $("#edit_insurance_pricing_plan_btn").attr("disabled", false);
			  $("#edit_insurance_pricing_plan_btn").text("Edit");
			}
		});
	});
	  

	$("#edit_insurance_rate_btn").click(function(){
		$.ajax({
			url: "ajax_admin/edit_insurance_rate.php",
			method: "POST",
			data:$("#edit_insurance_rate_form").serialize(),
			beforeSend:function(){
			$("#edit_insurance_rate_btn").attr("disabled", true);
			$("#edit_insurance_rate_btn").text("Editing...");
			},
			success: function(data){
				$("#modal").modal('hide');
			if(data == "success"){
				$("#success_message").empty();
				$("#success_message").html("Success! Interest rate has been edited successfully");
				toastbox('success_toast');
				setTimeout( function(){ window.location.href = "set_percentage_interest.php";}, 3000);
			}
			else{
				$("#error_message").empty();
				$("#error_message").html("Error! " + data);
				toastbox('error_toast', 6000);
			}
			$("#edit_insurance_rate_btn").attr("disabled", false);
			$("#edit_insurance_rate_btn").text("Edit");
			}
		});
	});

	$("#delete_insurance_pricing_plan_btn").click(function() {
		$.ajax({
			url: "ajax_admin/delete_insurance_pricing_plan.php",
			method: "POST",
			data:{planId:$(this).data('planid')},
			beforeSend:function(){
			$("#delete_insurance_pricing_plan_btn").attr("disabled", true);
			$("#delete_insurance_pricing_plan_btn").text("please wait...");
			},
			success: function(data){
				$("#modal").modal('hide');
			if(data == "success"){
				$("#success_message").empty();
				$("#success_message").html("Success! Pricing plan has been deleted successfully");
				toastbox('success_toast');
				setTimeout( function(){ window.location.href = "view_insurance_pricing.php";}, 3000);
			}
			else{
				$("#error_message").empty();
				$("#error_message").html("Error! " + data);
				toastbox('error_toast', 6000);
			}
			$("#edit_insurance_rate_btn").attr("disabled", false);
			$("#edit_insurance_rate_btn").text("Edit");
			}
		});
	});

	$("#delete_insurance_plan_btn").click(function() {
		$.ajax({
			url: "ajax_admin/delete_insurance_plan.php",
			method: "POST",
			data:{packageId:$(this).data('packageid')},
			beforeSend:function(){
			$("#delete_insurance_plan_btn").attr("disabled", true);
			$("#delete_insurance_plan_btn").text("please wait...");
			},
			success: function(data){
				$("#modal").modal('hide');
			if(data == "success"){
				$("#success_message").empty();
				$("#success_message").html("Success! Package has been deleted successfully");
				toastbox('success_toast');
				setTimeout( function(){ window.location.href = "view_insurance_plans.php";}, 3000);
			}
			else{
				$("#error_message").empty();
				$("#error_message").html("Error! " + data);
				toastbox('error_toast', 6000);
			}
			$("#edit_insurance_rate_btn").attr("disabled", false);
			$("#edit_insurance_rate_btn").text("Edit");
			}
		});
	});
	
	$("#add_insurance_plan_form").submit(function(e){
		e.preventDefault();
          $.ajax({
              url: "ajax_admin/add_insurance_pan.php",
              method: "POST",
              data:$(this).serialize(),
              beforeSend:function(){
                $("#add_insurance_plan").attr("disabled", true);
                $("#add_insurance_plan").text("Please wait");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Insurance plan has been created successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "add_insurance_category.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#add_insurance_plan").attr("disabled", false);
                $("#add_insurance_plan").text("Create plan");
              }
          });
      });
      
      $("#insurance_benefit_form").submit(function(e){
		  e.preventDefault();
          $.ajax({
              url: "ajax_admin/add_insurance_benefit.php",
              method: "POST",
              data:$(this).serialize(),
              beforeSend:function(){
                $("#add_insurance_benefit").attr("disabled", true);
                $("#add_insurance_benefit").text("Please wait");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Insurance benefit has been created successfully");
                  toastbox('success_toast', 3000);
                //   setTimeout( function(){ window.location.href = "add_insurance_benefit.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#add_insurance_benefit").attr("disabled", false);
                $("#add_insurance_benefit").text("Add Benefit");
              }
          });
      });

// -----------------------------------------NEW-------------------------------------------------------------
	//Tosin

	$("#withdraw_button").click(function(e){
		e.preventDefault();
		$('#withdraw_button').attr('disabled', true);
		$('#withdraw_button').text('Please wait...');
		$.ajax({
			url:"ajax/submit_withdrawal.php",
			method: "POST",
			data: $("#withdrawal_form").serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "You've submitted your withdrawal request",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "refer";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					// location.reload();
				}
				$('#withdraw_button').attr('disabled', false);
				$('#withdraw_button').text('Submit Withdrawal');
			}
		})
	});


	$("#submit_financial_details").click(function(e){
		e.preventDefault();
		var reg_id = $("#reg_id").val();
		if(reg_id == ''){
			var location = "loan_purpose";
		}else{
			var location = "vehicle_reg_stmt?reg_id="+reg_id;
		}
		$('#submit_financial_details').attr('disabled', true);
		$('#submit_financial_details').text('Please wait...');
		$.ajax({
			url:"ajax/submit_financial_details.php",
			method: "POST",
			data: $("#submit_financial_details_form").serialize(),
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "You've submitted your financial details",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = location;}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					// location.reload();
				}
				$('#submit_financial_details').attr('disabled', false);
				$('#submit_financial_details').text('Submit');
			}
		})
	});

	$("#approve_withdrawal").click(function(e){
		e.preventDefault();
		
		$.ajax({
			url:"ajax_admin/approve_withdrawal.php",
			method: "POST",
			data: $("#approve_withdrawal_form").serialize(),
			beforeSend: function(){
				$("#approve_withdrawal").attr("disabled", true);
				$("#approve_withdrawal").text("Approving...");
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! You've successfully approved this withdrawal request");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "withdrawal_requests.php";}, 3000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
				$("#modal").modal('hide');
				$("#approve_withdrawal").attr("disabled", false);
				$("#approve_withdrawal").text("Approve");
			}
		})
	});

	$("#reject_withdrawal").click(function(e){
		e.preventDefault();
		
		$.ajax({
			url:"ajax_admin/reject_withdrawal.php",
			method: "POST",
			data: $("#reject_withdrawal_form").serialize(),
			beforeSend: function(){
				$("#reject_withdrawal").attr("disabled", true);
				$("#reject_withdrawal").text("Rejecting...");
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! You've rejected this withdrawal request");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "withdrawal_requests.php";}, 3000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
				$("#modal").modal('hide');
				$("#reject_withdrawal").attr("disabled", false);
				$("#reject_withdrawal").text("Reject");
			}
		})
	});

	$("#change_ownership_btn").click(function(e){
		e.preventDefault();
		$('#change_ownership_btn').attr('disabled', true);
		$('#change_ownership_btn').text('Please wait...');
		$.ajax({
			url:"ajax/change_ownership.php",
			method: "POST",
			data: $("#change_ownership_form").serialize(),
			success: function(data){
				//alert(data);
				if(data['status'] == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "You've submitted ownership details",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "complete_change_ownership_order?unique_id="+data['data'];}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data['status'],
                        icon: "error",
                    });
				}
				$('#change_ownership_btn').attr('disabled', false);
				$('#change_ownership_btn').text('Proceed');
			}
		})
	});


	// Badmus

	$(".make_of_vehicle").change(function(){
		
		console.log($(this).find(':selected').attr("data-brandId"));

		let vehicleBrandId = $(this).find(':selected').attr("data-brandId");

		$.get("ajax/get_vehicle_model.php", {vehicleBrandId}, function(data, error){
			console.log(data);
			const arrData = JSON.parse(data);
			$("#vehicle_model").empty();
			$("#vehicle_model").append(`<option value="">Select Vehicle Model</option>`);
			arrData.map(model => {
				// console.log(model.model_name);
				$("#vehicle_model").append(
					`<option value="${model.model_name}">${model.model_name}</option>`
				)
			})
		})
	});

	// Badmus
	// Renew Vehicle Particulars
	$("#make_of_vehicle").change(function(){

		console.log($(this).find(':selected').attr("data-brandId"));

		let vehicleBrandId = $(this).find(':selected').attr("data-brandId");

		$.get("ajax/get_vehicle_model.php", {vehicleBrandId}, function(data, error){
			console.log(data);
			const arrData = JSON.parse(data);
			$("#vehicle_model").empty();
			$("#vehicle_model").append(`<option value="">Select Vehicle Model</option>`);
			arrData.map(model => {
				// console.log(model.model_name);
				$("#vehicle_model").append(
					`<option value="${model.unique_id}">${model.model_name}</option>`
				)
			})
		})
	});


	var couponApplied = 0;
	var currentTotal = 0;
	var couponDiscount = 0;
	var removeFromWallet = 0;

	// Badmus
	$("#renew-particulars-form").submit(function(e){
		e.preventDefault();
		// alert($(this).serialize());

		$.ajax({
			url:"ajax/save_vehicle_particulars.php",
			method: "POST",
			data: $(this).serialize(),
			beforeSend: function(){
				$("#submit-particular-btn").attr("disabled", true);
				$("#submit-particular-btn").text("Please wait");
			},
			success: function(data){
				console.log(data);
				let resDAta = JSON.parse(data);
				if(resDAta.status == "1"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Vehicle details submitted successfully",
                        icon: "success",
                    })
					setTimeout( function(){ window.location.href = `complete_order.php?rec_id=${resDAta.row_id}`;}, 3000);
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: `${data}`,
                        icon: "error",
                    })
				}
				$("#submit-particular-btn").attr("disabled", false);
				$("#submit-particular-btn").text("Submit");
			}
		})
	})

	$(".remove-coupon").click(function(){

		var btn = $(this);
		couponApplied = 0;
		currentTotal = parseInt(currentTotal) + parseInt(couponDiscount);
		couponDiscount = 0;

		btn.parents(".order-area").find(".total_cost").text(`${formatNumber(currentTotal)}`);
		btn.parents(".order-area").find(".coupon_discount").text(`${formatNumber(couponDiscount)}`);

		btn.parents(".order-area").find(".coupon_field").val("");

		btn.parents(".order-area").find(".coupon-btn").show();
		btn.hide();
	})

	$(".coupon_field").keyup(function(){
		couponApplied = 0;
		// currentTotal = parseInt(currentTotal) + parseInt(couponDiscount);
		currentTotal = $(this).parents(".order-area").find(".coupon-btn").data("total");
		let walletBalance = $(this).parents(".order-area").find(".coupon-btn").data("walletbalance");
		couponDiscount = 0;

		// console.log({currentTotal:currentTotal, walletBalance});

		if(removeFromWallet == 1){
			if(walletBalance > currentTotal){
				currentTotal = 0;
			}else{
				currentTotal = currentTotal - walletBalance;
			}
		}

		$(this).parents(".order-area").find(".total_cost").text(`${formatNumber(currentTotal)}`);
		$(this).parents(".order-area").find(".coupon_discount").text(`${formatNumber(couponDiscount)}`);

		$(this).parents(".order-area").find(".coupon-btn").show();
		$(this).parents(".order-area").find(".remove-coupon").hide();
	})


	$(".coupon_btn").click(function() {

		var btn = $(this)
		let payload;
		const couponCode = btn.parents(".order-area").find(".coupon_field").val();
		const particularsId = btn.attr('data-particularsId');
		const totalAmount = btn.attr('data-total');
		console.log(totalAmount);
		if(btn.attr('data-type')){
			const type = btn.attr('data-type')
			payload = {couponCode, particularsId, totalAmount, type, remove_from_wallet: removeFromWallet}
		}else{
			payload = {couponCode, particularsId, totalAmount, remove_from_wallet: removeFromWallet}
		}
		$.ajax({
			url:"ajax/validate_coupon_code.php",
			method: "GET",
			data: payload,
			success: function(data){
				console.log(data);
				if (data == '0') {
					$(".coupon_code_help_txt").text(`Invalid coupon code`);
					$(".coupon_code_help_txt").css('color', 'tomato');
				}else{

					let resData = JSON.parse(data);

					couponApplied = 1;
					couponDiscount = resData.discount;
					currentTotal = resData.total;

					btn.parents(".order-area").find(".coupon_code_help_txt").text("Valid coupon code");
					btn.parents(".order-area").find(".coupon_code_help_txt").css('color', 'green');
					// console.log(resData.discount);
					btn.parents(".order-area").find(".coupon_discount").text(`${formatNumber(resData.discount)}`);
					btn.parents(".order-area").find(".total_cost").text(`${formatNumber(resData.total)}`);
					btn.parents(".order-area").find(".payment-proceed-btn").attr("data-amount", resData.total);

					btn.hide();
					btn.parents(".order-area").find(".remove-coupon").show();

					// $(".payment-proceed-btn").attr("data-discountamount", resData.total);

				}
			}
		})
	})
	$(".remove-from-wallet").click(function(){
		var checkbox = $(this);
		var btn = checkbox.parents(".order-area").find(".payment-proceed-btn")
		
		var wallet_balance = btn.data("walletbalance");
		var total = btn.data("amount");
		var initial_total = btn.data("initialamount");

		if($(this).is(':checked')){
			removeFromWallet = 1;
			
			
			if(couponApplied == 1){
				total = parseInt(currentTotal); 
			}else{
				if(parseInt(currentTotal) > 0){
					total = parseInt(currentTotal)
				}
				total = parseInt(total) + parseInt(couponDiscount); 
			}

      		if( parseInt(wallet_balance) > parseInt(total) ){
      			var new_total = 0;
      			btn.parents(".order-area").find(".total_cost").text(formatNumber(0));
      		}else{
      			var new_total = parseInt(total - wallet_balance);
				
      			btn.parents(".order-area").find(".total_cost").text(formatNumber(new_total));
			}
			currentTotal = new_total;
      	}else{
			removeFromWallet = 0;
			if(couponApplied == 1){
				if(parseInt(currentTotal) > 0){
					total = parseInt(currentTotal)
				}
				total = parseInt(total) - parseInt(couponDiscount)
			}else{
				console.log("Got here", total);
				total = parseInt(total)
			}
			btn.parents(".order-area").find(".total_cost").text(formatNumber(total));
			currentTotal = total;
			// $("#total").val(total);
      	}
  	});

	// Badmus
	$('#add_insurer_form').submit(function(e){
		e.preventDefault();
		$('#submit_insurer_form').attr('disabled', true);
		$('#submit_insurer_form').text('Please wait...');
		var formData = new FormData(this);
		$.ajax({
			url:"ajax_admin/add_insurer.php",
			method: "POST",
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Insurer added successfully",
                        icon: "success",
                    })
					// .then(setTimeout( function(){ window.location.href = "refer";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					// location.reload();
				}
				$('#submit_insurer_form').attr('disabled', false);
				$('#submit_insurer_form').text('Submit');
			}
		})
	});

	$(".payment-proceed-btn").click(function() {

		// console.log("Got here");

		var btn = $(this)

		// alert(1);
		let total;
		let payload;
		let reg_id = btn.data("recordid");
		let delivery_address = btn.parents(".order-area").find("#delivery_address").val();
		let delivery_city = btn.parents(".order-area").find(".delivery-city").val();
		let delivery_area = btn.parents(".order-area").find("#delivery-area").val();
		let service_type = "renew_vehicle_particulars";
		let remove_from_wallet = btn.parents(".order-area").find(".remove_from_wallet").val();
		let paymentOptionElem = $("#"+$(this).data("paymentoption"));
		let paymentOption = paymentOptionElem.find(':selected').val()
		let walletBalance = $(this).data("walletbalance");

		if (paymentOption != "") {
			// let deliveryType = $(".delivery_type").find(':selected').val();

			total = $(this).data("amount");


			// if($(this).data("discountamount")){
			// 	total = $(this).data("discountamount");
			// }else{
			// 	total = $(this).data("amount");
			// }

			const couponCode = btn.parents(".order-area").find(".coupon_field").val();

			const deliveryType = btn.data("deliverytype");

			var payLoadCheck = {
				reg_id,
				coupon_applied: couponApplied,
				coupon_code: couponCode,
				remove_from_wallet: removeFromWallet,
				delivery_type: deliveryType,
				service_type: 'particulars'
			}

			console.log({payLoadCheck});

			if (deliveryType == "email") {
				let email = $("#delivery-email").val();
				if(email == ""){
					Swal.fire({
						title: "Validation error",
						text: "Please enter a delivery email",
						icon: "error",
					})
					return;
				}
				else{
					payload = {reg_id, total, email, service_type, remove_from_wallet}
					
				}
			}else if(deliveryType == "physical"){
				if(delivery_address == "" || delivery_city == "" || delivery_area == ""){
					Swal.fire({
						title: "Validation error",
						text: "Please provide delivery details",
						icon: "error",
					})
					return;
				}
				else{
					payload = {reg_id, total, service_type, remove_from_wallet, delivery_city, delivery_area, delivery_address}
				}
			}
			
			$.ajax({
				url:"ajax/check_veh_reg_exist.php",
				method: "POST",
				data: payLoadCheck,
				success: function(data){
					// alert(data);
					console.log(data);
					var data = JSON.parse(data)
					if(data.check_status == "false"){
						if(paymentOption == "one_time"){
			
							payload.total = data.total;
							if(data.total_after_remove_wallet != 0){
								Okra.buildWithOptions({
									name: 'Cloudware Technologies',
									env: 'production-sandbox',
									key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
									token: '5f5a2e5f140a7a088fdeb0ac', 
									source: 'link',
									color: '#ffaa00',
									limit: '24',
									// amount: 5000,
									// currency: 'NGN',
									garnish: true,
									charge: {
										type: 'one-time',
										amount: data.total*100,
										note: '',
										currency: 'NGN',
										account: '5ecfd65b45006210350becce'
									},
									corporate: null,
									connectMessage: 'Which account do you want to connect with?',
									products: ["auth", "transactions", "balance"],
									//callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
									//callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
									//redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
									logo: 'http://localhost/zennal/assets/images/logozennal.png',
									filter: {
										banks: [],
										industry_type: 'all',
									},
									widget_success: 'Your account was successfully linked to Cloudware Technologies',
									widget_failed: 'An unknown error occurred, please try again.',
									currency: 'NGN',
									exp: null,
									success_title: 'Cloudware Technologies!',
									success_message: 'You are doing well!',
									onSuccess: function (data) {
			
										$.ajax({
											url:"ajax/one_time_payment.php",
											method: "POST",
											data: payload,
											success: function(data){
												console.log("Got here 2");
												console.log(data);
												// let data = JSON.parse(res);
												// data = JSON.parse(res);
			
												if(data.status == "success"){
													// alert('saved');
													// console.log('success', data);
													// window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
													setTimeout(() => {
														window.location.href = `http://localhost/zennal/vehicle_payment_callback.php?payment_id="${data.payment_id}"&reg_id="${reg_id}"`;
														//window.location.href = '<?php //echo $redirect_url?>';
														//console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
													}, 200);
													
												}
												else{
													Swal.fire({
														title: "Error!",
														text: data.status,
														icon: "error",
													});
													// setTimeout( function(){ location.reload(); }, 3000)
												}
												$('#submit_insurer_form').attr('disabled', false);
												$('#submit_insurer_form').text('Submit');
											},
											error: function (jqXHR, textStatus, errorThrown) {
												console.log(jqXHR);
												console.log(textStatus);
												console.log(errorThrown);
											}
										})
										
									},
									onClose: function () {
										console.log('closed')
									}
								})
							}else{
								$.ajax({
									url:"ajax/one_time_payment.php",
									method: "POST",
									data: payload,
									success: function(data){
										console.log("Got here 2");
										console.log(data);
										// let data = JSON.parse(res);
										// data = JSON.parse(res);
			
										if(data.status == "success"){
											// alert('saved');
											// console.log('success', data);
											// window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
											setTimeout(() => {
												window.location.href = `http://localhost/zennal/vehicle_payment_callback.php?payment_id="${data.payment_id}"&reg_id="${reg_id}"`;
												//window.location.href = '<?php //echo $redirect_url?>';
												//console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
											}, 200);
											
										}
										else{
											Swal.fire({
												title: "Error!",
												text: data.status,
												icon: "error",
											});
											// setTimeout( function(){ location.reload(); }, 3000)
										}
										$('#submit_insurer_form').attr('disabled', false);
										$('#submit_insurer_form').text('Submit');
									},
									error: function (jqXHR, textStatus, errorThrown) {
										console.log(jqXHR);
										console.log(textStatus);
										console.log(errorThrown);
									}
								})
							}
							
						}else if(paymentOption == "installment"){
							window.location = `vehicle_reg_loan.php?reg_id=${reg_id}`;
						}
					}
					else{
						Swal.fire({
							title: "Error!",
							text: "Record Exists",
							icon: "error",
						});
					}
				}
			})
		}else{
			Swal.fire({
				title: "Error!",
				text: "Select payment option",
				icon: "error",
			});
		}
	})


	$("#vehicle_permit_form").submit(function(e){
		e.preventDefault();
		
		$.ajax({
			url:"ajax/save_vehicle_permit.php",
			method: "POST",
			data: $(this).serialize(),
			beforeSend: function(){
				$("#vehicle_permit_btn").attr("disabled", true);
				$("#vehicle_permit_btn").text("Please wait");
			},
			success: function(data){
				//alert(data);
				let res = JSON.parse(data);
				console.log(res);
				if(res.status == 1){
					Swal.fire({
						title: "Success!",
						text: "Application has been submitted successfully",
						icon: "success",
					});
					setTimeout( function(){ window.location.href = `complete_order.php?rec_id=${res.record_id}&type=vehicle_permit`;}, 3000);
				}
				else{
					Swal.fire({
						title: "Error!",
						text: res.msg,
						icon: "error",
					});
				}
				$("#add_referral").attr("disabled", false);
				$("#add_referral").text("Sumbit");
			}
		})
	});

	$("#add_referral").click(function(e){
		e.preventDefault();
		
		$.ajax({
			url:"ajax_admin/add_referral.php",
			method: "POST",
			data: $("#add_referral_form").serialize(),
			beforeSend: function(){
				$("#add_referral").attr("disabled", true);
				$("#add_referral").text("Adding...");
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! You've successfully added referral bonus");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "add_referral_bonus.php";}, 3000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 3000);
				}
				$("#modal").modal('hide');
				$("#add_referral").attr("disabled", false);
				$("#add_referral").text("Add Referral");
			}
		})
	});

	$("#add_time_frame").click(function(e){
		e.preventDefault();
		
		$.ajax({
			url:"ajax_admin/add_timeframe.php",
			method: "POST",
			data: $("#add_time_frame_form").serialize(),
			beforeSend: function(){
				$("#add_time_frame").attr("disabled", true);
				$("#add_time_frame").text("Submitting...");
			},
			success: function(data){
				//alert(data);
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! You've successfully added referral bonus");
					toastbox('success_toast', 3000);
					setTimeout( function(){ window.location.href = "add_timeframe.php";}, 3000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 3000);
				}
				$("#add_time_frame").attr("disabled", false);
				$("#add_time_frame").text("Submit");
			}
		})
	});

	$("#submit_vehicle_registration").click(function(e){
		e.preventDefault();
		$('#submit_vehicle_registration').attr('disabled', true);
		$('#submit_vehicle_registration').text('Please wait...');
		$.ajax({
			url:"ajax/submit_vehicle_registration.php",
			method: "POST",
			data: $("#vehicle_registration_form").serialize(),
			success: function(data){
				//alert(data);
				if(data['status'] == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "You've submitted your vehicle details",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = "payment?reg_id="+data['data'];}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data['status'],
                        icon: "error",
                    });
				}
				$('#submit_vehicle_registration').attr('disabled', false);
				$('#submit_vehicle_registration').text('Submit');
			}
		})
	});

	// Come here
	$("#apply_coupon_code").click(function(){

		var btn = $(this);

      	var coupon_code = $("#coupon_code").val();
      	var total = $("#total").val();
		if(coupon_code == ''){
			alert("Please enter coupon code");
		}
      	else{
			$.ajax({
				url: "ajax/apply_coupon_code.php",
				method: "POST",
				data: {coupon_code, total, remove_from_wallet: removeFromWallet},
				beforeSend: function(){
				  $("#apply_coupon_code").attr("disabled", true);
				  $("#apply_coupon_code").text("Applying...");
				},
				success: function(data){
					if(data['status'] == "success"){

						couponApplied = 1;
						couponDiscount = data['discount_without_format'];
						currentTotal = data['total_without_format'];

						console.log({couponDiscount, currentTotal});

						$("#coupon_discount").html(data['discount']);
						$("#new_total").html(data['total']);
						// $("#total").val(data['total_without_format']);
						$("#initial_total").val(data['total_without_format']);
						$("#apply_coupon_code").attr("disabled", false);
				  		$("#apply_coupon_code").text("Apply Coupon");

						btn.hide();
						btn.parents(".order-area").find(".remove-coupon").show();
					}
					else{
						Swal.fire({
						title: "Error!",
						text: data['status'],
						icon: "error",
						});
						$("#apply_coupon_code").attr("disabled", false);
				  		$("#apply_coupon_code").text("Apply");
					}
				}
			})
		}
    });

	
	// Come here
    $("#remove_from_wallet").click(function(){
      	var wallet_balance = $("#wallet_balance").val();
      	let total = $("#total").val();
		console.log({total});
      	var initial_total = $("#initial_total").val();

		// if(currentTotal == 0){
		// 	total = total;
		// }else{
		// 	total = currentTotal;
		// }
      	if($('#remove_from_wallet').is(':checked')){
			removeFromWallet = 1;

			$('#remove_from_wallet').val(removeFromWallet);
			
			if(couponApplied == 1){
				total = parseInt(currentTotal); 
			}else{
				if(parseInt(currentTotal) > 0){
					total = parseInt(currentTotal)
				}
				total = parseInt(total) + parseInt(couponDiscount); 
			}

      		if( parseInt(wallet_balance) > parseInt(total) ){
      			var new_total = 0;
      			$("#new_total").html(formatNumber(0));
      		}else{
      			var new_total = parseInt(total - wallet_balance);
				
      			$("#new_total").html(formatNumber(new_total));
			}
			currentTotal = new_total;
      	}else{
			removeFromWallet = 0;
			if(couponApplied == 1){
				if(parseInt(currentTotal) > 0){
					total = parseInt(currentTotal)
				}
				total = parseInt(total) - parseInt(couponDiscount)
			}else{
				console.log("Got here", total);
				total = parseInt(total)
			}
      		$("#new_total").html(formatNumber(total));
			currentTotal = total;
			// $("#total").val(total);
      	}
    });

	// Come here
    $("#proceed_to_payment").click(function(e){
    	e.preventDefault();
		var btn = $(this);
    	$('#proceed_to_payment').attr('disabled', true);
		$('#proceed_to_payment').text('Please wait...');
		var total = $("#total").val();
		var reg_id = $("#reg_id").val();
		var page_name = $("#page_name").val();
		console.log(page_name);

		const couponCode = btn.parents(".order-area").find(".coupon_field").val();
		if(page_name == 'payment'){
			var deliveryType = "physical";
			var service_type = "vehicle_reg";
		}else if(page_name == 'complete_change_ownership_order'){
			var deliveryType = "email";
			var service_type = "change_ownership";
		}

		// const deliveryType = btn.parents(".order-area").find(".delivery_type").val();

		var payLoad = {
			reg_id,
			coupon_applied: couponApplied,
			coupon_code: couponCode,
			remove_from_wallet: removeFromWallet,
			delivery_type: deliveryType,
			service_type: service_type
		}
		console.log(removeFromWallet);
		
		$.ajax({
			url:"ajax/check_veh_reg_exist.php",
			method: "POST",
			data: payLoad,
			success: function(data){
				// alert(data);
				data =  JSON.parse(data)

				if(data.check_status == "false"){
					if(data.total_after_remove_wallet != 0){
						Okra.buildWithOptions({
							name: 'Cloudware Technologies',
							env: 'production-sandbox',
							key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
							token: '5f5a2e5f140a7a088fdeb0ac', 
							source: 'link',
							color: '#ffaa00',
							limit: '24',
							// amount: 5000,
							// currency: 'NGN',
							garnish: true,
							charge: {
							type: 'one-time',
							amount: parseInt(data.total*100),
							note: '',
							currency: 'NGN',
							account: '5ecfd65b45006210350becce'
							},
							corporate: null,
							connectMessage: 'Which account do you want to connect with?',
							products: ["auth", "transactions", "balance"],
							//callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
							//callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
							//redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
							logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
							filter: {
								banks: [],
								industry_type: 'all',
							},
							widget_success: 'Your account was successfully linked to Cloudware Technologies',
							widget_failed: 'An unknown error occurred, please try again.',
							currency: 'NGN',
							exp: null,
							success_title: 'Cloudware Technologies!',
							success_message: 'You are doing well!',
							onSuccess: function (data) {
								console.log('success', data);
								$.ajax({
									url:"ajax/one_time_payment.php",
									method: "POST",
									data: $("#proceed_to_payment_form").serialize(),
									success: function(data){
										//alert(data);
										if(data['status'] == "success"){
											Swal.fire({
												title: "Congratulations!",
												text: "Your payment was successful",
												icon: "success",
											}).then(setTimeout( function(){ window.location.href = "index"}, 3000));
										}
										else{
											Swal.fire({
												title: "Error!",
												text: data['status'],
												icon: "error",
											});
										}
										$('#proceed_to_payment').attr('disabled', false);
										$('#proceed_to_payment').text('Proceed');
									}
								})
							},
							onClose: function () {
								console.log('closed');
								$('#proceed_to_payment').attr('disabled', false);
								$('#proceed_to_payment').text('Proceed');
							}
						})
					}else{
						$("#total").val(data.total);
						$.ajax({
							url:"ajax/one_time_payment.php",
							method: "POST",
							data: $("#proceed_to_payment_form").serialize(),
							success: function(data){
								//alert(data);
								if(data['status'] == "success"){
									Swal.fire({
										title: "Congratulations!",
										text: "Your payment was successful",
										icon: "success",
									}).then(setTimeout( function(){ window.location.href = "index"}, 3000));
								}
								else{
									Swal.fire({
										title: "Error!",
										text: data['status'],
										icon: "error",
									});
								}
								$('#proceed_to_payment').attr('disabled', false);
								$('#proceed_to_payment').text('Proceed');
							}
						})
					}
				}
				else{
					Swal.fire({
						title: "Error!",
						text: "Record Exists",
						icon: "error",
					});
				}
				$('#proceed_to_payment').attr('disabled', false);
				$('#proceed_to_payment').text('Proceed');
			}
		})
		
    })


    $(".proceed_to_payment_btn").click(function(e){
    	e.preventDefault();
		var installment_id = $(this).attr("id");
		var unique_id = $("#unique_id").val();
		$('#'+installment_id).attr('disabled', true);
		$('#'+installment_id).text('Please wait...');
		$.ajax({
			url:"ajax/installmental_payment.php",
			method: "POST",
			data: {unique_id, installment_id},
			success: function(data){
				//alert(data);
				if(parseInt(data['status']) == 200){
					Okra.buildWithOptions({
		                name: 'Cloudware Technologies',
		                env: 'production-sandbox',
		                key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
		                token: '5f5a2e5f140a7a088fdeb0ac', 
		                source: 'link',
		                color: '#ffaa00',
		                limit: '24',
		                // amount: 5000,
		                // currency: 'NGN',
		                garnish: true,
		                charge: {
		                  type: 'one-time',
		                  amount: parseInt(data['data']*100),
		                  note: '',
		                  currency: 'NGN',
		                  account: '5ecfd65b45006210350becce'
		                },
		                corporate: null,
		                connectMessage: 'Which account do you want to connect with?',
		                products: ["auth", "transactions", "balance"],
		                //callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
		                //callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
		                //redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
		                logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
		                filter: {
		                    banks: [],
		                    industry_type: 'all',
		                },
		                widget_success: 'Your account was successfully linked to Cloudware Technologies',
		                widget_failed: 'An unknown error occurred, please try again.',
		                currency: 'NGN',
		                exp: null,
		                success_title: 'Cloudware Technologies!',
		                success_message: 'You are doing well!',
		                onSuccess: function (data) {
		                    console.log('success', data);
		                    // Swal.fire({
		                    //     title: "Congratulations!",
		                    //     text: "You've submitted your vehicle details",
		                    //     icon: "success",
		                    // }).then(setTimeout( function(){ window.location.href = "index"}, 3000));
		                    window.location.href = "repayment_details?unique_id="+unique_id;
		                    //window.location.href = 'http://localhost/new_zennal/online_generation_callback?payment_id='+data.payment_id;
		                    //window.location.href = '<?php //echo $redirect_url?>';
		                    //console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
		                },
		                onClose: function () {
		                    console.log('closed')
		                }
		            })
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data['status'],
                        icon: "error",
                    });
				}
				$('#'+installment_id).attr('disabled', false);
				$('#'+installment_id).text('Proceed');
			}
		})
    })


    $("#submit_vehicle_reg_installment").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		var employment_status = $("#employment_status").val();
		if(employment_status == 1 || employment_status == 4 || employment_status == 5 || employment_status == 6){
			var location = "submit_guarantor";
		}
		else if(employment_status == 2 || employment_status == 3){
			var location = "success";
		}
		$.ajax({
			url:"ajax/submit_vehicle_reg_installment.php",
			method: "POST",
			data: $("#submit_vehicle_reg_installment_form").serialize(),
			beforeSend: function(){
				$('#submit_vehicle_reg_installment').attr('disabled', true);
				$('#submit_vehicle_reg_installment').text('Submitting...');
			},
			success: function(data){
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Your application has been submitted successfully",
                        icon: "success",
                    }).then(setTimeout( function(){ window.location.href = location;}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
				}
				$('#submit_vehicle_reg_installment').attr('disabled', false);
				$('#submit_vehicle_reg_installment').text('Submit');
			}
		})
	});

	$("#accept_vehicle_installment_btn").click(function(){
          $.ajax({
              url: "ajax_admin/accept_vehicle_installment.php",
              method: "POST",
              data:$("#accept_vehicle_installment_form").serialize(),
              beforeSend:function(){
                $("#accept_vehicle_installment_btn").attr("disabled", true);
                $("#accept_vehicle_installment_btn").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully approved this application");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "vehicle_reg_request.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#accept_vehicle_installment_btn").attr("disabled", false);
                $("#accept_vehicle_installment_btn").text("Yes");
              }
          });
      });

	$("#reject_vehicle_installment_btn").click(function(){
          $.ajax({
              url: "ajax_admin/reject_vehicle_installment.php",
              method: "POST",
              data:$("#reject_vehicle_installment_form").serialize(),
              beforeSend:function(){
                $("#reject_vehicle_installment_btn").attr("disabled", true);
                $("#reject_vehicle_installment_btn").text("Please wait...");
              },
              success: function(data){
              	$(".modal").modal('hide');
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! You've successfully rejected this loan application");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "vehicle_reg_request.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#reject_vehicle_installment_btn").attr("disabled", false);
                $("#reject_vehicle_installment_btn").text("Yes");
              }
          });
      });

	$("#update_delivery_fee_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/update_delivery_fee.php",
          method: "POST",
          data:$("#update_delivery_fee_form").serialize(),
          beforeSend:function(){
            $("#update_delivery_fee_btn").attr("disabled", true);
            $("#update_delivery_fee_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully updated delivery fee");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "update_delivery_fee.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#update_delivery_fee_btn").attr("disabled", false);
            $("#update_delivery_fee_btn").text("Update Fee");
          }
      	});
    });

    $("#set_coupon_code_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/add_coupon_code.php",
          method: "POST",
          data:$("#set_coupon_code_form").serialize(),
          beforeSend:function(){
            $("#set_coupon_code_btn").attr("disabled", true);
            $("#set_coupon_code_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully added coupon code");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_coupon_code.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#set_coupon_code_btn").attr("disabled", false);
            $("#set_coupon_code_btn").text("Add Coupon Code");
          }
      	});
    });

    $("#edit_coupon_code_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/edit_coupon_code.php",
          method: "POST",
          data:$("#edit_coupon_code_form").serialize(),
          beforeSend:function(){
            $("#edit_coupon_code_btn").attr("disabled", true);
            $("#edit_coupon_code_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully edited coupon code");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_coupon_code.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#edit_coupon_code_btn").attr("disabled", false);
            $("#edit_coupon_code_btn").text("Edit");
          }
      	});
    });

    $("#delete_coupon_code_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/delete_coupon_code.php",
          method: "POST",
          data:$("#delete_coupon_code_form").serialize(),
          beforeSend:function(){
            $("#delete_coupon_code_btn").attr("disabled", true);
            $("#delete_coupon_code_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully deleted coupon code");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_coupon_code.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#delete_coupon_code_btn").attr("disabled", false);
            $("#delete_coupon_code_btn").text("Edit");
          }
      	});
    });

    $("#add_vehicle_brand_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/add_vehicle_brand.php",
          method: "POST",
          data:$("#add_vehicle_brand_form").serialize(),
          beforeSend:function(){
            $("#add_vehicle_brand_btn").attr("disabled", true);
            $("#add_vehicle_brand_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully added vehicle brand");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "add_vehicle_brand.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#add_vehicle_brand_btn").attr("disabled", false);
            $("#add_vehicle_brand_btn").text("Add Vehicle Brand");
          }
      	});
    });

    $("#add_vehicle_model_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/add_vehicle_model.php",
          method: "POST",
          data:$("#add_vehicle_model_form").serialize(),
          beforeSend:function(){
            $("#add_vehicle_model_btn").attr("disabled", true);
            $("#add_vehicle_model_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully added vehicle model");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "add_vehicle_model.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#add_vehicle_model_btn").attr("disabled", false);
            $("#add_vehicle_model_btn").text("Add Vehicle Model");
          }
      	});
    });

    $("#edit_number_plate_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/edit_number_plate.php",
          method: "POST",
          data:$("#edit_number_plate_form").serialize(),
          beforeSend:function(){
            $("#edit_number_plate_btn").attr("disabled", true);
            $("#edit_number_plate_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully edited price");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_number_plate.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#edit_number_plate_btn").attr("disabled", false);
            $("#edit_number_plate_btn").text("Edit");
          }
      	});
    });

    $("#edit_particulars_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/edit_particular.php",
          method: "POST",
          data:$("#edit_particulars_form").serialize(),
          beforeSend:function(){
            $("#edit_particulars_btn").attr("disabled", true);
            $("#edit_particulars_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully edited price");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_vehicle_particular.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#edit_particulars_btn").attr("disabled", false);
            $("#edit_particulars_btn").text("Edit");
          }
      	});
    });

    $("#edit_service_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/edit_service.php",
          method: "POST",
          data:$("#edit_service_form").serialize(),
          beforeSend:function(){
            $("#edit_service_btn").attr("disabled", true);
            $("#edit_service_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully edited service");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_services.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#edit_service_btn").attr("disabled", false);
            $("#edit_service_btn").text("Edit");
          }
      	});
    });

    $("#add_service_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/add_service.php",
          method: "POST",
          data:$("#add_service_form").serialize(),
          beforeSend:function(){
            $("#add_service_btn").attr("disabled", true);
            $("#add_service_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully added service");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_services.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#add_service_btn").attr("disabled", false);
            $("#add_service_btn").text("Add Service");
          }
      	});
    });

    $("#delete_service_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/delete_service.php",
          method: "POST",
          data:$("#delete_service_form").serialize(),
          beforeSend:function(){
            $("#delete_service_btn").attr("disabled", true);
            $("#delete_service_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully deleted service");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "manage_services.php";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#delete_service_btn").attr("disabled", false);
            $("#delete_service_btn").text("Delete");
          }
      	});
    });

    $("#update_referral_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/update_referral.php",
          method: "POST",
          data:$("#update_referral_form").serialize(),
          beforeSend:function(){
            $("#update_referral_btn").attr("disabled", true);
            $("#update_referral_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully updated referral");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "update_referral_bonus";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#update_referral_btn").attr("disabled", false);
            $("#update_referral_btn").text("Update");
          }
      	});
    });

    $("#edit_installment_interest_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/edit_installment_interest.php",
          method: "POST",
          data:$("#edit_installment_interest_form").serialize(),
          beforeSend:function(){
            $("#edit_installment_interest_btn").attr("disabled", true);
            $("#edit_installment_interest_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully edited Interest");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "set_installment_interest";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#edit_installment_interest_btn").attr("disabled", false);
            $("#edit_installment_interest_btn").text("Edit");
          }
      	});
    });

    $("#hide_installment_interest_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/hide_installment_interest.php",
          method: "POST",
          data:$("#hide_installment_interest_form").serialize(),
          beforeSend:function(){
            $("#hide_installment_interest_btn").attr("disabled", true);
            $("#hide_installment_interest_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully hidden Interest");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "set_installment_interest";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#hide_installment_interest_btn").attr("disabled", false);
            $("#hide_installment_interest_btn").text("Hide");
          }
      	});
    });

    $("#show_installment_interest_btn").click(function(){
      	$.ajax({
          url: "ajax_admin/hide_installment_interest.php",
          method: "POST",
          data:$("#show_installment_interest_form").serialize(),
          beforeSend:function(){
            $("#show_installment_interest_btn").attr("disabled", true);
            $("#show_installment_interest_btn").text("Please wait...");
          },
          success: function(data){
          	$(".modal").modal('hide');
            if(data == "success"){
              $("#success_message").empty();
              $("#success_message").html("Success! You've successfully shown Interest");
              toastbox('success_toast', 3000);
              setTimeout( function(){ window.location.href = "set_installment_interest";}, 3000);
            }
            else{
              $("#error_message").empty();
              $("#error_message").html("Error! " + data);
              toastbox('error_toast', 3000);
            }
            $("#show_installment_interest_btn").attr("disabled", false);
            $("#show_installment_interest_btn").text("Show");
          }
      	});
    });




	//Tosin's code ends


	// Badmus
	$('#add_insurer_form').submit(function(e){
		e.preventDefault();
		$('#submit_insurer_form').attr('disabled', true);
		$('#submit_insurer_form').text('Please wait...');
		var formData = new FormData(this);
		$.ajax({
			url:"ajax_admin/add_insurer.php",
			method: "POST",
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				//alert(data);
				if(data == "success"){
					Swal.fire({
                        title: "Congratulations!",
                        text: "Insurer added successfully",
                        icon: "success",
                    })
					// .then(setTimeout( function(){ window.location.href = "refer";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					// location.reload();
				}
				$('#submit_insurer_form').attr('disabled', false);
				$('#submit_insurer_form').text('Submit');
			}
		});
	});

	$(".select-insurers").change(function(){
		const insurerId = $(this)[0].value;
		console.log(insurerId);
		let plans = $(".selectPackagePlan");
		$(plans).empty();
		plans.append(`<option value="">Select package</option>`);
		$.ajax({
			url:"admin/ajax_admin/get_insurance_plans.php",
			method: "GET",
			data:{insurerId},
			success: function(res){
				const data = JSON.parse(res);
				data.map(plan => {
					plans.append(`
					<option value="${plan.unique_id}">${plan.plan_name}</option>
					`);
				});
			}
		});
	});
// ------
	$("#prefered_insurer").change(function(){
		const insurerId = $(this)[0].value;
		console.log(insurerId);
		let plans = $("#select_plan");
		$(plans).empty();
		plans.append(`<option>Select package</option>`);
		$.ajax({
			url:"admin/ajax_admin/get_insurance_plans.php",
			method: "GET",
			data:{insurerId},
			success: function(res){
				const data = JSON.parse(res);
				data.map(plan => {
					plans.append(`
					<option value="${plan.unique_id}">${plan.plan_name} - ${plan.plan_percentage}%</option>
					`);
				});
			}
		});
	});

	$("#select_plan").change(function(){
		let planId = $(this)[0].value;
		let vehicleValue = $("#vehicle_value")[0].value;

		$.get("admin/ajax_admin/get_vehicle_quote.php", {planId, vehicleValue}, function(data, error){
			console.log(data)
			let premium_amount = formatNumber(JSON.parse(data));
			$("#premium_amount").text(premium_amount);
		});
	});

	$("#vehicle_value").keyup(function() {
		if(! Number($(this).val())){
			$("#help-text").show();
			$("#help-text").text("Please enter a valid vehicle value");
		}else{
			$("#help-text").hide();
		}
	});

	$("#save-quote").click(function(){
		if( $(this).is(':checked') ){
			const quoteForm = $("#vehicle-quote-form").serialize();
			const vehicleValue = $("#vehicle_value").val();
			console.log(vehicleValue);

			if(! Number(vehicleValue)){
				alert("Please enter a valid vehicle value");
			}
			// alert(1);
			$.ajax({
				url: "ajax/save_quote.php",
				method: "POST",
				data:quoteForm,
				beforeSend:function(){
				  $("#save-quote-container").append(`<span class="text-right" id="save-quote-loader">Saving quote...</span>`);
				},
				success: function(data){
				  if(data == "success"){
					$("#save-quote-loader").text("Quote saved");
				  }
				  else{
					$("#save-quote-loader").text("Quote not saved");
				  }
				  setTimeout( function(){ $("#save-quote-loader").remove();}, 3000);
				}
			});
		};
	});

	$("#payment-option").change(function(){
		// alert(1);
		const insurerPlanId = $(".selectPackagePlan")[0].value;
		let paymentType = $(this).find(':selected').attr("data-paymentType");
		// console.log(paymentType);
		// console.log(insurerPlanId);
		let oneTimePay = $("#one-time-payment");
		let installmetalPay = $("#installment-payment");
		$("#installmental-payment-header").empty();
		oneTimePay.empty();
		installmetalPay.empty();
		oneTimePay.append(`
			<div>Please wait...</div>
		`)
		$.ajax({
			url:"ajax/get_insurance_quote.php",
			method: "POST",
			data:$("#buy-package-form").serialize(),
			success: function(res){
				oneTimePay.empty();
				console.log(res+" Got here");
				const data = JSON.parse(res);
				if (data.status == '1'){
					
					if (paymentType == "oneTime") {
						let amount = formatNumber(data.amount_due);
						oneTimePay.append(`
							<tr>
								<td class="text-bold-500">ONE-TIME PAYMENT</td>
								<td>₦ ${amount}</td>
								<td><button class="btn btn-primary" data-insuranceId="${data.insurance_id}" id="one-time-insurance-payment" data-amount="${amount}">BUY NOW</button></td>
							</tr>
						`);
					}else if(paymentType == "installmental"){
						$("#installmental-payment-header").append(`
							<div class="alert alert-light-primary color-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>  30% equity contribution on all Installments.</div>
							<div class="card">
								<div class="card-body">
									<p>Equity Amount: ₦${formatNumber(data.equity_amount)}</p>
									<p>Amount To Balance: ₦${formatNumber(data.amount_to_balance)}</p>
								</div>
							</div>
						`);
						let installment = data.months;
						console.log(installment);

						installment.map(month => {
							let interestPerMonth = ((((month.interest_rate / 100) * data.amount_to_balance)+data.amount_to_balance)/month.month)
							console.log(`${interestPerMonth} per month`);

							var instalmentText = "INSTALLMENT";
							if(month.month != 1){
								instalmentText = "INSTALLMENTs";
							}
							
							installmetalPay.append(`
								<tr>
									<td class="text-bold-500">${month.month} MONTH ${instalmentText}</td>
									<td><span>₦ ${formatNumber(Math.round(interestPerMonth))}/M</span>  <button id="installmental-month" data-equityAmount="${data.equity_amount}" data-installmentalMonth="${month.month}" data-insuranceId="${data.insurance_id}" class="btn btn-primary">BUY NOW</button></td>
								</tr>
							`);
						});
					}
				}else if(data.status == '0'){
					Swal.fire({
                        title: "Error!",
                        text: data.msg,
                        icon: "error",
                    });
				}else{
					oneTimePay.append(`
						<div>Error occured</div>
					`)
				}
					

					// if(installment.length > 0){
					// 	installment.map(payment => {
					// 		installmetalPay.append(`
					// 		<tr>
					// 			<td class="text-bold-500">TWO INSTALLMENTS</td>
					// 			<td>₦29,750</td>
					// 			<td><a href="apply_loan.php"><button class="btn btn-primary">BUY NOW</button></a></td>
					// 	  	</tr>
					// 		`)
					// 	})
					// }
				// }
				// data.map(plan => {
				// 	plans.append(`
				// 	<option value="${plan.unique_id}">${plan.plan_name}</option>
				// 	`);
				// });
			}
		});
	});

	// document.getElementById("buy_now").addEventListener('click', function(){
	// 	alert(1);
	// 	// let amount = $(this).data('amount');
	// 	// alert(amount);
	// });

	// $("#buy_now").click(function(){
	// 	// e.preventDefault();
    //    alert('sdfjsldf');
	// });
	
	$(document).on("click", "#installmental-month", function(){
		const installmentalMonth = $(this).attr("data-installmentalMonth");
		const insuranceId = $(this).attr("data-insuranceId");
		const equityAmount = $(this).attr("data-equityAmount");

		$.ajax({
			url: "ajax/save_installment.php",
			method: "POST",
			data:{insuranceId, installmentalMonth},
			beforeSend:function(){
				$(this).attr("disabled", true);
				$(this).text("Please wait");
			},
			success: function(data){
			  if(data == "success"){
				Okra.buildWithOptions({
					name: 'Cloudware Technologies',
					env: 'production-sandbox',
					key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
					token: '5f5a2e5f140a7a088fdeb0ac', 
					source: 'link',
					color: '#ffaa00',
					limit: '24',
					// amount: 5000,
					// currency: 'NGN',
					garnish: true,
					charge: {
					  type: 'one-time',
					  amount: equityAmount*100,
					  note: '',
					  currency: 'NGN',
					  account: '5ecfd65b45006210350becce'
					},
					corporate: null,
					connectMessage: 'Which account do you want to connect with?',
					products: ["auth", "transactions", "balance"],
					//callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
					//callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
					//redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
					// logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
					logo: 'http://localhost/zennal/assets/images/logozennal.png',
					filter: {
						banks: [],
						industry_type: 'all',
					},
					widget_success: 'Your account was successfully linked to Cloudware Technologies',
					widget_failed: 'An unknown error occurred, please try again.',
					currency: 'NGN',
					exp: null,
					success_title: 'Cloudware Technologies!',
					success_message: 'You are doing well!',
					onSuccess: function (data) {
						console.log('success', data);
						// window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
						window.location.href = `http://localhost/zennal/insurance_payment_callback.php?payment_id="${data.payment_id}"&insurance_id="${insuranceId}"`;
						//window.location.href = '<?php //echo $redirect_url?>';
						//console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
					},
					onClose: function () {
						console.log('closed')
					}
				})
			  }
			//   else{
			// 	$("#save-quote-loader").text("Quote not saved");
			//   }
			//   setTimeout( function(){ $("#save-quote-loader").remove();}, 3000);
			// console.log(data);
			}
		});
		// -----------------------------------------------------------------------------------------------
	});

	$(document).on("click", "#one-time-insurance-payment", function(){
		const amountDue = $(this).attr("data-amount");
		const insuranceId = $(this).attr("data-insuranceId");
		Okra.buildWithOptions({
			name: 'Cloudware Technologies',
			env: 'production-sandbox',
			key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
			token: '5f5a2e5f140a7a088fdeb0ac', 
			source: 'link',
			color: '#ffaa00',
			limit: '24',
			// amount: 5000,
			// currency: 'NGN',
			garnish: true,
			charge: {
			  type: 'one-time',
			  amount: amountDue*100,
			  note: '',
			  currency: 'NGN',
			  account: '5ecfd65b45006210350becce'
			},
			corporate: null,
			connectMessage: 'Which account do you want to connect with?',
			products: ["auth", "transactions", "balance"],
			//callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
			//callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
			//redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
			logo: 'http://localhost/zennal/assets/images/logozennal.png',
			filter: {
				banks: [],
				industry_type: 'all',
			},
			widget_success: 'Your account was successfully linked to Cloudware Technologies',
			widget_failed: 'An unknown error occurred, please try again.',
			currency: 'NGN',
			exp: null,
			success_title: 'Cloudware Technologies!',
			success_message: 'You are doing well!',
			onSuccess: function (data) {
				console.log('success', data);
				// window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
				window.location.href = `http://localhost/zennal/insurance_payment_callback.php?payment_id="${data.payment_id}"&insurance_id="${insuranceId}"`;
				//window.location.href = '<?php //echo $redirect_url?>';
				//console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
			},
			onClose: function () {
				console.log('closed')
			}
		})
		// ----------------------------
	});

	// Badmus
	$("#insurance_interest_form").submit(function(e){
		e.preventDefault();
		$.ajax({
			url: "ajax_admin/set_insurance_interest.php",
			method: "POST",
			data:$(this).serialize(),
			beforeSend:function(){
			  $("#insurance_interest_btn").attr("disabled", true);
			  $("#insurance_interest_btn").text("Please wait");
			},
			success: function(data){
			  if(data == "success"){
				$("#success_message").empty();
				$("#success_message").html("Success! Insurance interest has been updated successfully");
				toastbox('success_toast', 3000);
				setTimeout( function(){ location.reload();}, 3000);
			  }
			  else{
				$("#error_message").empty();
				$("#error_message").html("Error! " + data);
				toastbox('error_toast', 6000);
			  }
			  $("#insurance_interest_btn").attr("disabled", false);
			  $("#insurance_interest_btn").text("Set Rate");
			}
		});
	});


	$("#employment_status").change(function () {
		const employmentStatus = $(this)[0].value;
		
		if (String(employmentStatus) === "unemployed") {
			// alert(employmentStatus);
			$("#occupation-group").hide();
		}else{
			$("#occupation-group").show();
		}
	})

	$("#insurers").change(function(){
		const insurerId = $(this)[0].value;
		console.log(insurerId);
		// alert(insurerId);
		let plans = $("#insurance_package");
		$(plans).empty();
		plans.append(`<option>Select package</option>`);
		$.ajax({
			url:"ajax_admin/get_insurance_plans.php",
			method: "GET",
			data:{insurerId},
			success: function(res){
				const data = JSON.parse(res);
				data.map(plan => {
					plans.append(`
					<option value="${plan.unique_id}">${plan.plan_name}</option>
					`);
				});
			}
		});
	});

	

	$("#product_id_form").submit(function(e) {
		e.preventDefault();
		$('#product_id_btn').attr('disabled', true);
		$('#product_id_btn').text('Please wait...');
		$.ajax({
			url:"ajax_admin/set_product_id.php",
			method: "POST",
              data:$(this).serialize(),
              beforeSend:function(){
                $("#product_id_btn").attr("disabled", true);
                $("#product_id_btn").text("Please wait");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Product id added successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.reload();}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#product_id_btn").attr("disabled", false);
                $("#product_id_btn").text("Save");
              }
		});
	});
	/* Badmus */

	function formatNumber(num){
		num = ""+num;
		return num.replace(/(\d)(?=(\d{3})+(?!\d))/g,'$1,');
	}
});
