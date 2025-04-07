// Left and right side menus
const mobileMenuToggleL = document.querySelector('.mobile-menu-toggle-left');
const mobileMenuToggleR = document.querySelectorAll('.mobile-menu-toggle-right');
const mobileMenuL = document.getElementById('mobile-menu-left');
const mobileMenuR = document.getElementById('mobile-menu-right');
const body = document.querySelector('body');

function menuToggleLeft() {
    if (mobileMenuL.getAttribute('aria-expanded') === 'true') {
        mobileMenuL.setAttribute('aria-expanded', 'false');
        mobileMenuToggleL.setAttribute('aria-expanded', 'false');
        body.style.overflow = 'auto';
    } else {
        mobileMenuL.setAttribute('aria-expanded', 'true');
        mobileMenuToggleL.setAttribute('aria-expanded', 'true');
        body.style.overflow = 'clip';
    }

    if (window.defferedPrompt) {
        window.defferedPrompt.prompt();

        window.defferedPrompt.userChoice.then((choiceResult) => {
            console.log(choiceResult.outcome);

            if (choiceResult.outcome === 'dismissed') {
                console.log('User cancelled home screen install');
            } else {
                console.log('User added to home screen');
            }
        })

        window.defferedPrompt = null;
    }
}

function menuToggleRight() {
    if (mobileMenuR.getAttribute('aria-expanded') === 'true') {
        mobileMenuR.setAttribute('aria-expanded', 'false');
        body.style.overflow = 'auto';
    } else {
        mobileMenuR.setAttribute('aria-expanded', 'true');
        body.style.overflow = 'clip';
    }
}

mobileMenuToggleL.addEventListener('click', menuToggleLeft);
mobileMenuToggleR.forEach((toggle) => {
    toggle.addEventListener('click', menuToggleRight);
});

// Show/hide password
const showPasswordBtns = document.querySelectorAll('.view-pass-toggle');
const passwordInput = document.getElementById('password');
let temp;

function togglePasswordVisibility() {
    showPasswordBtns.forEach((btn) => {
       if (btn.classList.contains('hidden')) {
           btn.classList.remove('hidden');
       } else {
           btn.classList.add('hidden');
       }
    });

    if (passwordInput.getAttribute('type') === 'password') {
        passwordInput.setAttribute('type', 'text');
    } else {
        passwordInput.setAttribute('type', 'password');
    }
}

showPasswordBtns.forEach((btn) => {
    btn.addEventListener('click', togglePasswordVisibility);
})
