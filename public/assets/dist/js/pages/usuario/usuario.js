$(document).ready(function () {
    $(function () {

        "use strict";

        ns.comboBoxSelectTags("emp_id", "/empresa/obter-empresas", "emp_id");

        // Mostra ou esconde os campos do banco principal ao mudar o select
        $('#user_cdgbc').on('change', function () {
            if ($(this).val()) {
                $('#banco-principal').show();
            } else {
                $('#banco-principal').hide();
            }
        });

        // Garante o estado correto ao carregar a página (caso haja valor já selecionado)
        if ($('#user_cdgbc').val()) {
            $('#banco-principal').show();
        } else {
            $('#banco-principal').hide();
        }

        $('input[type=email], input[type=password]').attr('autocomplete', 'off');

        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility(inputId, inputIdR) {
            const input = document.getElementById(inputId);
            const inputR = document.getElementById(inputIdR);
            if (input.type === "password" || inputR.type === "password") {
                input.type = "text";
                inputR.type = "text";
                $('.eye').find("i").removeClass("fa-eye-slash");
                $('.eye').find("i").addClass("fa-eye");
            } else {
                input.type = "password";
                inputR.type = "password";
                $('.eye').find("i").removeClass("fa-eye");
                $('.eye').find("i").addClass("fa-eye-slash");
            }
        }

        // Adicionando eventos de clique para os ícones de visualização de senha
        $('body').on('click', '.eye', function () {
            togglePasswordVisibility('user_pass', 'confirm_password');
        });

        ns.iniciarlizarMascaras();

        bsCustomFileInput.init();

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "5500",
            "timeOut": "5500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $('#message').css('display', 'none');

        function readURLProduct(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#image-product").attr("src", e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFile").change(function () {
            readURLProduct(this);
        });


        $('body').on('click', '#showPassword', function (e) {
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            $('#showConfirmPassword').find("i").toggleClass("fa-eye fa-eye-slash");
            var type = $('#password')
            if (type.attr('type') == 'password') {
                type.attr('type', 'text')
                $('#confirm_password').attr('type', 'text')
            } else {
                type.attr('type', 'password')
                $('#confirm_password').attr('type', 'password')
            }
        });

        $('body').on('click', '#showConfirmPassword', function (e) {
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            $('#showPassword').find("i").toggleClass("fa-eye fa-eye-slash");
            var type = $('#confirm_password')
            if (type.attr('type') == 'password') {
                type.attr('type', 'text')
                $('#password').attr('type', 'text')
            } else {
                type.attr('type', 'password')
                $('#password').attr('type', 'password')
            }
        });

        //crie uma contagem regressiva para o botão de enviar email com o texto "Reenviar Email após X segundos"
        function startCountdown(button, seconds) {
            var countdown = seconds;
            button.prop('disabled', true);
            button.text(`Reenviar Email após ${countdown} segundos`);
            var interval = setInterval(function () {
                countdown--;
                button.text(`Reenviar Email após ${countdown} segundos`);
                if (countdown <= 0) {
                    clearInterval(interval);
                    button.prop('disabled', false);
                    button.text("Enviando a Solicitação de Cadastro por Email");
                }
            }, 1000);
        }

        $('body').on('click', '#btnExcluir', function (e) {
            e.preventDefault();
            Pace.restart();
            Pace.track(function () {
                $('#user_sts').val('EX');
                $('#user_sts').trigger('change');
                $('#btnSalvar').trigger('click');
                $("#btnExcluir").prop('disabled', true);
            });
        });

        $('body').on('click', '#btnInativar', function (e) {
            console.log($(this).text())
            var status = $(this).text().trim();

            e.preventDefault();
            Pace.restart();
            Pace.track(function () {
                if (status === 'Ativar') {
                    $('#user_sts').val('AT');

                    $("#btnInativar").text("Inativar");
                    $("#btnInativar").prepend('<i class="fa fa-check"></i> ');
                } else if (status === 'Inativar') {
                    $('#user_sts').val('IN');
                    $("#btnInativar").text("Ativar");
                    $("#btnInativar").prepend('<i class="fa fa-ban"></i> ');

                }
                $("#btnExcluir").prop('disabled', false);

                $('#user_sts').trigger('change');
                $('#btnSalvar').trigger('click');

            });
        });

        // Envio de email para redefinição de senha
        $('body').on('click', '#btnEnviarSenha', function (e) {

            e.preventDefault();
            Pace.restart();
            Pace.track(function () {

                var user_email = $('#user_email').val();
                if (user_email) {
                    $("#btnEnviarSenha").text("Enviando a Solicitação de Cadastro por Email");
                    $("#btnEnviarSenha").desabilitar();
                    startCountdown($("#btnEnviarSenha"), 60); // Inicia a contagem regressiva de 60 segundos
                    $.ajax({
                        url: '/usuario/send-reset-link-email',
                        type: 'POST',
                        data: {
                            user_email: user_email,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $("#btnEnviarSenha").text("Enviar Solicitação de Cadastro por Email");
                            $("#btnEnviarSenha").habilitar();
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message);
                            $("#btnEnviarSenha").text("Enviar Solicitação de Cadastro por Email");
                            $("#btnEnviarSenha").habilitar();
                        }
                    });
                } else {
                    toastr.error('Por favor, insira um email válido.');
                }
            });

        });

        $('#emp_id').on('select2:select', function (e) {
            //console.log('select event');
            var data = e.params.data;
            //console.log(data);
            $("#user_resp").desabilitar();

            Pace.restart();
            Pace.track(function () {
                var token = $('meta[name="csrf-token"]').attr(
                    "content"
                );
                var url = "/usuario/get-users-from-espresa/" + data.id;
                //console.log(url)
                $.ajax({
                    header: {
                        "X-CSRF-TOKEN": token,
                    },
                    dataType: 'json',
                    url: url,
                    type: "get",
                    processData: false,
                    contentType: false,
                })
                    .done(function (response) {

                        //console.log(response);
                        $("#user_resp").empty();
                        $('#user_resp').select2('destroy');
                        $("#user_resp").select2({
                            data: response
                        });

                        $("#user_resp").habilitar();
                    })
                    .fail(function (xhr, status, error) {
                        $("#user_resp").habilitar();

                        if (xhr.status === 401 || xhr.responseJSON.message === "CSRF token mismatch.") {
                            Swal.fire({
                                title: "Erro",
                                text:
                                    "Sua sessão expirou, é preciso fazer o login novamente.",
                                icon: "error",
                                showCancelButton: false,
                                allowOutsideClick: false,
                            }).then(function (result) {
                                $.limparBloqueioSairDaTela();
                                location.reload();
                            });
                        } else if (xhr.status == 400) {
                            Swal.fire(
                                "Oops...",
                                xhr.responseJSON.message,
                                "error"
                            );
                        } else if (xhr.status == 422) {
                            Swal.fire(
                                "Oops...",
                                xhr.responseJSON.message,
                                "error"
                            );
                        }
                        else if (xhr.status == 406) {
                            Swal.fire(
                                "Oops...",
                                xhr.responseJSON.message,
                                "error"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Algo deu errado!",
                                "error"
                            );
                        }
                    });
            });
        });

    });
});
