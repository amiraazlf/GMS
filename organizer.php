<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Penyelenggara</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      :root {
        --dark: #243642;
        --sage: #387478;
        --green: #629584;
        --light: #e2f1e7;
      }

      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: var(--sage);
        min-height: 50vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        z-index: 0;
        overflow-x: hidden;
        overflow-y: auto;
        position: relative;
      }

      .navbar {
        background-color: var(--dark);
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        width: 100%;
        box-sizing: border-box;
        flex-wrap: wrap;
      }

      .navbar .menu-icon {
        font-size: 24px;
        margin-right: 20px;
      }

      .navbar .nav-links {
        display: flex;
        gap: 20px;
      }

      .navbar .nav-links a {
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 10px;
        transition: background-color 0.3s;
      }

      .navbar .nav-links a:hover {
        background-color: var(--light);
        color: black;
      }

      .navbar .nav-links a.active {
        background-color: var(--light);
        color: black;
      }

      .navbar .nav-links a.active:hover {
        background-color: var(--dark);
        color: white;
      }


      .home {
        min-height: 100vh;
        background: var(--sage) no-repeat;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        z-index: 0;
        overflow: hidden;
        position: relative;
        min-height: 50vh;
      }

      .home .content {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding-top: 0rem;
        padding-bottom: 0.5rem;
        text-align: center;
      }

      .home .content h1 {
        font-size: 3rem;
        color: #fff;
        padding: 0 1rem;
        text-shadow: 0 0.3rem 0.5rem rgba(0, 0, 0, 0.3);
        text-transform: uppercase;
        margin-bottom: 0.5rem;
      }

      .home .content p {
        font-size: 1.5rem;
        color: #eee;
        padding: 1rem 5%;
        max-width: 900px;
        line-height: 1.5;
        margin-top: 0rem;
        margin-bottom: 1rem;
      }

      .home .box-container {
        display: flex;
        justify-content: center; 
        flex-wrap: wrap; 
        gap: 1rem;
        padding: 1rem;
        margin-bottom: 5rem;
      }

      .home .box-container .box {
        flex: 0 1 22rem; 
        max-width: 22rem;
        height: 25rem; 
        background: var(--light);
        text-align: center;
        border-radius: 1rem;
        box-shadow: 0 0.3rem 0.5rem rgba(0, 0, 0, 0.5);
        margin-right: 0;
        margin-bottom: 1rem;
        cursor: pointer;
        box-sizing: border-box;
        display: flex; 
        flex-direction: column;
        justify-content: flex-start; 
        align-items: center;
        padding: 1rem;
        padding-bottom: 3rem; 
      }

      .home .box-container .box i {
        height: 6rem;
        width: 6rem;
        line-height: 6rem;
        text-align: center;
        border-radius: 50%;
        color: #fff;
        background: var(--green);
        font-size: 3rem;
        margin-bottom: 1.5rem;
        transition: 0.2s;
        margin-top: 1rem;
      }

      .home .box-container .box h3 {
        font-size: 2rem;
        color: var(--dark);
        transition: 0.2s;
        margin-top: 1rem;
        margin-bottom: 0rem;
      }

      .home .box-container .box p {
      font-size: 1.3rem;
        padding: 0.5rem 1.5rem;
        margin-bottom: 0.5rem;
        margin-top: 0.5rem;
        color: black;
      } 

      .home .box-container .box button {
        background-color: var(--green);
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        align-self: center; 
        margin-top: 1rem;
      }

      .home .box-container .box button:hover {
        background-color: var(--dark);
      }

      .home .box-container .box:hover i {
        background: var(--dark);
      }

      .home .box-container .box:hover h3 {
        color: var(--dark);
      }

      .home::before {
        content: "";
        position: absolute;
        bottom: -10rem;
        left: 50%;
        transform: translateX(-50%);
        border-top: 85vh solid #fff;
        width: 120%;
        border-radius: 50%;
        z-index: -1;
      }

      /* Media Queries */
      @media (max-width: 768px) {
        .body {
          overflow-y:auto;
          position: relative;
        }

        .navbar {
          padding: 10px;
        }

        .navbar .menu-icon {
          font-size: 20px;
        }

        .navbar .nav-links {
          gap: 10px;
        }

        .navbar .nav-links a {
          padding: 8px 15px;
          font-size: 14px;
        }

        .home .content h1 {
          font-size: 2.5rem;
        }

        .home .content p {
          font-size: 1.2rem;
          padding: 1rem 10%;
        }

        .home .box-container {
          flex-direction: column;
          align-items: center;
        }

        .home .box-container .box {
          width: 100%;
          max-width: 25rem; 
        }

        .home::before {
          display: none;
        }
      }

      @media (max-width: 480px) {
        .navbar {
          padding: 10px;
        }

        .navbar .menu-icon {
          font-size: 18px;
        }

        .navbar .nav-links {
          flex-direction: column;
          gap: 5px;
          width: 100%;
        }

        .navbar .nav-links a {
          padding: 10px;
          font-size: 12px;
        }

        .content h1 {
          font-size: 2rem;
        }

        .content p {
          font-size: 1rem;
          padding: 1rem 5%;
        }

        .box-container .box {
          width: 100%; 
          max-width: 22rem;
        }
      }
    </style>
  </head>
  <body>
    <div class="navbar">
      <i class="fas fa-bars menu-icon"></i>
      <div class="nav-links">
        <a href="gmsaflog.php">Main Dashboard</a>
        <a href="organizer.php" class="active">Home</a>
        <a href="create-event.php">Create Event</a>
        <a href="inviteguest.php">Invite Guest</a>
        <a href="guest-presence.php">Track Attendance</a>
        <a href="history.php">Event History</a>
      </div>
    </div>

    <section class="home" id="home">
      <div class="content">
        <h1>Welcome to the Event Organizer</h1>
        <p>
          Hello, Organizer! Here, you can easily manage and create your events with efficiency.
          Explore our features designed to streamline your event planning
          process.
        </p>
      </div>

      <div class="box-container">
        <div class="box">
          <i class="fas fa-calendar-plus"></i>
          <h3>Create Event</h3>
          <p>
            Set up event details, from time to location, and manage every aspect
            of your event.
          </p>
          <a href="create-event.php">
          <button>Get Started</button>
        </a>
        </div>
        <div class="box">
          <i class="fas fa-id-card"></i>
          <h3>Invite Guest</h3>
          <p>
            Send invitations directly to your special guests through our
            platform.
          </p>
          <a href="inviteguest.php">
          <button>Send Invitations</button>
        </a>
        </div>
        <div class="box">
          <i class="fas fa-users"></i>
          <h3>Track Attendance</h3>
          <p>
            See who has confirmed attendance and manage your guest list
            effortlessly.
          </p>
          <a href="guest-presence.php">
          <button>Track Now</button>
        </a>
        </div>
        <div class="box">
          <i class="fas fa-clock"></i>
          <h3>Event History</h3>
          <p>Review all your past events and analyze their performance.
          </p>
          <a href="history.php">
          <button>View History</button>
        </a>
        </div>
      </div>
    </section>

    <script src="penyelenggaradashboard.js"></script>
  </body>
</html>
