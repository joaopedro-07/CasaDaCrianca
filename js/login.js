document.getElementById('cpf').addEventListener('input', function() {
        let v = this.value.replace(/\D/g, '').slice(0, 11);
        if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        this.value = v;
    });

    // Toggle password visibility
    function toggleSenha(btn) {
        const input = btn.closest('.input-wrapper').querySelector('input');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.setAttribute('aria-label', isHidden ? 'Ocultar senha' : 'Mostrar senha');
        // swap icon
        btn.querySelector('svg').innerHTML = isHidden ?
            `<path d="M17.94 17.94A10.07 10.07 0 0112 20C5 20 1 12 1 12a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>` :
            `<path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>`;
    }