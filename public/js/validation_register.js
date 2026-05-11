    let currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        let x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        if (n === 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n === (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Créer mon compte";
        } else {
            document.getElementById("nextBtn").innerHTML = "Suivant";
        }

        fixStepIndicator(n);
    }

    function validateField(field, value) {
        const name = field.getAttribute('name');
        const errorSpan = document.querySelector(`.error[data-field="${name}"]`);
        
        if (!errorSpan) return true;
        
        switch(name) {
            case 'nom':
                if (!value.trim()) {
                    errorSpan.textContent = 'Le nom est obligatoire.';
                    return false;
                }
                if (value.trim().length < 2) {
                    errorSpan.textContent = 'Le nom doit contenir au moins 2 caractères.';
                    return false;
                }
                if (value.trim().length > 100) {
                    errorSpan.textContent = 'Le nom ne doit pas dépasser 100 caractères.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'prenom':
                if (!value.trim()) {
                    errorSpan.textContent = 'Le prénom est obligatoire.';
                    return false;
                }
                if (value.trim().length < 2) {
                    errorSpan.textContent = 'Le prénom doit contenir au moins 2 caractères.';
                    return false;
                }
                if (value.trim().length > 100) {
                    errorSpan.textContent = 'Le prénom ne doit pas dépasser 100 caractères.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    errorSpan.textContent = 'L’email est obligatoire.';
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
                if (value.length < 6) {
                    errorSpan.textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'genre':
                if (!value) {
                    errorSpan.textContent = 'Le genre est obligatoire.';
                    return false;
                }
                if (!['homme', 'femme'].includes(value)) {
                    errorSpan.textContent = 'Genre invalide.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'date_naissance':
                if (!value) {
                    errorSpan.textContent = 'La date de naissance est obligatoire.';
                    return false;
                }
                const birthDate = new Date(value);
                if (isNaN(birthDate.getTime())) {
                    errorSpan.textContent = 'Date invalide.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'taille':
                if (!value) {
                    errorSpan.textContent = 'La taille est obligatoire.';
                    return false;
                }
                const taille = parseFloat(value);
                if (isNaN(taille)) {
                    errorSpan.textContent = 'La taille doit être un nombre décimal.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'poids':
                if (!value) {
                    errorSpan.textContent = 'Le poids est obligatoire.';
                    return false;
                }
                const poids = parseFloat(value);
                if (isNaN(poids)) {
                    errorSpan.textContent = 'Le poids doit être un nombre décimal.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'objectif':
                if (!value) {
                    errorSpan.textContent = "L'objectif est obligatoire.";
                    return false;
                }
                if (!['augmenter_poids', 'reduire_poids', 'imc_ideal'].includes(value)) {
                    errorSpan.textContent = "Objectif invalide.";
                    return false;
                }
                errorSpan.textContent = '';
                return true;
        }
        return true;
    }

    function validateForm() {
        let valid = true;
        const currentTabElement = document.getElementsByClassName("tab")[currentTab];
        const inputs = currentTabElement.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            if (input.hasAttribute('name') && input.type !== 'submit') {
                const isValid = validateField(input, input.value);
                if (!isValid) {
                    valid = false;
                    input.classList.add('invalid');
                } else {
                    input.classList.remove('invalid');
                }
            }
        });
        
        if (valid) {
            const steps = document.getElementsByClassName("step");
            if (steps[currentTab]) {
                steps[currentTab].classList.add("finish");
            }
        }
        
        return valid;
    }

    function nextPrev(n) {
        let x = document.getElementsByClassName("tab");
        
        if (n === 1 && !validateForm()) {
            return false;
        }
        
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        
        if (currentTab >= x.length) {
            document.getElementById("regForm").submit();
            return false;
        }
        
        showTab(currentTab);
    }

    function fixStepIndicator(n) {
        let i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        if (x[n]) {
            x[n].className += " active";
        }
    }

    document.querySelectorAll('input, select').forEach(field => {
        if (field.getAttribute('type') !== 'submit' && field.getAttribute('name')) {
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
    
