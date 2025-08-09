<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Entry Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" rel="stylesheet">
    <style>
        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            position: relative;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .otp-button {
            display: none;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            margin: auto;
            border-radius: 10px;
        }
        .error-message {
            color: red;
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <div class="container centered-form">
        <!--button class="btn btn-secondary back-button" onclick="history.back()">Go Back</!--button-->
        <div class="form-container">
            <h5>Visitor Entry Registration</h5>
            <form id="visitorForm">
                <div class="form-group">
                    <label for="name">Name</label>
                    <textarea class="form-control" id="name" name="name" rows="1" required></textarea>
                    <div id="nameError" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <textarea class="form-control" id="mobile" name="mobile" rows="1" required></textarea>
                    <div id="mobileError" class="error-message"></div>
                    <button type="button" class="btn btn-primary mt-2 otp-button" id="generateOtpBtn" onclick="generateOTP()">Generate OTP</button>
                </div>
                <div id="formSection">
                    <!--div class="form-group">
                        <label for="numPeople">No. of People</label>
                        <select class="form-control" id="numPeople" name="numPeople" required>
                            <option value="">Select number of people</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="numPeopleError" class="error-message"></div>
                    </div-->
                    <div class="form-group">
                        <label for="whomToMeet">Whom To Meet</label>
                        <select id="whomToMeet" name="whomToMeet" class="form-control" placeholder="Select or add a person..." required></select>
                        <div id="whomToMeetError" class="error-message"></div>
                    </div>
                    <!--div class="form-group">
                        <label for="address">Address</label>
                        <select id="address" name="address" class="form-control" placeholder="Select or add an address..." required></select>
                        <div id="addressError" class="error-message"></div>
                    </div-->
                    <div class="form-group">
                        <label for="altMobile">Student/Faculty Mobile Number</label>
                        <textarea class="form-control" id="altMobile" name="altMobile" rows="1" required></textarea>
                        <div id="altMobileError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="purpose">Purpose</label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="2" required></textarea>
                        <div id="purposeError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label>Vehicle</label><br>
                        <input type="radio" name="vehicle" value="Yes" onclick="toggleVehicleNumber(true)"> Yes
                        <input type="radio" name="vehicle" value="No" onclick="toggleVehicleNumber(false)"> No
                    </div>
                    <div class="form-group" id="vehicleNoSection" style="display:none;">
                        <label for="vehicleNo">Vehicle No</label>
                        <textarea class="form-control" id="vehicleNo" name="vehicleNo" rows="1"></textarea>
                        <div id="vehicleNoError" class="error-message"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="otpModal" class="modal">
        <div class="modal-content">
            <h4>Enter OTP</h4>
            <textarea class="form-control" id="otp" name="otp" rows="1" required></textarea>
            <button type="button" class="btn btn-success mt-2" onclick="verifyOTP()">Verify OTP</button>
            <button type="button" class="btn btn-secondary mt-2" onclick="closeOtpModal()">Close</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mobile').on('input', function() {
                if ($(this).val().length > 0) {
                    $('#generateOtpBtn').show();
                } else {
                    $('#generateOtpBtn').hide();
                }
            });

            $('#visitorForm').on('submit', function(e) {
                e.preventDefault();
                clearErrors();
                let isValid = validateForm();
                if (isValid) {
                    $.post('submit.php', $(this).serialize(), function(response) {
                        let result = JSON.parse(response);
                        alert(result.message);
                    });
                }
            });

            const whomToMeetOptions = [
                {value: 'person1', text: 'Person 1'},
                {value: 'person2', text: 'Person 2'},
                {value: 'person3', text: 'Person 3'}
            ];

           const addressOptions = [
    {value: 'Palash Nivas', text: 'Palash Nivas'},
    {value: 'Palash Block D', text: 'Palash Block D'},
    {value: 'Palash Block E', text: 'Palash Block E'},
    {value: 'Kadamba Nivas', text: 'Kadamba Nivas'},
    {value: 'Parijaat Nivas', text: 'Parijaat Nivas'},
    {value: 'Parijaat Block A', text: 'Parijaat Block A'},
    {value: 'Parijaat Block B', text: 'Parijaat Block B'},
    {value: 'Parijaat Block C', text: 'Parijaat Block C'},
    {value: 'Bakul Nivas', text: 'Bakul Nivas'},
    {value: 'Nilgiri Block', text: 'Nilgiri Block'},
    {value: 'Vindhya Block', text: 'Vindhya Block'},
    {value: 'Vindhya A2', text: 'Vindhya A2'},
    {value: 'Vindhya A4', text: 'Vindhya A4'},
    {value: 'Vindhya A6', text: 'Vindhya A6'},
    {value: 'Vindhya C2', text: 'Vindhya C2'},
    {value: 'Vindhya C4', text: 'Vindhya C4'},
    {value: 'Vindhya C6', text: 'Vindhya C6'},
    {value: 'Vindhya Canteen', text: 'Vindhya Canteen'},
    {value: 'Himalaya Block D', text: 'Himalaya Block D'},
    {value: 'Admin Block', text: 'Admin Block'},
    {value: 'Ananda Nivas', text: 'Ananda Nivas'},
    {value: 'Ananda Nivas Block A', text: 'Ananda Nivas Block A'},
    {value: 'Ananda Nivas Block B', text: 'Ananda Nivas Block B'},
    {value: 'Ananda Nivas Block C', text: 'Ananda Nivas Block C'},
    {value: 'Budha Nivas', text: 'Budha Nivas'},
    {value: 'Budha Nivas Block A', text: 'Budha Nivas Block A'},
    {value: 'Budha Nivas Block B', text: 'Budha Nivas Block B'},
    {value: 'Budha Nivas Block C', text: 'Budha Nivas Block C'},
    {value: 'North Mess/South Mess', text: 'North Mess/South Mess'},
    {value: 'Kadamba Mess', text: 'Kadamba Mess'},
    {value: 'Data Center', text: 'Data Center'},
    {value: 'Old Faculty Quarters', text: 'Old Faculty Quarters'},
    {value: 'New Faculty Quarters', text: 'New Faculty Quarters'},
    {value: 'New Faculty Quarters Block A', text: 'New Faculty Quarters Block A'},
    {value: 'New Faculty Quarters Block B', text: 'New Faculty Quarters Block B'},
    {value: 'New Faculty Quarters Block C', text: 'New Faculty Quarters Block C'},
    {value: 'New Faculty Quarters Block D', text: 'New Faculty Quarters Block D'},
    {value: 'New Faculty Quarters Block E', text: 'New Faculty Quarters Block E'}
];

            $('#whomToMeet').selectize({
                create: true,
                sortField: 'text',
                options: whomToMeetOptions
            });

    //        $('#address').selectize({
    //            create: true,
    //            sortField: 'text',
    //            options: addressOptions
     //       });
        });

        function generateOTP() {
            $.post('otp.php', {action: 'generate_otp'}, function(response) {
                let result = JSON.parse(response);
                alert(result.message);
                if (result.status == 'success') {
                    $('#otpModal').show();
                }
            });
        }

        function verifyOTP() {
            let otp = $('#otp').val();
            $.post('otp.php', {action: 'verify_otp', otp: otp}, function(response) {
                let result = JSON.parse(response);
                alert(result.message);
                if (result.status == 'success') {
                    $('#otpModal').hide();
                    $('#formSection').show();
                }
            });
        }


        // addede new functions

//         function sendOTP() {
// 	$(".error").html("").hide();
// 	var number = $("#mobile").val();
// 	if (number.length == 10 && number != null) {
// 		var input = {
// 			"mobile_number" : number,
// 			"action" : "send_otp"
// 		};
// 		$.ajax({
// 			url : 'controller.php',
// 			type : 'POST',
// 			data : input,
// 			success : function(response) {
// 				$(".container").html(response);
// 			}
// 		});
// 	} else {
// 		$(".error").html('Please enter a valid number!')
// 		$(".error").show();
// 	}
// }

// function verifyOTP() {
// 	$(".error").html("").hide();
// 	$(".success").html("").hide();
// 	var otp = $("#otp").val();
// 	var input = {
// 		"otp" : otp,
// 		"action" : "verify_otp"
// 	};
// 	if (otp.length == 6 && otp != null) {
// 		$.ajax({
// 			url : 'controller.php',
// 			type : 'POST',
// 			dataType : "json",
// 			data : input,
// 			success : function(response) {
// 				$("." + response.type).html(response.message)
// 				$("." + response.type).show();
// 			},
// 			error : function() {
// 				alert("ss");
// 			}
// 		});
// 	} else {
// 		$(".error").html('You have entered wrong OTP.')
// 		$(".error").show();
// 	}
// }

        function closeOtpModal() {
            $('#otpModal').hide();
        }

        function toggleVehicleNumber(show) {
            if (show) {
                $('#vehicleNoSection').show();
            } else {
                $('#vehicleNoSection').hide();
            }
        }

        function validateForm() {
            let isValid = true;
            $('#visitorForm textarea, #visitorForm select').each(function() {
                if (!$(this).val()) {
                    let errorId = $(this).attr('id') + 'Error';
                    $('#' + errorId).text('Please fill in the above details to proceed.');
                    isValid = false;
                }
            });
            return isValid;
        }

        function clearErrors() {
            $('.error-message').text('');
        }
    </script>
</body>
</html>
