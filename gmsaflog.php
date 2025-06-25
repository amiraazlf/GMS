<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Situs Reservasi Acara</title>
    <link rel="stylesheet" href="gmsaflog.css" />
    <script src="https://unpkg.com/feather-icons"></script>
  </head>

  <body>
    <nav>
      <div class="logo">
        <img src="gms.png" />
        <h2 class="title">GMSHub</h2>
      </div>

      <ul class="navbar">
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="create-event.php"> Create Event</a></li>
        <li><a href="rsvp.php"> Join Event</a></li>
      </ul>

      <div class="search-bar">
          <input
            type="text"
            id="search-input"
            placeholder="Search Hotel or Restaurant"
          />
          <a href="#" id="search" onclick="searchPlaces()">
            <i data-feather="search"></i>
          </a>
        </div>

      <div class="nav-acc">
        <div class="profile-dropdown">
          <button class="profile-btn">
            <a href="#" id="user"><i data-feather="user"></i></a>
            <span class="profile-name"></span>
          </button>
          <div class="dropdown-content">
            <a href="changeprofile.php">My Profile</a>
            <a href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="wrapper">
      <div class="slides">
        <span id="slide-1"></span>
        <span id="slide-2"></span>
        <span id="slide-3"></span>
        <span id="slide-4"></span>

        <div class="images">
          <img src="https://goldencitymall.com/images/demo/003aa.jpg" />
          <img
            src="https://media.licdn.com/dms/image/v2/C561BAQEZ3cYTusGRtw/company-background_10000/company-background_10000/0/1644390254582/sheraton_surabaya_hotel__towers_cover?e=2147483647&v=beta&t=gZ3ItLajL_VMNRFh-sg1qxcSVdE0iE68RUqTRfjdg9w"
          />
          <img
            src="https://image-tc.galaxy.tf/wijpeg-2pd9mms81ln383gh1ix20yuo2/lobby-5.jpg"
          />
          <img
            src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/11/7f/b2/74/great-place-to-hang-out.jpg?w=1200&h=-1&s=1"
          />
        </div>
      </div>

      <div class="navigation">
        <a href="#slide-1" class="nav-link" data-index="0"></a>
        <a href="#slide-2" class="nav-link" data-index="1"></a>
        <a href="#slide-3" class="nav-link" data-index="2"></a>
        <a href="#slide-4" class="nav-link" data-index="3"></a>
      </div>
    </div>

    <div class="section-header">
      <h2>Recommendation</h2>
      <a href="viewall.html" class="view-all">View all</a>
    </div>

    <div class="card-loc-container">
      <div class="card-loc">
        <img src="https://goldencitymall.com/images/demo/BA.png" />
        <div class="card-loc-content">
          <h3>Ballroom Golden City - Golden City Mall Surabaya</h3>
          <p>Reviews Coming Soon</p>
          <p>Wedding, Gathering, Graduation • Indonesian • Surabaya</p>
          <div class="times">
            <button>Create Event</button>
            <button>Join Event</button>
          </div>
        </div>
      </div>

      <div class="card-loc">
        <img
          src="https://cache.marriott.com/content/dam/marriott-renditions/SUBJW/subjw-pavilion-0196-hor-wide.jpg?output-quality=70&interpolation=progressive-bilinear&downsize=1336px:*"
        />
        <div class="card-loc-content">
          <h3>Pavilion Restaurant - JW Marriot Hotel Surabaya</h3>
          <p>Reviews Coming Soon</p>
          <p>Dining, Gathering • International • Surabaya</p>
          <div class="times">
            <button>Create Event</button>
            <button>Join Event</button>
          </div>
        </div>
      </div>

      <div class="card-loc">
        <img
          src="https://media-cdn.tripadvisor.com/media/photo-s/14/39/5d/ac/the-look.jpg"
        />
        <div class="card-loc-content">
          <h3>The Avenue Lounge Bar - Java Paragon Surabaya</h3>
          <p>Reviews Coming Soon</p>
          <p>Bar, Lounge • International • Surabaya</p>
          <div class="times">
            <button>Create Event</button>
            <button>Join Event</button>
          </div>
        </div>
      </div>
    </div>

    <div class="sec-header">
      <h2>Guest Experience</h2>
    </div>
    <section>
      <div class="sec">
        <img src="https://images.squarespace-cdn.com/content/v1/6493a716f6221e0b376dbc40/58926afc-d4a0-45b6-b92f-72a535666292/WEDDING+-+DAVID+NIDYA+-+143.jpg">
        <div class="sec-content">
          <h3>Pakuwon Imperial Ballroom 1 Rating: ★★★★☆ (4.6/5)</h3>
          <p>
            Pakuwon Imperial Ballroom 1 is highly recommended for couples
            seeking a large and luxurious wedding venue in Surabaya. From its
            location to its facilities and overall atmosphere, this venue offers
            a premium and unforgettable wedding experience.
          </p>
        </div>
      </div>
      <div class="sec-2">
        <div class="sec-content-2">
          <h3>Sky Lounge, The Westin Rating: ★★★★☆ (4.8/5)</h3>
          <p>
            The Sky Lounge at The Westin Surabaya is praised for its
            breathtaking city views, elegant decor, and exceptional service.
            Guests frequently highlight the stunning ambiance, professional
            staff, and high-quality food, making it a perfect venue for
            memorable wedding celebrations. Many recommend it for its luxury and
            flawless execution of events.
          </p>
        </div>
        <img
          src="https://dailyhotels.id/wp-content/uploads/2022/08/The-Westin-Hotel.jpg"
        />
      </div>
    </section>

    <footer>
      <div class="social">
        <a href=""><i data-feather="instagram"></i></a>
        <a href=""><i data-feather="twitter"></i></a>
        <a href=""><i data-feather="facebook"></i></a>
      </div>

      <div class="links">
        <a href="#">Home</a>
        <a href="#">Create Event</a>
        <a href="#">Join Event</a>
        <a href="#">FAQ</a>
      </div>

      <div class="credit">
        <p>Created by <a href="">Arifin</a>. | &copy; 2023.</p>
      </div>
    </footer>

    <script src="gms.js"></script>
    <script>
      feather.replace();
    </script>

    <script>
      const images = document.querySelector(".images");
      const navLinks = document.querySelectorAll(".navigation a"); 
      let currentIndex = 0;
      let totalSlides = navLinks.length;
      let intervalId;
      let mouseMovementTimeout;
      let isSliding = false; 

      function updateSlidePosition() {
        images.style.marginLeft = -${currentIndex * 100}%; 
      }

      function startAutoSlide() {
        intervalId = setInterval(() => {
          currentIndex = (currentIndex + 1) % totalSlides; 
          updateSlidePosition();
        }, 3000); 
      }
      function stopAutoSlide() {
        clearInterval(intervalId);
      }

      document
        .querySelector(".wrapper")
        .addEventListener("mousemove", (event) => {
          const wrapperWidth = document.querySelector(".wrapper").offsetWidth;
          const mouseX = event.clientX;

          clearTimeout(mouseMovementTimeout);

          mouseMovementTimeout = setTimeout(() => {
            if (!isSliding) {

              if (mouseX > wrapperWidth / 2) {
                stopAutoSlide();
                currentIndex = (currentIndex + 1) % totalSlides; 
                isSliding = true; 
                updateSlidePosition();
              } else {
                stopAutoSlide();
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; 
                isSliding = true; 
                updateSlidePosition();
              }

              setTimeout(() => {
                isSliding = false; 
              }, 500); 
            }
          }, 300); 
        });

      navLinks.forEach((link, index) => {
        link.addEventListener("click", (event) => {
          event.preventDefault(); 
          currentIndex = index; 
          updateSlidePosition();
          stopAutoSlide(); 
          startAutoSlide(); 
        });
      });
      startAutoSlide();
    </script>
  </body>
</html>