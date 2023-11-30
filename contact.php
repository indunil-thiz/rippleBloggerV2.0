<?php
include "partials/header.php"
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