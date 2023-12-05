<?php
include "partials/header.php";
// Check if the form is submitted
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validate and sanitize the data (you can add more validation if needed)
    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);
    $message = mysqli_real_escape_string($connection, $message);

    // Insert data into the "contact_messages" table
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    
   if (mysqli_query($connection, $sql)) {
        $successMessage = "Message sent successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}

?>

<!-- END OF NAVBAR -->

<div class="contact-container">

   <div class="contact-form left-col">
      <h1>Contact us</h1>
      <p>
         Welcome to our Contact Us page! We value your feedback, inquiries, and suggestions. Feel free to reach out to us using the information below, and we'll be happy to assist you.

         General Inquiries:
         For general questions or information, please email us at <a>rippleBloggerinfo@example.com. </a>
         </br>
         Customer Support:
         If you require assistance with our products or services, our dedicated customer support team is ready to help. Reach out to us at <a> rippleBlogger@example.com. </a>
      </p>
   </div>


   <div class="contact-form right-col">

  <?php if (!empty($successMessage)) : ?>
       <div class="alert_message success container">
           <p><?= $successMessage; ?></p>
       </div>
   <?php endif; ?>
      <form class="contact-form" method="post">
         <label for="name">Full name</label>
         <input type="text" id="name" name="name" placeholder="Your Full Name" required>
         <label for="email">Email Address</label>
         <input type="email" id="email" name="email" placeholder="Your Email Address" required>
         <label for="message">Message</label>
         <textarea rows="6" placeholder="Your Message" id="message" name="message" required></textarea>
         <button class="btn" submit" id="submit" name="submit">Send</button>

      </form>
   </div>
</div>




<?php
include "partials/footer.php"
?>