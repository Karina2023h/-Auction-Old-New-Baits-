// Функція для запуску таймерів
function startTimers() {
  const timers = document.querySelectorAll(".timer");

  timers.forEach((timer) => {
    const endTime = new Date(timer.getAttribute("data-end-time")).getTime();

    const interval = setInterval(() => {
      const now = new Date().getTime();
      const distance = endTime - now;

      if (distance < 0) {
        clearInterval(interval);
        timer.innerText = "Аукціон завершено";
        return;
      }

      const hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      timer.innerText = `${hours}г ${minutes}хв ${seconds}с`;
    }, 1000);
  });
}

// Запуск таймерів при завантаженні сторінки
document.addEventListener("DOMContentLoaded", startTimers);
