$(document).ready(function(){

    // $('#myTable').DataTable();

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


	$("#submit_employment_details").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		$.ajax({
			url:"ajax/submit_employment_detail.php",
			method: "POST",
			data: $("#submit_employment_details_form").serialize(),
			success: function(data){
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Your employment details have been successfully submitted and a verification code has been sent to the provided email address");
					toastbox('success_toast', 6000);
					setTimeout( function(){ window.location.href = "verify_otp.php";}, 6000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
			}
		})
	});


	$("#verify_otp").click(function(e){
		e.preventDefault();
		//toastbox('toast-11', 5000);
		$.ajax({
			url:"ajax/verify_otp.php",
			method: "POST",
			data: $("#verify_otp_form").serialize(),
			success: function(data){
				if(data == "success"){
					$("#success_message").empty();
					$("#success_message").html("Success! Your Email Address has been verified, you will be redirected soon");
					toastbox('success_toast', 6000);
					setTimeout( function(){ window.location.href = "financial_records.php";}, 6000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
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
					$("#success_message").empty();
					$("#success_message").html("Sucessful, your repayment details has been sent to your mail, you will be redirected shortly");
					toastbox('success_toast', 6000);
					setTimeout( function(){ window.location.href = "okra_debit_confirmation.php?loan_id="+loan_id}, 6000);
				}
				else{
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
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
		$.ajax({
			url:"ajax/submit_loan_purpose.php",
			method: "POST",
			data: $("#submit_loan_purpose_form").serialize(),
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
        $.ajax({
              url: "ajax/online_bank_statement.php",
              method: "POST",
              data: $("#submit_loan_purpose_form").serialize(),
              beforeSend:function(){
                // $("#online_bank_statement_btn").attr("disabled", true);
                $("#online_bank_statement").text("Please wait...");
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
                $("#online_bank_statement").text("Click here to pay");
              }
         });
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
			beforeSend: function(){
				$("#submit_guarantor").attr("disabled", "true");
				$("#button_spinner").css('display', 'block');
				$("#submit_guarantor").text("Submitting...");
			},
			url:"ajax/submit_guarantor.php",
			method: "POST",
			data: $("#submit_guarantor_form").serialize(),
			success: function(data){
				if(data == "error"){
					$("#error_message").empty();
					$("#error_message").html("Error! " + data);
					toastbox('error_toast', 6000);
				}
				else{
					$("#success_message").empty();
					$("#success_message").html("Your Guarantors details have been submitted successfully, you will be redirected to pay your equity contribution shortly ");
					toastbox('success_toast', 10000);
					setTimeout( function(){ window.location.href = data;}, 3000);
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
                    }).then(setTimeout( function(){ window.location.href = "index.php";}, 3000));
				}
				else{
					Swal.fire({
                        title: "Error!",
                        text: data,
                        icon: "error",
                    });
					location.reload();
				}
			}
		})
	});

	// Insurance 

	$("#vehicle_info_form").submit(function(e){
		e.preventDefault();
		$("#submit-vehicle-info").attr("disabled", true);
		var vehicleInfoObj = {};
		var info = $(this).serializeArray();

		info.map(item =>{
			vehicleInfoObj[item["name"]] = item["value"];
		});

		console.log(vehicleInfoObj);

		localStorage.setItem("vehicleInfo", JSON.stringify(vehicleInfoObj));
		//alert("saved");
		setTimeout(() => window.location = "vehicle_attachments.php", 1000);
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
	
	$("#add_insurance_category").click(function(){
          $.ajax({
              url: "ajax_admin/ajax_add_insurance_category.php",
              method: "POST",
              data:$("#set_packages_form").serialize(),
              beforeSend:function(){
                $("#add_insurance_category").attr("disabled", true);
                $("#add_insurance_category").text("Adding...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Insurance category has been created successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "add_insurance_category.php";}, 3000);
                }
                else{
                  $("#error_message").empty();
                  $("#error_message").html("Error! " + data);
                  toastbox('error_toast', 6000);
                }
                $("#add_insurance_category").attr("disabled", false);
                $("#add_insurance_category").text("Create Category");
              }
          });
      });
      
      $("#add_insurance_benefit").click(function(){
          $.ajax({
              url: "ajax_admin/ajax_add_insurance_benefit.php",
              method: "POST",
              data:$("#insurance_benefit_form").serialize(),
              beforeSend:function(){
                $("#add_insurance_benefit").attr("disabled", true);
                $("#add_insurance_benefit").text("Adding...");
              },
              success: function(data){
                if(data == "success"){
                  $("#success_message").empty();
                  $("#success_message").html("Success! Insurance benefit has been created successfully");
                  toastbox('success_toast', 3000);
                  setTimeout( function(){ window.location.href = "add_insurance_benefit.php";}, 3000);
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
	/* Badmus */
});
