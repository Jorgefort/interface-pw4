document.addEventListener('DOMContentLoaded', function() {
    initializeCarousel();
    initializeAccessoriesCarousel();
    initializeForm();
    initializeMobileMenu();
});
function initializeMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');
    if (!mobileMenuButton || !mobileMenu) {
        console.warn('Mobile menu elements not found');
        return;
    }
    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('show');
        mobileMenuButton.innerHTML = '<i class="fas fa-times"></i>';
        document.body.style.overflow = 'hidden';
    }
    function closeMobileMenu() {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('show');
        mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
        document.body.style.overflow = '';
    }
    mobileMenuButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (mobileMenu.classList.contains('hidden')) {
            openMobileMenu();
        } else {
            closeMobileMenu();
        }
    });
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            closeMobileMenu();
            setTimeout(() => {
                if (this.getAttribute('href').startsWith('#')) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            }, 300);
        });
    });
    mobileMenu.addEventListener('click', function(e) {
        if (e.target === mobileMenu) {
            closeMobileMenu();
        }
    });
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });
}
function initializeCarousel() {
    const carousel = document.querySelector('.carousel-inner');
    const slides = document.querySelectorAll('.carousel-item');
    let currentSlide = 0;
    function showSlide(slideNumber) {
        carousel.style.transform = `translateX(-${slideNumber * 100}%)`;
    }
    function nextSlide() {
        if (currentSlide === slides.length - 1) {
            currentSlide = 0; // Go to first slide
        } else {
            currentSlide = currentSlide + 1;
        }
        showSlide(currentSlide);
    }
    showSlide(0);
    setInterval(nextSlide, 5000);
}
function initializeAccessoriesCarousel() {
    const carousel = document.querySelector('.accessories-carousel-inner');
    const slides = document.querySelectorAll('.accessories-carousel-item');
    const indicators = document.querySelectorAll('.accessories-indicator');
    let currentSlide = 0;
    function showSlide(slideNumber) {
        carousel.style.transform = `translateX(-${slideNumber * 100}%)`;
        indicators.forEach((indicator, index) => {
            if (index === slideNumber) {
                indicator.classList.remove('bg-gray-600');
                indicator.classList.add('bg-white');
            } else {
                indicator.classList.remove('bg-white');
                indicator.classList.add('bg-gray-600');
            }
        });
    }
    function nextSlide() {
        if (currentSlide === slides.length - 1) {
            currentSlide = 0; // Go to first slide
        } else {
            currentSlide = currentSlide + 1;
        }
        showSlide(currentSlide);
    }
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    showSlide(0);
    setInterval(nextSlide, 4000);
}
function initializeForm() {
    const form = document.getElementById('contact-form');
    const budgetRange = document.getElementById('budget');
    const budgetValue = document.getElementById('budget-value');
    budgetRange.addEventListener('input', function() {
        budgetValue.textContent = `€${this.value}`;
    });
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Stop the form from submitting normally
        if (validateForm()) {
            alert('Formulier succesvol verzonden!');
            form.reset(); // Clear all form fields
            budgetValue.textContent = '€100'; // Reset budget display
        }
    });
}
function validateForm() {
    let formIsValid = true;
    const requiredFields = ['voornaam', 'achternaam', 'adres', 'woonplaats'];
    requiredFields.forEach(fieldId => {
        if (!isValidTextField(fieldId)) {
            showError(`${fieldId}-error`, fieldId);
            formIsValid = false;
        } else {
            hideError(`${fieldId}-error`, fieldId);
        }
    });
    if (!isValidSelect('geslacht')) {
        showError('geslacht-error', 'geslacht');
        formIsValid = false;
    } else {
        hideError('geslacht-error', 'geslacht');
    }
    if (!isValidSelect('onderwerp')) {
        showError('onderwerp-error', 'onderwerp');
        formIsValid = false;
    } else {
        hideError('onderwerp-error', 'onderwerp');
    }
    if (!isValidBirthDate()) {
        showError('geboortedatum-error', 'geboortedatum');
        formIsValid = false;
    } else {
        hideError('geboortedatum-error', 'geboortedatum');
    }
    if (!isValidPhoneNumber()) {
        showError('telefoon-error', 'telefoon');
        formIsValid = false;
    } else {
        hideError('telefoon-error', 'telefoon');
    }
    if (!isValidEmail()) {
        showError('email-error', 'email');
        formIsValid = false;
    } else {
        hideError('email-error', 'email');
    }
    if (!isValidPostcode()) {
        showError('postcode-error', 'postcode');
        formIsValid = false;
    } else {
        hideError('postcode-error', 'postcode');
    }
    if (!isValidMessage()) {
        showError('vraag-error', 'vraag');
        formIsValid = false;
    } else {
        hideError('vraag-error', 'vraag');
    }
    return formIsValid;
}
function isValidTextField(fieldId) {
    const input = document.getElementById(fieldId);
    const value = input.value.trim();
    return value.length > 0;
}
function isValidSelect(fieldId) {
    const select = document.getElementById(fieldId);
    return select.value !== '';
}
function isValidBirthDate() {
    const birthDateInput = document.getElementById('geboortedatum');
    const birthDate = new Date(birthDateInput.value);
    if (!birthDateInput.value) {
        return false;
    }
    const today = new Date();
    const age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    if (age < 16 || (age === 16 && monthDiff < 0) || 
        (age === 16 && monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        return false;
    }
    return true;
}
function isValidPhoneNumber() {
    const phoneInput = document.getElementById('telefoon');
    const phoneNumber = phoneInput.value.trim();
    const dutchPhonePattern = /^(\+31|0)[0-9]{9}$/;
    return dutchPhonePattern.test(phoneNumber);
}
function isValidEmail() {
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}
function isValidPostcode() {
    const postcodeInput = document.getElementById('postcode');
    const postcode = postcodeInput.value.trim();
    if (postcode === '') {
        return false;
    }
    const dutchPostcodePattern = /^[0-9]{4}[A-Za-z]{2}$/;
    return dutchPostcodePattern.test(postcode);
}
function isValidMessage() {
    const messageInput = document.getElementById('vraag');
    const message = messageInput.value.trim();
    return message.length >= 10;
}
function showError(errorId, inputId) {
    const errorElement = document.getElementById(errorId);
    const inputElement = document.getElementById(inputId);
    errorElement.classList.remove('hidden');
    errorElement.classList.add('error-message');
    inputElement.classList.remove('border-gray-600');
    inputElement.classList.add('error-border');
    setTimeout(() => {
        inputElement.classList.remove('error-border');
        inputElement.classList.add('error-border');
    }, 10);
}
function hideError(errorId, inputId) {
    const errorElement = document.getElementById(errorId);
    const inputElement = document.getElementById(inputId);
    errorElement.classList.add('hidden');
    errorElement.classList.remove('error-message');
    inputElement.classList.remove('error-border');
    inputElement.classList.add('border-gray-600');
}