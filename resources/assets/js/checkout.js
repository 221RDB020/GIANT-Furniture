const deliveryOptionBtns = document.querySelectorAll('.btn-d-opt');
const deliveryInput = document.querySelector('input[name="pick_up_at_warehouse"]');

if (deliveryOptionBtns) {
    deliveryOptionBtns.forEach(btn => {
       btn.addEventListener('click', (e) => {
           e.preventDefault();
           let button = e.target;

           deliveryInput.value = button.getAttribute('aria-details');

           deliveryOptionBtns.forEach(btn => {
               btn.setAttribute('aria-checked', 'false');
           });

           if (button.getAttribute('aria-checked') === 'false') {
               button.setAttribute('aria-checked', 'true');
           } else {
               button.setAttribute('aria-checked', 'false');
           }
       })
    });
}