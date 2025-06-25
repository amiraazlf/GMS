function searchFunction() {
  let input = document.getElementById("searchInput").value.toLowerCase();
  let items = document.querySelectorAll("#searchResults li");

  items.forEach((item) => {
    let text = item.textContent || item.innerText;
    if (text.toLowerCase().indexOf(input) > -1) {
      item.style.display = "";
    } else {
      item.style.display = "none";
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".card-container .card");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("show");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1 }
  );

  cards.forEach((card) => {
    observer.observe(card);
  });
});

const images = document.querySelector(".images");
const navLinks = document.querySelectorAll(".navigation a"); // Perbarui selector untuk navigasi
let currentIndex = 0;
let totalSlides = navLinks.length;
let intervalId;
let mouseMovementTimeout;
let isSliding = false; // Status untuk menghindari pergeseran berlebihan

// Fungsi untuk memperbarui posisi slide
function updateSlidePosition() {
  images.style.marginLeft = -${currentIndex * 100}%; // Geser sesuai index
}

// Fungsi untuk mengubah slide otomatis setiap 3 detik
function startAutoSlide() {
  intervalId = setInterval(() => {
    currentIndex = (currentIndex + 1) % totalSlides; // Geser ke slide berikutnya
    updateSlidePosition();
  }, 3000); // Setiap 3 detik
}

// Fungsi untuk menghentikan auto-slide
function stopAutoSlide() {
  clearInterval(intervalId);
}

// Fungsi untuk mendeteksi gerakan mouse
document.querySelector(".wrapper").addEventListener("mousemove", (event) => {
  const wrapperWidth = document.querySelector(".wrapper").offsetWidth;
  const mouseX = event.clientX;

  // Hentikan timeout jika ada
  clearTimeout(mouseMovementTimeout);

  // Setel timeout untuk mencegah terlalu cepat
  mouseMovementTimeout = setTimeout(() => {
    // Deteksi apakah mouse bergerak ke kiri atau ke kanan
    if (!isSliding) {
      // Hanya izinkan pergeseran jika tidak sedang sliding
      if (mouseX > wrapperWidth / 2) {
        stopAutoSlide();
        currentIndex = (currentIndex + 1) % totalSlides; // Geser ke slide berikutnya
        isSliding = true; // Set status sliding
        updateSlidePosition();
      } else {
        stopAutoSlide();
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; // Geser ke slide sebelumnya
        isSliding = true; // Set status sliding
        updateSlidePosition();
      }

      // Atur timeout untuk mengizinkan sliding lagi setelah 500ms
      setTimeout(() => {
        isSliding = false; // Reset status sliding setelah 500ms
      }, 500); // Durasi delay untuk mengizinkan sliding
    }
  }, 300); // Tunda 300ms sebelum mengubah slide
});

// Event listener untuk navigasi
navLinks.forEach((link, index) => {
  link.addEventListener("click", (event) => {
    event.preventDefault(); // Mencegah pengalihan tautan
    currentIndex = index; // Ambil index dari event listener
    updateSlidePosition();
    stopAutoSlide(); // Hentikan auto-slide saat navigasi
    startAutoSlide(); // Lanjutkan auto-slide setelah navigasi
  });
});

// Mulai auto slide ketika halaman dimuat
startAutoSlide();

function searchPlaces() {
  // Ambil input dari search bar
  var input = document.getElementById("search-input").value.toLowerCase();

  // Periksa apakah input tidak kosong
  if (input) {
    // Arahkan ke halaman viewall.html dengan query parameter
    window.location.href = viewall.html?query=${input};
  } else {
    alert("Please enter a search term");
  }
}

function searchPlaces() {
  // Ambil input dari search bar
  var input = document.getElementById("search-input").value.toLowerCase();

  // Periksa apakah input tidak kosong
  if (input) {
    // Arahkan ke halaman viewall.html dengan query parameter
    window.location.href = viewall.html?query=${input};
  } else {
    alert("Please enter a search term");
  }
}