document.addEventListener('DOMContentLoaded', () => {
    for(let el of document.querySelectorAll('[data-blocked]')) {
        el.querySelector(`option[value="${el.getAttribute('data-blocked')}"]`).setAttribute('selected', true);
    }

    for(let el of document.querySelectorAll('.submit-edit')) {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            el.closest('form').appendChild('<input type="hidden" value="edit"');
        })
    }
})