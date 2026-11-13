document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (event) => {
            if (!confirm(el.dataset.confirm)) event.preventDefault();
        });
    });

    const card = document.querySelector('.player-card');
    if (card) {
        card.addEventListener('click', () => card.classList.toggle('is-flipped'));
    }

    const nameInputs = document.querySelectorAll('.player-name');
    nameInputs.forEach((input, i) => {
        input.addEventListener('input', () => {
            const counter = document.querySelector(`[data-count="${i}"]`);
            if (counter) counter.textContent = `${input.value.length}/30`;
        });
    });
});
