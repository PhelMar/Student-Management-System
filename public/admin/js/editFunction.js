$(document).ready(function () {
    const successAlert = $('#success-alert');
    if (successAlert.length) {
        setTimeout(function () {
            successAlert.fadeOut();
            $('#updateStudentForm')[0].reset();
        }, 3000);
    }
});

function toggleRemarks(remarksId, value) {
    const remarksDiv = document.getElementById(remarksId);
    const remarksInput = remarksDiv.querySelector("input");

    if (value === "Yes") {
        remarksDiv.style.display = "block";
        remarksInput.setAttribute("required", "required");
    } else {
        remarksDiv.style.display = "none";
        remarksInput.removeAttribute("required");
        remarksInput.value = "";
    }
}
document.addEventListener('DOMContentLoaded', function () {
    toggleRemarks('pwd_remarks', document.getElementById('pwd').value);
    toggleRemarks('ips_remarks', document.getElementById('ips').value);
});


$(document).ready(function () {
    function checkEmail() {
        const email = $('#email_address').val();
        const emailAddressErrorElement = $('#email_address_error');
        const emailErrorElement = $('#email_error');

        emailAddressErrorElement.text('');
        emailErrorElement.hide();
        $('#email_address').removeClass('is-invalid');

        if (!/^[a-zA-Z0-9._]+@gmail\.com$/.test(email)) {
            emailAddressErrorElement.text('Email address must end with @gmail.com');
            $('#email_address').addClass('is-invalid');
            return;
        }
    }
    $('#email_address').on('input', checkEmail);
});

$(document).ready(function () {
    $('#contact_no').on('input', function () {
        const contactNoInput = $(this).val();
        const contact_no_errorElement = $('#contactNoError');

        contact_no_errorElement.text('');
        $(this).removeClass('is-invalid');

        if (!/^0\d{10}$/.test(contactNoInput)) {
            contact_no_errorElement.text('Contact No. must be 11 digits with start 0');
            $(this).addClass('is-invalid');
        }
    });

    $('#incase_of_emergency_contact').on('input', function () {
        const emergencyContactInput = $(this).val();
        const emergencyContactError = $('#incase_of_emergency_contact_Error');

        emergencyContactError.text('');
        $(this).removeClass('is-invalid');

        if (!/^0\d{10}$/.test(emergencyContactInput)) {
            emergencyContactError.text('Contact no. must be 11 digits and start 0');
            $(this).addClass('is-invalid');
        }
    });

    $('#fathers_contact_no').on('input', function () {
        const fathersContactInput = $(this).val();
        const fathersContactError = $('#fathers_contactNoError');

        fathersContactError.text('');
        $(this).removeClass('is-invalid');

        if (!/^0\d{10}$/.test(fathersContactInput)) {
            fathersContactError.text('Contact no. must be 11 digits and start 0');
            $(this).addClass('is-invalid');
        }
    });

    $('#mothers_contact_no').on('input', function () {
        const mothersContactInput = $(this).val();
        const mothersContactError = $('#mothers_contactNoError');

        mothersContactError.text('');
        $(this).removeClass('is-invalid');

        if (!/^0\d{10}$/.test(mothersContactInput)) {
            mothersContactError.text('Contact no. must be 11 digits and start 0');
            $(this).addClass('is-invalid');
        }
    });

    $('#birth_order_among_sibling').on('input', function () {
        const birthOrderInput = $(this).val();
        const birthOrderError = $('#birth_order_Error');

        birthOrderError.text('');
        $(this).removeClass('is-invalid');

        if (!/^[0-9]+$/.test(birthOrderInput)) {
            birthOrderError.text('Enter digits only');
            $(this).addClass('is-invalid');
        }
    });

    $('#id_no').on('input', function () {
        const idNoInput = $(this).val();
        const idNoError = $('#idNoError');

        idNoError.text('');
        $(this).removeClass('is-invalid');

        if (!/^202\d{7}$/.test(idNoInput)) {
            idNoError.text('Invalid input ID type!');
            $(this).addClass('is-invalid');
        }
    });

    $('#number_of_fathers_sibling').on('input', function () {
        const numberOfFathersSiblingInput = $(this).val();
        const numberOfFathersSiblingError = $('#number_of_fathers_sibling_Error');

        numberOfFathersSiblingError.text('');
        $(this).removeClass('is-invalid');

        if (!/^[0-9]+$/.test(numberOfFathersSiblingInput)) {
            numberOfFathersSiblingError.text('Enter digits only!');
            $(this).addClass('is-invalid');
        }
    });

    $('#number_of_mothers_sibling').on('input', function () {
        const numberOfMothersSiblingInput = $(this).val();
        const numberOfMothersSiblingError = $('#number_of_mothers_sibling_Error');

        numberOfMothersSiblingError.text('');
        $(this).removeClass('is-invalid');

        if (!/^[0-9]+$/.test(numberOfMothersSiblingInput)) {
            numberOfMothersSiblingError.text('Enter digits only!');
            $(this).addClass('is-invalid');
        }
    });
});

$(document).ready(function () {
    $('#email_address').on('input', function () {
        const emailAddressInput = $(this).val();
        const email_address_errorElement = $('#email_address_error');

        email_address_errorElement.text('');
        $(this).removeClass('is-invalid');

        if (!/^[a-zA-Z0-9._]+@gmail\.com$/.test(emailAddressInput)) {
            email_address_errorElement.text('Email address must end @gmail.com');
            $(this).addClass('is-invalid');
        }

    });
});

$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    function checkEmail() {
        const email = $('#email_address').val();
        const emailAddressErrorElement = $('#email_address_error');
        const emailErrorElement = $('#email_error');

        emailAddressErrorElement.text('');
        emailErrorElement.hide();
        $('#email_address').removeClass('is-invalid');

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailAddressErrorElement.text('Please enter a valid email address');
            $('#email_address').addClass('is-invalid');
            return;
        }

        if (email && email.length > 0) {
            $.ajax({
                url: checkEmailUrl,
                method: 'POST',
                data: {
                    email: email,
                    _token: csrfToken
                },
                success: function (response) {
                    if (response.exists) {
                        $('#email_address').addClass('is-invalid');
                        emailErrorElement.show();
                    } else {
                        emailErrorElement.hide();
                    }
                },
                error: function (xhr, status, error) {
                    $('#email_address').addClass('is-invalid');
                    emailErrorElement.text('An error occurred while checking the email. Please try again.').show();
                }
            });
        }
    }
    $('#email_address').on('input', checkEmail);
});

$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('#id_no').on('change', function () {
        var idNo = $(this).val();
        var studentId = '{{ $student->id }}';

        if (!/^[a-zA-Z0-9]+$/.test(idNo)) {
            $('#idNoError').text('Invalid ID format.').show();
            $('#id_no').addClass('is-invalid');
            return;
        }

        $.ajax({
            url: checkIDNoUrl,
            type: 'POST',
            data: {
                id_no: idNo,
                student_id: studentId,
                _token: csrfToken
            },
            success: function (response) {
                if (response.exists) {
                    $('#idNoError').text('This ID number is already taken.').show();
                    $('#id_no').addClass('is-invalid');
                } else {
                    $('#idNoError').hide();
                    $('#id_no').removeClass('is-invalid');
                }
            },
            error: function (xhr, status, error) {
                $('#idNoError').text('An error occurred while checking the ID number. Please try again.').show();
                $('#id_no').addClass('is-invalid');
            }
        });
    });

    let currentStep = 1;

    function showStep(step) {
        $(".step").hide();
        $(`[data-step="${step}"]`).show();
    }

    $(".next").click(function (e) {
        e.preventDefault();

        const valid = validateStep(currentStep);
        if (valid) {
            currentStep++;
            showStep(currentStep);
        }

        toggleButtons();
    });

    $(".back").click(function (e) {
        e.preventDefault();

        currentStep--;
        showStep(currentStep);

        toggleButtons();
    });

    function validateStep(step) {
        let isValid = true;

        const fields = $(`[data-step="${step}"]`).find("[required]");

        fields.each(function () {
            const field = $(this);
            const value = field.val()?.trim();
            const errorMessage = field.siblings(".error-message");

            if (!value) {
                isValid = false;
                errorMessage.text(`${field.attr("name").replace("_", " ")} is required.`);
            } else {
                errorMessage.text("");
            }
        });

        return isValid;
    }

    $(document).keydown(function (e) {
        if ((e.key === "Enter" || e.keyCode === 13) && $(".next:visible").length > 0) {
            e.preventDefault();

            const valid = validateStep(currentStep);
            if (valid) {
                $(".next:visible").click();
            }
        }
    });

    function toggleButtons() {
        const totalSteps = $(".step").length;

        if (currentStep === 1) {
            $(".back").hide();
            $(".next").show();
        } else if (currentStep === totalSteps) {
            $(".next").hide();
            $(".back").show();
            $("button[type='submit']").show();
        } else {
            $(".back").show();
            $(".next").show();
            $("button[type='submit']").hide();
        }
    }
    showStep(currentStep);
    toggleButtons();

});






