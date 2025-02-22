document.addEventListener("DOMContentLoaded", function () {
  const counters = document.querySelectorAll(".num");

  function startCounting(counter) {
    const target = +counter.getAttribute("data-target");
    const increment = target / 100;
    let count = 0;

    const interval = setInterval(() => {
      count += increment;
      if (count >= target) {
        counter.innerText = target;
        clearInterval(interval);
      } else {
        counter.innerText = Math.ceil(count);
      }
    }, 20);
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const counter = entry.target;
          startCounting(counter);
          observer.unobserve(counter);
        }
      });
    },
    {
      threshold: 0.1,
    }
  );

  counters.forEach((counter) => observer.observe(counter));
});

/*  */

let ulBar = document.querySelector(".mainNavbar");
let menuToggle = document.querySelector(".menuToggle");

toggleNav = () => {
  ulBar.classList.toggle("ulBarActive");
  menuToggle.classList.toggle("active");
};
