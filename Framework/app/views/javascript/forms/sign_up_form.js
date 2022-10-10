$(function() {
    $("#sign_up").validate({
        rules: {
            username: {
                required : true,
                minlength: 5
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            username: {
                required: "Veuillez entrer un pseudo",
                minlength: "Un pseudo plus long est requis"
            },
            email: {
                required: "Un email est requis",
                email: "Ceci n'est pas un email"
            },
            password: {
                required: "Un mot de passe est nécessaire",
                minlength: "Le mot de passe est trop court"
            },
            password_confirmation: {
                required: "Veuillez confirmer votre mot de passe",
                equalTo: "La confirmation est différente de l'original"
            }
        },
        errorPlacement: function(label, element) {
            label.addClass('errorClass');
            label.insertAfter(element);
        }
    });
});