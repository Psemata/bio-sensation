$(function() {
    $("#sign_in").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Un email est nécessaire pour se connecter",
                email : "L'adresse email n'est pas valide"
            },
            password: {
                required: "Un mot de passe est nécessaire pour se connecter"
            }
        },
        errorPlacement: function(label, element) {
            label.addClass('errorClass');
            label.insertAfter(element);
        }
    });
});