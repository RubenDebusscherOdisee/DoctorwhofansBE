$(function() {
    // Get the form.
    var form = $('#ajax-contact');

    // Get the messages div.
    var formMessages = $('#editor').innerhtml;

    // Set up an event listener for the contact form.
    $('#SendEmailButton').click(function(event) {
        event.preventDefault();

        // Stop the browser from submitting the form.
        // Serialize the form data.
        if($('#Phone').val()===""){
            var mail={};
            mail.name = $('#name').val();
            mail.subject = $('#subject').val();
            mail.emailToReply = $('#email').val();
            jQuery.get('https://www.doctorwhofans.be/mail.html', function(data) {
                var template= data;
            });
            mail.message = $("#txtEditor").Editor("getText");
            
            // Submit the form using AJAX.
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: mail
            })
            .done(function(response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('error');
                $(formMessages).addClass('success');
                // Set the message text.
                $(formMessages).text(response);
                
                // Clear the form.
                $('#name').val('');
                $('#subject').val('');
                $('#email').val('');
                $('#Phone').val('');
                $("#txtEditor").Editor("setText", "");
            })
            .fail(function(data) {
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('success');
                $(formMessages).addClass('error');
                // Set the message text.
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! An error occured and your message could not be sent.');
                }
            });
        };
    });

});
