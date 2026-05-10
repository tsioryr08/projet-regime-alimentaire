

    function validateField(field, value) {
        const name = field.getAttribute('name');
        const errorSpan = document.querySelector(`.error[data-field="${name}"]`);
        
        if (!errorSpan) return true;
        
        switch(name) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    errorSpan.textContent = 'L\'email est obligatoire.';
                    return false;
                }
                if (!emailRegex.test(value)) {
                    errorSpan.textContent = 'Email invalide.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'password':
                if (!value) {
                    errorSpan.textContent = 'Le mot de passe est obligatoire.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
        }
        return true;
    }

    document.querySelectorAll('input').forEach(field => {
        if (field.getAttribute('name')) {
            field.addEventListener('blur', function() {
                validateField(this, this.value);
                if (this.value && validateField(this, this.value)) {
                    this.classList.remove('invalid');
                } else if (this.value) {
                    this.classList.add('invalid');
                }
            });
            
            field.addEventListener('input', function() {
                if (this.value && validateField(this, this.value)) {
                    this.classList.remove('invalid');
                    const errorSpan = document.querySelector(`.error[data-field="${this.getAttribute('name')}"]`);
                    if (errorSpan && errorSpan.textContent) {
                        errorSpan.textContent = '';
                    }
                }
            });
        }
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        let valid = true;
        const inputs = document.querySelectorAll('input[name="email"], input[name="password"]');
        
        inputs.forEach(input => {
            const isValid = validateField(input, input.value);
            if (!isValid) {
                valid = false;
                input.classList.add('invalid');
            } else {
                input.classList.remove('invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
        }
    });
