// form-script.js

document.addEventListener('DOMContentLoaded', function() {
    // --- Parte 1: Controle do Modal ---
    const modal = document.getElementById('contactModal');
    const btn = document.getElementById('openModalBtn');
    const span = document.querySelector('.close');

    // Verifica se os elementos existem antes de adicionar os event listeners
    if (btn && modal && span) {
        btn.addEventListener('click', function() {
            modal.style.display = "flex";
        });

        span.addEventListener('click', function() {
            modal.style.display = "none";
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    } else {
        console.warn('Um ou mais elementos do modal não foram encontrados. Verifique os IDs e classes.');
    }

    // --- Parte 2: Medidas Anti-Bot ---

    // Captura o momento em que o formulário foi carregado
    const form = document.getElementById('contact-form');
    if (form) {
        const formLoadedAt = Date.now();
        const formLoadedAtInput = document.getElementById('form_loaded_at');
        if (formLoadedAtInput) {
            formLoadedAtInput.value = formLoadedAt;
            console.log("form_loaded_at set to:", formLoadedAt); // Para depuração
        } else {
            console.warn('Campo oculto "form_loaded_at" não encontrado no formulário.');
        }

        // Temporizador de Submissão
        form.addEventListener('submit', function(event) {
            const currentTime = Date.now();
            const formLoadedAtValue = parseInt(document.getElementById('form_loaded_at').value, 10);
            const timeDiff = (currentTime - formLoadedAtValue) / 1000; // tempo em segundos

            if (formLoadedAtValue === 0 || timeDiff < 5) {  // Se o formulário for enviado em menos de 5 segundos, bloqueie o envio.
                alert("Você está preenchendo o formulário rápido demais! Por favor, tente novamente.");
                event.preventDefault();  // Impede o envio
                return;
            }

            // Verificação adicional do Honeypot no frontend
            const honeypot = document.getElementById('honeypot');
            if (honeypot && honeypot.value !== "") {
                alert("Erro: Formulário inválido.");
                event.preventDefault();
                return;
            }
        });

        // Validações em tempo real dos campos

        // Validação do campo telefone
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function() {
                const telefone = this.value;
                const regex = /^\d{9}$/;
                
                if (!regex.test(telefone)) {
                    this.setCustomValidity('O telefone deve conter 9 números.');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Validação do campo estado
        const estadoInput = document.getElementById('estado');
        if (estadoInput) {
            estadoInput.addEventListener('input', function() {
                const estado = this.value;
                const regex = /^[A-Za-z]{2}$/;

                if (!regex.test(estado)) {
                    this.setCustomValidity('O estado deve ter 2 letras.');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
        
        // Validação do campo cidade
        const cidadeInput = document.getElementById('cidade');
        if (cidadeInput) {
            cidadeInput.addEventListener('input', function() {
                const cidade = this.value;
                const regex = /^[A-Za-zÀ-ÿ\s]+$/;

                if (!regex.test(cidade)) {
                    this.setCustomValidity('A cidade deve conter apenas letras.');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

    } else {
        console.warn('Formulário com ID "contact-form" não encontrado.');
    }
});
