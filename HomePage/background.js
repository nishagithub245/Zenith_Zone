// This is for Background Animation
(function () {
  const canvas = document.getElementById("backgroundCanvas");
  const ctx = canvas.getContext("2d");

  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  const particles = [];
  const colors = ["#3CC157", "#2AA7FF", "#1B1B1B", "#FCBC0F", "#F85F36"];
  let numParticles = window.innerWidth < 640 ? 25 : 100;

  class Particle {
    constructor(x, y) {
      this.x = x;
      this.y = y;
      this.radius = Math.random() * 3 + 1;
      this.color = colors[Math.floor(Math.random() * colors.length)];
      this.dx = (Math.random() - 0.5) * 2;
      this.dy = (Math.random() - 0.5) * 2;
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
      ctx.fillStyle = this.color;
      ctx.fill();
    }

    update() {
      if (this.x + this.radius > canvas.width || this.x - this.radius < 0) {
        this.dx = -this.dx;
      }
      if (this.y + this.radius > canvas.height || this.y - this.radius < 0) {
        this.dy = -this.dy;
      }
      this.x += this.dx;
      this.y += this.dy;
    }
  }

  function init() {
    for (let i = 0; i < numParticles; i++) {
      const x = Math.random() * canvas.width;
      const y = Math.random() * canvas.height;
      particles.push(new Particle(x, y));
    }
  }

  function connectParticles() {
    let opacity;
    for (let a = 0; a < particles.length; a++) {
      for (let b = a + 1; b < particles.length; b++) {
        let distance = Math.sqrt(
          Math.pow(particles[a].x - particles[b].x, 2) +
            Math.pow(particles[a].y - particles[b].y, 2)
        );
        if (distance < 100) {
          opacity = 1 - distance / 100;
          ctx.strokeStyle = `rgba(200, 200, 200, ${opacity})`;
          ctx.lineWidth = 1;
          ctx.beginPath();
          ctx.moveTo(particles[a].x, particles[a].y);
          ctx.lineTo(particles[b].x, particles[b].y);
          ctx.stroke();
        }
      }
    }
  }

  function animate() {
    requestAnimationFrame(animate);
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((particle) => {
      particle.update();
      particle.draw();
    });

    connectParticles();
  }

  init();
  animate();

  window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    particles.length = 0;
    init();
  });
})();

//   <!-- For automatic sliding carousel -->
document.addEventListener("DOMContentLoaded", function () {
  const carouselItems = document.querySelectorAll("[data-carousel-item]");
  const carouselIndicators = document.querySelectorAll(
    "[data-carousel-slide-to]"
  );
  const carouselPrevBtn = document.querySelector("[data-carousel-prev]");
  const carouselNextBtn = document.querySelector("[data-carousel-next]");
  let currentIndex = 0;
  const interval = 3000; // Interval in milliseconds

  function goToSlide(index) {
    // Update item positions
    carouselItems.forEach((item, i) => {
      if (i === index) {
        item.style.transform = `translateX(0%)`;
      } else if (i < index) {
        item.style.transform = `translateX(-100%)`;
      } else {
        item.style.transform = `translateX(100%)`;
      }
    });
    // Update indicators
    carouselIndicators.forEach((indicator) =>
      indicator.setAttribute("aria-current", "false")
    );
    carouselIndicators[index].setAttribute("aria-current", "true");
    currentIndex = index;
  }

  function goToNextSlide() {
    currentIndex = (currentIndex + 1) % carouselItems.length;
    goToSlide(currentIndex);
  }

  function goToPrevSlide() {
    currentIndex =
      (currentIndex - 1 + carouselItems.length) % carouselItems.length;
    goToSlide(currentIndex);
  }

  // Initial setup
  goToSlide(currentIndex);

  // Auto slide change
  setInterval(goToNextSlide, interval);

  // Previous button click
  carouselPrevBtn.addEventListener("click", function () {
    goToPrevSlide();
  });

  // Next button click
  carouselNextBtn.addEventListener("click", function () {
    goToNextSlide();
  });

  // Indicator click
  carouselIndicators.forEach((indicator, index) => {
    indicator.addEventListener("click", function () {
      goToSlide(index);
    });
  });
});
