<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invite Guest</title>
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
      }
      .navbar {
        background-color: var(--dark);
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
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

      .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: var(--light);
        border: 1px solid #ccc;
        border-radius: 30px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        justify-content: center;
        margin-top: 50px;
      }
      .header {
        border-bottom: 2px solid var(--dark);
        padding-bottom: 10px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
      }
      .header h1 {
        font-size: 28px;
        margin: 0;
        color: black;
        font-weight: bold;
      }
      .form-section {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
      }
      .form-left,
      .form-right {
        width: 48%;
      }
      input[type="text"],
      input[type="email"] {
        width: 203%;
        float: left;
        padding: 10px 10px 10px 10px;
        margin-bottom: 20px;
        border: 1px solid black;
        border-radius: 5px;
        background-color: white;
        color: black;
        box-shadow: black;
        transition: border-color 0.3s;
        position: relative;
      }
      input[type="text"]:focus,
      input[type="email"]:focus {
        border-color: white;
        outline: none;
      }
      input[type="text"]::placeholder,
      input[type="email"]::placeholder {
        opacity: 10;
      }
      .form-left label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
      }
      .submit-btn {
        display: flex;
        justify-content: center;
        width: 100%;
      }
      .submit-btn button {
        padding: 10px 20px;
        background-color: var(--dark);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
      }
      .submit-btn button:hover {
        background-color: var(--green);
        color: white;
      }
    </style>
  </head>
  <body>
    <div class="navbar">
      <i class="fas fa-bars menu-icon"></i>
      <div class="nav-links">
        <a href="gmsaflog.php">Main Dashboard</a>
        <a href="organizer.php">Home</a>
        <a href="create-event.php">Create Event</a>
        <a href="inviteguest.php" class="active">Invite Guest</a>
        <a href="guest-presence.php">Track Attendance</a>
        <a href="history.php">Event History</a>
      </div>
    </div>

    <div id="invite-guest" class="container">
      <div class="header">
        <h1>Invite Guest</h1>
      </div>
      <form action="send-invitation.php" method="POST" class="form-section">
        <div class="form-left">
          <label>Guest Name:</label>
          <input
            type="text"
            name="guest_name"
            placeholder="Input guest name..."
            required
          />
          <label>Guest Email:</label>
          <input
            type="email"
            name="guest_email"
            placeholder="Input guest email..."
            required
          />
        </div>
          <div class="submit-btn">
            <button type="submit">Send Invitation</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
