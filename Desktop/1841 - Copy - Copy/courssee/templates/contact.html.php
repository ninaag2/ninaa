

<?php if ($feedback): ?>
    <p><strong><?= $feedback ?></strong></p>
<?php endif; ?>

<form method="POST" action="contact.php" class="form">
    <label  class= "form-label" for="name">Your Name:</label>
    <input type="text" name="name" required>

    <label  class= "form-label" for="email">Your Email:</label>
    <input type="email" name="email" required>

    <label  class= "form-label" for="subject">Subject:</label>
    <input type="text" name="subject" required>

    <label  class= "form-label" for="message">Message:</label>
    <textarea name="message" rows="6" required></textarea>

    <button  class="btn primary" type="submit">Send Message</button>
</form>

<<style>
.form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}
.form-label {
    display: block;
    margin-right: 8px;
    font-weight: bold;
    font-size: 20px;
    padding:3px;
}
.btn.primary {
    background-color: #153a61ff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
     font-size: 16px;
}
</style>>
