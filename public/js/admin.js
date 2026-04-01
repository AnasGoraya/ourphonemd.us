document.querySelectorAll('.counter').forEach(counter => {
    const updateCounter = () => {
        const target = +counter.getAttribute('data-target');
        const current = +counter.innerText;
        const increment = target / 50;
        if (current < target) {
            counter.innerText = Math.ceil(current + increment);
            setTimeout(updateCounter, 20);
        } else {
            counter.innerText = target;
        }
    };
    updateCounter();
});

const toggleBtn = document.getElementById('themeToggle');
const icon = toggleBtn.querySelector('i');
toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    icon.classList.toggle('fa-moon');
    icon.classList.toggle('fa-sun');
});
