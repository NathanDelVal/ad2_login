document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('button.goBack').addEventListener('click', (e) => {
        history.back();
    })
})