<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Event</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />
    <style>
      /* Common styles can be added here */
      :root {
        --dark: #243642;
        --sage: #387478;
        --green: #629584;
        --light: #e2f1e7;
      }
      body {
        font-family: Poppins, sans-serif;
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
      input[type="text"] {
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
      input[type="text"]:focus {
        border-color: black;
        outline: none;
      }
      input[type="text"]::placeholder {
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
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
      }
      .submit-btn button:hover {
        background-color: var(--green);
        color: white;
      }
      .navbar .nav-links a.active {
        background-color: var(--light);
        color: black;
      }
      .navbar .nav-links a.active:hover {
        background-color: var(--dark);
        color: white;
      }
      .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
      }
      .calendar-icon {
        margin-right: 10px;
        margin-left: 5px;
        color: black;
        transform: translateY(-50%);
      }
    </style>
  </head>
  <body>
    <div class="navbar">
      <i class="fas fa-bars menu-icon"></i>
      <div class="nav-links">
        <a href="gmsaflog.php">Main Dashboard</a>
        <a href="organizer.php">Home</a>
        <a href="create-event.php" class="active">Create Event</a>
        <a href="inviteguest.php">Invite Guest</a>
        <a href="guest-presence.php">Track Attendance</a>
        <a href="history.php">Event History</a>
      </div>
    </div>

    <div id="create-event" class="container">
      <div class="header">
        <h1>Create Event</h1>
      </div>
      <form action="save-event.php" method="POST" class="form-section">
        <div class="form-left">
          <label>Event Name:</label>
          <input
            type="text"
            name="event_name"
            placeholder="Input your event name..."
            required
          />
          <label>Event Description:</label>
          <input
            type="text"
            name="event_description"
            placeholder="Input event description..."
          />
          <label>Date and Time:</label>
          <div class="input-with-icon">
            <input
              type="text"
              id="event_date"
              name="event_date"
              placeholder="Select date and time..."
              required
            />
            <i class="fas fa-calendar-alt calendar-icon" onclick="openDatePicker()"></i>
          </div>
          <label>Event Location:</label>
          <input
            type="text"
            name="event_location"
            placeholder="Input event location..."
            required
          />
          <label>Number of Chairs:</label>
          <input
            type="text"
            name="number_of_chairs"
            placeholder="Input number of chairs..."
            required
          />
        </div>
        <div class="submit-btn">
          <button type="submit">Submit</button>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const datePicker = flatpickr("#event_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            onOpen: function(selectedDates, dateStr, instance) {
                instance.open(); 
            }
        });
    
        function openDatePicker() {
            datePicker.open(); 
        }
    </script>
    
  </body>
</html>
