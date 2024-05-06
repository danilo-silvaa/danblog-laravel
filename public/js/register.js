$(document).ready(function(){
    $('#submitBtn').click(function(){
        var $btn = $(this);
        const originalText = $btn.text();

        var formData = {
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            email: $('#email').val(),
            password: $('#password').val()
        };

        $('.error').addClass('d-none').text('');

        $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $btn.prop('disabled', true);
        
        $.ajax({
            type: 'POST',
            url: 'register',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                if (response.success) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr) {
                const response = JSON.parse(xhr.responseText);

                const firstNameError = response.errors?.first_name;
                if (firstNameError) {
                    $('#firstNameError').removeClass('d-none');
                    $('#firstNameError').text(firstNameError[0]);
                }

                const lastNameError = response.errors?.last_name;
                if (lastNameError) {
                    $('#lastNameError').removeClass('d-none');
                    $('#lastNameError').text(lastNameError[0]);
                }

                const emailError = response.errors?.email;
                if (emailError) {
                    $('#emailError').removeClass('d-none');
                    $('#emailError').text(emailError[0]);
                }

                const passwordError = response.errors?.password;
                if (passwordError) {
                    $('#passwordError').removeClass('d-none');
                    $('#passwordError').text(passwordError[0]);
                }
            },
            complete: function() {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }
        });
    });
});