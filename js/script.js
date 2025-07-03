// Wait for the page to load completely
document.addEventListener('DOMContentLoaded', function() {
    initializeCarousel();
    initializeAccessoriesCarousel();
    initializeForm();
    initializeMobileMenu();
});

// MOBILE MENU FUNCTIONALITY
function initializeMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');
    
    if (!mobileMenuButton || !mobileMenu) {
        console.warn('Mobile menu elements not found');
        return;
    }
    
    // Function to open mobile menu
    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('show');
        mobileMenuButton.innerHTML = '<i class="fas fa-times"></i>';
        // Prevent body scroll when menu is open
        document.body.style.overflow = 'hidden';
    }
    
    // Function to close mobile menu
    function closeMobileMenu() {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('show');
        mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
        // Restore body scroll
        document.body.style.overflow = '';
    }
    
    // Toggle mobile menu
    mobileMenuButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (mobileMenu.classList.contains('hidden')) {
            openMobileMenu();
        } else {
            closeMobileMenu();
        }
    });
    
    // Close menu when clicking on a link
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            closeMobileMenu();
            // Allow the link to work
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
    
    // Close menu when clicking outside (on the overlay)
    mobileMenu.addEventListener('click', function(e) {
        if (e.target === mobileMenu) {
            closeMobileMenu();
        }
    });
    
    // Close menu when screen is resized to desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });
}

// CAROUSEL FUNCTIONALITY
function initializeCarousel() {
    const carousel = document.querySelector('.carousel-inner');
    const slides = document.querySelectorAll('.carousel-item');
    
    let currentSlide = 0;
    
    // Function to show the current slide
    function showSlide(slideNumber) {
        carousel.style.transform = `translateX(-${slideNumber * 100}%)`;
    }
    
    // Go to next slide
    function nextSlide() {
        if (currentSlide === slides.length - 1) {
            currentSlide = 0; // Go to first slide
        } else {
            currentSlide = currentSlide + 1;
        }
        showSlide(currentSlide);
    }
    
    // Initialize first slide
    showSlide(0);
    
    // Auto-play carousel every 5 seconds
    setInterval(nextSlide, 5000);
}

// ACCESSORIES CAROUSEL FUNCTIONALITY
function initializeAccessoriesCarousel() {
    const carousel = document.querySelector('.accessories-carousel-inner');
    const slides = document.querySelectorAll('.accessories-carousel-item');
    const indicators = document.querySelectorAll('.accessories-indicator');
    
    let currentSlide = 0;
    
    // Function to show the current slide
    function showSlide(slideNumber) {
        carousel.style.transform = `translateX(-${slideNumber * 100}%)`;
        
        // Update indicators
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
    
    // Go to next slide
    function nextSlide() {
        if (currentSlide === slides.length - 1) {
            currentSlide = 0; // Go to first slide
        } else {
            currentSlide = currentSlide + 1;
        }
        showSlide(currentSlide);
    }
    
    // Add click events to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Initialize first slide
    showSlide(0);
    
    // Auto-play carousel every 4 seconds
    setInterval(nextSlide, 4000);
}

// FORM VALIDATION
function initializeForm() {
    const form = document.getElementById('contact-form');
    const budgetRange = document.getElementById('budget');
    const budgetValue = document.getElementById('budget-value');
    
    // Update budget display when range changes
    budgetRange.addEventListener('input', function() {
        budgetValue.textContent = `€${this.value}`;
    });
    
    // When form is submitted
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Stop the form from submitting normally
        
        if (validateForm()) {
            alert('Formulier succesvol verzonden!');
            form.reset(); // Clear all form fields
            budgetValue.textContent = '€100'; // Reset budget display
        }
    });
}

// Check if form data is valid
function validateForm() {
    let formIsValid = true;
    
    // Validate required text fields
    const requiredFields = ['voornaam', 'achternaam', 'adres', 'woonplaats'];
    requiredFields.forEach(fieldId => {
        if (!isValidTextField(fieldId)) {
            showError(`${fieldId}-error`, fieldId);
            formIsValid = false;
        } else {
            hideError(`${fieldId}-error`, fieldId);
        }
    });
    
    // Validate gender selection
    if (!isValidSelect('geslacht')) {
        showError('geslacht-error', 'geslacht');
        formIsValid = false;
    } else {
        hideError('geslacht-error', 'geslacht');
    }
    
    // Validate subject selection
    if (!isValidSelect('onderwerp')) {
        showError('onderwerp-error', 'onderwerp');
        formIsValid = false;
    } else {
        hideError('onderwerp-error', 'onderwerp');
    }
    
    // Validate birth date
    if (!isValidBirthDate()) {
        showError('geboortedatum-error', 'geboortedatum');
        formIsValid = false;
    } else {
        hideError('geboortedatum-error', 'geboortedatum');
    }
    
    // Validate phone number
    if (!isValidPhoneNumber()) {
        showError('telefoon-error', 'telefoon');
        formIsValid = false;
    } else {
        hideError('telefoon-error', 'telefoon');
    }
    
    // Validate email
    if (!isValidEmail()) {
        showError('email-error', 'email');
        formIsValid = false;
    } else {
        hideError('email-error', 'email');
    }
    
    // Validate postcode
    if (!isValidPostcode()) {
        showError('postcode-error', 'postcode');
        formIsValid = false;
    } else {
        hideError('postcode-error', 'postcode');
    }
    
    // Validate message
    if (!isValidMessage()) {
        showError('vraag-error', 'vraag');
        formIsValid = false;
    } else {
        hideError('vraag-error', 'vraag');
    }
    
    return formIsValid;
}

// Validation helper functions

// Check if required text field is filled
function isValidTextField(fieldId) {
    const input = document.getElementById(fieldId);
    const value = input.value.trim();
    return value.length > 0;
}

// Check if required select field has a value
function isValidSelect(fieldId) {
    const select = document.getElementById(fieldId);
    return select.value !== '';
}

// Check if birth date is valid (at least 16 years old)
function isValidBirthDate() {
    const birthDateInput = document.getElementById('geboortedatum');
    const birthDate = new Date(birthDateInput.value);
    
    if (!birthDateInput.value) {
        return false;
    }
    
    const today = new Date();
    const age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    // Check if at least 16 years old
    if (age < 16 || (age === 16 && monthDiff < 0) || 
        (age === 16 && monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        return false;
    }
    
    return true;
}

// Check if phone number is correct Dutch format
function isValidPhoneNumber() {
    const phoneInput = document.getElementById('telefoon');
    const phoneNumber = phoneInput.value.trim();
    
    // Dutch phone pattern: +31 or 0, followed by 9 digits
    const dutchPhonePattern = /^(\+31|0)[0-9]{9}$/;
    
    return dutchPhonePattern.test(phoneNumber);
}

// Check if email is valid
function isValidEmail() {
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    
    // Basic email validation pattern
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    return emailPattern.test(email);
}

// Check if postcode is correct Dutch format
function isValidPostcode() {
    const postcodeInput = document.getElementById('postcode');
    const postcode = postcodeInput.value.trim();
    
    // Postcode is required
    if (postcode === '') {
        return false;
    }
    
    // Dutch postcode pattern: 4 digits + 2 letters
    const dutchPostcodePattern = /^[0-9]{4}[A-Za-z]{2}$/;
    
    return dutchPostcodePattern.test(postcode);
}

// Check if message is valid (minimum 10 characters)
function isValidMessage() {
    const messageInput = document.getElementById('vraag');
    const message = messageInput.value.trim();
    
    return message.length >= 10;
}

// Show error message and add enhanced red border to input
function showError(errorId, inputId) {
    const errorElement = document.getElementById(errorId);
    const inputElement = document.getElementById(inputId);
    
    // Show error message with enhanced styling
    errorElement.classList.remove('hidden');
    errorElement.classList.add('error-message');
    
    // Add enhanced error border with animation
    inputElement.classList.remove('border-gray-600');
    inputElement.classList.add('error-border');
    
    // Trigger shake animation
    setTimeout(() => {
        inputElement.classList.remove('error-border');
        inputElement.classList.add('error-border');
    }, 10);
}

// Hide error message and restore normal border
function hideError(errorId, inputId) {
    const errorElement = document.getElementById(errorId);
    const inputElement = document.getElementById(inputId);
    
    // Hide error message
    errorElement.classList.add('hidden');
    errorElement.classList.remove('error-message');
    
    // Restore normal border
    inputElement.classList.remove('error-border');
    inputElement.classList.add('border-gray-600');
}