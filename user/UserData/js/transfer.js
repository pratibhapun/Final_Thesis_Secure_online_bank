$(document).ready(function () {

    console.log("hello");
    $("#Transfer").addClass("active");

    $("#AccountNo").bind("contextmenu", function (e) {
        return false;
    });

    $("#AccountNo").keyup(function () {
        let AccountNo = $(this).val();

        if (AccountNo.length == 12) {

            console.log(AccountNo);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: { AcNo: AccountNo },
                dataType: "json",
                success: function (response) {

                    if (response["Flag"] != "fail") {

                        popFlag = 1;

                        $("#AcError").text("");
                        let Fname = response["Fname"];
                        let Lname = response["Lname"];
                        let AdharNo = response["AdharNo"];
                        let PanNo = response["PanNo"];
                        let MobileNo = response["MobileNo"];
                        let Balance = response["Balance"];
                        let Status = response["Status"];

                        $("#info").attr("hidden", false);
                        $('#AccountNo').addClass("border-right-0");

                        $('#AccountNo').popover({

                            title: 'Account Holder Detail',
                            html: true,
                            container: "body",
                            placement: 'right',
                            content: `<p><strong>First Name: </strong> ${Fname}</p> 
                                    <p><strong>Last Name: </strong>${Lname}</p> 
                                    <p><strong>Mobile Number: </strong>${MobileNo}</p>`


                        })
                    }
                    else {
                        $('#AccountNo').popover('hide');
                        $("#AcError").text("Account Number Not Found. Note: Refresh The Page for next account no");

                    }
                }
            });


        }
    });

    $("#info").click(function () {
        $('#AccountNo').popover('toggle')

    });


    $("#Amount").on({
        click: function () {
            $('#AccountNo').popover('hide')
            // $('#AccountNo').popover('toggle')
        },

        keyup: function () {
            let Amount = $(this).val();

            if (Amount > 0) {
                $("#AmountError").text("");

                let AccountNo = $("#AccountNo").val();
            }
            else {
                $("#AmountError").text("Please Enter Minimum 1 rupees");
            }
            
        }

    });



    $("#Pay").click(function () {
        
        let Amount = $("#Amount").val();
        let AccountNo = $("#AccountNo").val();
        if (AccountNo != "") {
            $("#AcError").text("");

            if (Amount > 0) {
                $("#AmountError").text("");

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Are you sure to Transfer of Amount" + "   " + "₹" + Amount,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: "POST",
                            url: "code.php",
                            data: { AcState: AccountNo },
                            success: function (response) {

                                let Status = response;
                                console.log(Status)

                                if (Status == "Active") {


                                    $.ajax({

                                        type: "POST",
                                        url: "code.php",
                                        data: { TransactionOtp: AccountNo },
                                        success: function (response) {
                                            console.log("i work");
                                            console.log(response);

                                            if (response == "done") {
                                                let timerInterval
                                                Swal.fire({
                                                    title: 'Confirm OTP',
                                                    html: 'otp will expired in <b></b> milliseconds.',
                                                    timer: 60000,
                                                    timerProgressBar: true,
                                                    input: 'number',
                                                    showConfirmButton: true,
                                                    confirmButtonText: 'Submit',

                                                    didOpen: () => {

                                                        const b = Swal.getHtmlContainer().querySelector('b')
                                                        timerInterval = setInterval(() => {
                                                            b.textContent = Swal.getTimerLeft()
                                                        }, 100)
                                                    },
                                                    willClose: () => {
                                                        clearInterval(timerInterval)

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "code.php",
                                                            data: { optExpire: "expire" },
                                                            success: function (response) {
                                                                // console.log("unset");
                                                            }
                                                        });



                                                    }
                                                }).then((result) => {
                                                    /* Read more about handling dismissals below */


                                                    if (result.isConfirmed) {

                                                        let enterOtp = result.value;

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "code.php",
                                                            data: { ValidateOtp: enterOtp },
                                                            success: function (response) {
                                                                console.log(response);
                                                                if (response == "done") {

                                                                    $("#AcError").text("");

                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "code.php",
                                                                        data: {
                                                                            DepositAc: AccountNo,
                                                                            MainAmount: Amount
                                                                        },
                                                                        cache: false,
                                                                        beforeSend: function () {
                                                                            $('.modal').modal('show');
                                                                        },
                                                                        complete: function () {
                                                                            $('.modal').modal('hide');
                                                                        },
                                                                        success: function (response) {
                                                                            console.log(response);
                                                                            if (response == "Success") {
                                                                                Swal.fire({
                                                    
                                                                                    icon: 'success',
                                                                                    title: 'Transaction Successfull',
                                                                                    showConfirmButton: false,
                                                                                    timer: 1500
                                                                                  })
                                                                                setTimeout(function () {

                                                                                    location.reload();

                                                                                }, 2000);
                                                                                
                                                                                console.log(response);
                                                                                
                                                                            }
                                                                            else {
                                                                                Swal.fire({
                                                                                   
                                                                                    icon: 'error',
                                                                                    title: 'Transaction Fail !',
                                                                                    showConfirmButton: false,
                                                                                    timer: 1500
                                                                                  })

                                                                                  setTimeout(function () {

                                                                                    location.reload();

                                                                                }, 2000);

                                                                            }
                                                                        }
                                                                    });



                                                                }
                                                                else {
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Oops...',
                                                                        text: 'Invalid OTP!',

                                                                    })
                                                                }

                                                            }
                                                        });

                                                        console.log(result.value);
                                                    }


                                                })
                                            }

                                        }
                                    });


                                }
                                else {
                                    $("#AcError").text("");
                                }
                            }
                        });

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        )
                    }
                });

            }
            else {
                $("#AmountError").text("Please Enter Minimum 100 rupees");
            }
        }
        else {
            $("#AcError").text("Account Number Cannot Empty");

        }

    });

});