document.addEventListener('DOMContentLoaded', () => {
    // Filter Events
    const baseURL = window.location.origin + window.location.pathname;
    const params = new URLSearchParams(window.location.search);

    function updateParams(...attributes) {
        let keysToDelete = [];

        attributes.forEach(([key, value]) => {
            params.set(key, value);
        });

        params.forEach((param, key) => {
            if (param.length === 0) {
                keysToDelete.push(key);
            }
        });

        keysToDelete.forEach(key => {
            params.delete(key);
        });

        window.location.href = `${baseURL}?${params.toString()}`;
    }

    function debounce(func, timeout = 500){
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    const debouncedUpdateParams = debounce((attributes) => {
        updateParams(attributes);
    });

    // Hide/Show filters
    const hideShowBtn = document.querySelector('.h-filters');
    const filters = document.querySelector('.filters-side');
    const productList = document.querySelector('.product-list');
    let btnTextElement = null;

    function filtersVisibility() {
        if (filters.getAttribute('aria-expanded') === 'true') {
            filters.setAttribute('aria-expanded', 'false');
            productList.setAttribute('aria-expanded', 'true');
            btnTextElement.innerHTML = "Show Filters";
        } else {
            filters.setAttribute('aria-expanded', 'true');
            productList.setAttribute('aria-expanded', 'false');
            btnTextElement.innerHTML = "Hide Filters";
        }
    }

    if (hideShowBtn) {
        btnTextElement = hideShowBtn.querySelector('span');
        hideShowBtn.addEventListener('click', filtersVisibility);
    }

    // Filters-footer behaviour
    const footer = document.querySelector('.main-footer');

    if (filters) {
        document.addEventListener('scroll', () => {
            let windowY = window.scrollY + window.innerHeight;
            let footerY = document.documentElement.scrollHeight - footer.getBoundingClientRect().height;

            if (windowY - footerY >= 0) {
                filters.style.bottom = windowY - footerY + 'px';
            } else {
                filters.style.bottom = '0';
            }
        });
    }

    // Sort drop-down menu
    const dropBtn = document.querySelector('.sort-drop');
    const dropBtnText = document.querySelector('.sort-drop-text');
    const dropList = document.querySelector('.drop-list');
    let sortOptions = null;

    function sortControls() {
        if (dropBtn.getAttribute('aria-expanded') === 'true') {
            dropBtn.setAttribute('aria-expanded', 'false');
            dropList.setAttribute('aria-expanded', 'false');
        } else {
            dropBtn.setAttribute('aria-expanded', 'true');
            dropList.setAttribute('aria-expanded', 'true');
        }
    }

    function chooseSortOption(e) {
        const option = e.target;

        if (option.getAttribute('aria-selected') === 'true') {
            dropBtn.setAttribute('aria-expanded', 'false');
            dropList.setAttribute('aria-expanded', 'false');
        } else {
            let q = [
                'sortBy', [option.getAttribute('name'), option.getAttribute('data-order')],
            ];
            updateParams(q);
        }
    }

    if (dropBtn) {
        sortOptions = dropList.querySelectorAll('button');

        dropBtn.addEventListener('click', sortControls);
        sortOptions.forEach((option) => {
            option.addEventListener('click', chooseSortOption);

            if (params.has('sortBy')) {
                if (params.get('sortBy').split(',')[0] === "price") {
                    if (params.get('sortBy').split(',')[1] === option.getAttribute('data-order')) {
                        dropBtnText.innerHTML = option.innerHTML;
                    }
                } else if (params.get('sortBy').split(',')[0] === option.getAttribute('name')) {
                    dropBtnText.innerHTML = option.innerHTML;
                }
            }
        });
    }

    // CheckBox controls
    let checkboxes = null;

    if (filters) {
        checkboxes = filters.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    debouncedUpdateParams([e.target.name, true]);
                } else {
                    debouncedUpdateParams([e.target.name, '']);
                }
            });

            if (params.has(checkbox.name)) {
                if (params.get(checkbox.name) === 'true') {
                    checkbox.checked = true;
                }
            }
        });
    }

    // Accordion
    const accordionHeader = document.querySelectorAll('.accordion-header');
    let openOptions = JSON.parse(sessionStorage.getItem('open-filters')) || [];

    function accordionControls(eventOrBtn) {
        let btn, content;

        if (eventOrBtn.target) {
            btn = eventOrBtn.target;
            content = btn.parentNode.lastElementChild;
        } else {
            btn = eventOrBtn;
            content = btn.parentElement.lastElementChild;
        }

        if (btn.getAttribute('aria-expanded') === 'true') {
            btn.setAttribute('aria-expanded', 'false');
            content.setAttribute('aria-expanded', 'false');

            openOptions = openOptions.filter(itemId => itemId !== btn.getAttribute('itemid'));
        } else {
            btn.setAttribute('aria-expanded', 'true');
            content.setAttribute('aria-expanded', 'true');

            openOptions.push(btn.getAttribute('itemid'));
        }

        sessionStorage.setItem('open-filters', JSON.stringify(openOptions));
    }

    const open = JSON.parse(sessionStorage.getItem('open-filters')) || [];

    accordionHeader.forEach((btn) => {
        btn.addEventListener('click', accordionControls);

        if (open.includes(btn.getAttribute('itemid'))) {
            accordionControls(btn);
        }
    });

    // Color pick filter
    const colors = document.querySelectorAll('.color-picker');
    let pickedColors = [];

    if (params.has('color')) {
        pickedColors = params.get('color').split(',');
        pickedColors = pickedColors.filter(color => color !== "");
    }

    function pickColor(e) {
        const picker = e.target;

        if (picker.getAttribute('aria-checked') === 'true') {
            picker.setAttribute('aria-checked', 'false');

            pickedColors = pickedColors.filter(color => color !== picker.getAttribute('aria-details'));
        } else {
            picker.setAttribute('aria-checked', 'true');

            pickedColors.push(picker.getAttribute('aria-details'));
        }

        let q = ['color', pickedColors];
        debouncedUpdateParams(q);
    }

    colors.forEach(color => {
        color.addEventListener('click', pickColor);
        if (pickedColors.includes(color.getAttribute('aria-details'))) {
            color.setAttribute('aria-checked', 'true');
        }
    });

// Slider
    const sliderObjects = document.querySelectorAll('.slider-option');

    function moveNob(e, handle, rail, range, otherHandle, isFrom, fromInput, toInput) {
        let railRect = rail.getBoundingClientRect();
        let handleWidth = handle.offsetWidth;

        function onMouseMove(e) {
            let mousePosX = e.clientX - railRect.left;

            // Constrain handle within bounds
            if (mousePosX < 0) mousePosX = 0;
            if (mousePosX > railRect.width - handleWidth) mousePosX = railRect.width - handleWidth;

            // Prevent overlap between handles
            if (isFrom && mousePosX >= otherHandle.offsetLeft - handleWidth) {
                mousePosX = otherHandle.offsetLeft - handleWidth;
            }
            if (!isFrom && mousePosX <= otherHandle.offsetLeft + handleWidth) {
                mousePosX = otherHandle.offsetLeft + handleWidth;
            }

            // Update handle position
            handle.style.left = mousePosX + 'px';

            // Update range position and width
            const fromLeft = isFrom ? mousePosX : otherHandle.offsetLeft;
            const toLeft = isFrom ? otherHandle.offsetLeft : mousePosX;
            updateRange(rail, range, fromLeft, toLeft);

            // Update input values based on slider positions
            const [minValue, maxValue] = getSliderMinMax(rail, fromLeft, toLeft, isFrom);
            fromInput.value = minValue;
            toInput.value = maxValue;

            let q = [fromInput.getAttribute('data-name'), [minValue,maxValue]];
            debouncedUpdateParams(q);
        }

        function onMouseUp() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        }

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
    }

    // Update the range bar's position and width
    function updateRange(rail, range, fromLeft, toLeft) {
        range.style.left = fromLeft + 'px';
        range.style.width = toLeft - fromLeft + 'px';
    }

    // Calculate the min and max values for the slider based on handle positions
    function getSliderMinMax(rail, fromLeft, toLeft, isFrom) {
        const railWidth = rail.offsetWidth;
        const minValue = parseInt(rail.getAttribute('data-min'), 10);
        const maxValue = parseInt(rail.getAttribute('data-max'), 10);

        const fromValue = Math.round((fromLeft / railWidth) * (maxValue - minValue) + minValue);
        const toValue = Math.round((toLeft / railWidth) * (maxValue - minValue) + minValue);

        return isFrom ? [fromValue, toValue] : [fromValue, toValue];
    }

    // Synchronize slider handles when inputs are changed manually with validation
    function updateSliderFromInput(fromInput, toInput, handleFrom, handleTo, rail, range, values = null) {
        const railWidth = rail.offsetWidth;
        const minValue = parseInt(rail.getAttribute('data-min'), 10);
        const maxValue = parseInt(rail.getAttribute('data-max'), 10);

        let fromValue = parseInt(fromInput.value, 10);
        let toValue = parseInt(toInput.value, 10);

        // Prevent the max input from being smaller than the min input
        if (toValue < fromValue) {
            toValue = fromValue;
            toInput.value = fromValue;
        }

        // Calculate percentages to position handles
        const fromPercentage = (fromValue - minValue) / (maxValue - minValue);
        const toPercentage = (toValue - minValue) / (maxValue - minValue);

        const fromLeft = fromPercentage * railWidth;
        const toLeft = toPercentage * railWidth;

        // Update handle positions
        handleFrom.style.left = fromLeft + 'px';
        handleTo.style.left = toLeft + 'px';

        // Update range bar
        updateRange(rail, range, fromLeft, toLeft);

        let attributes = [fromInput.getAttribute('data-name'), [fromValue,toValue]];

        if (values) {
            if (fromValue !== values[0] || toValue !== values[1]) {
                debouncedUpdateParams(attributes);
            }
        }
    }

    // Initialize sliders
    sliderObjects.forEach((sliderObject) => {
        let slider = sliderObject.querySelector('.slider');
        let rail = slider.querySelector('.rail');
        let range = slider.querySelector('.range');
        let handleFrom = slider.querySelector('.from');
        let handleTo = slider.querySelector('.to');
        let fromValue = sliderObject.querySelector('.from-filter');
        let toValue = sliderObject.querySelector('.to-filter');

        // Add min and max attributes for slider calculations
        rail.setAttribute('data-min', fromValue.getAttribute('min'));
        rail.setAttribute('data-max', toValue.getAttribute('max'));

        if (params.has(fromValue.getAttribute('data-name'))) {
            let values = params.get(fromValue.getAttribute('data-name')).split(',').map(Number);
            fromValue.value = values[0];
            toValue.value = values[1];
            updateSliderFromInput(fromValue, toValue, handleFrom, handleTo, rail, range, values);
        }

        // Add mouse down event listeners to both handles
        handleFrom.addEventListener('mousedown', (e) => moveNob(e, handleFrom, rail, range, handleTo, true, fromValue, toValue));
        handleTo.addEventListener('mousedown', (e) => moveNob(e, handleTo, rail, range, handleFrom, false, fromValue, toValue));

        // Add input change event listeners to synchronize slider with input values
        fromValue.addEventListener('input', () => updateSliderFromInput(fromValue, toValue, handleFrom, handleTo, rail, range));
        toValue.addEventListener('input', () => updateSliderFromInput(fromValue, toValue, handleFrom, handleTo, rail, range));
    });
});
