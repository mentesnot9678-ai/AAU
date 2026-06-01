<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db = 'aau';

$con = mysqli_connect($host, $username, $password, $db);

if (!$con) {
    die("Database connection failed");
}

if (isset($_POST['submit'])) {

    $fname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lname = mysqli_real_escape_string($con, $_POST['lastname']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);

    // Save to DB
    $sql = "INSERT INTO contact (first_name, last_name, subject) 
            VALUES('$fname','$lname','$subject')";
    mysqli_query($con, $sql);

    // ===== EMAIL =====
    $to = "aau@vms.com";
    $email_subject = "New Contact Message - AAU VMS";

    $message = "New message received:\n\n";
    $message .= "Name: $fname $lname\n\n";
    $message .= "Message:\n$subject";

    $headers = "From: noreply@aau-vms.com";

    @mail($to, $email_subject, $message, $headers);

    echo "<script>alert('Message Sent Successfully 🚀');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - AAU VMS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI;
        }

        body {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            color: white;
            overflow: hidden;
        }

        /* NAVBAR */

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 18px 50px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            z-index: 10;
        }

        .logo {
            color: #00eaff;
            font-weight: bold;
            text-shadow: 0 0 10px #00eaff;
        }

        .nav-links a {
            margin-left: 20px;
            color: white;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #00eaff;
        }

        /* CANVAS */

        canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        /* CONTACT SECTION */

        .wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 60px;
        }

        .contact-container {
            width: 900px;
            display: flex;
            gap: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            box-shadow: 0 0 30px rgba(0, 234, 255, 0.2);
            padding: 40px;
        }

        /* LEFT CONTACT INFO */

        .contact-info {
            flex: 1;
        }

        .contact-info h2 {
            color: #00eaff;
            margin-bottom: 10px;
        }

        .contact-info p {
            margin-bottom: 25px;
        }

        .info-item {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .info-item span {
            margin-right: 10px;
            color: #00eaff;
        }

        /* FORM */

        .contact-form {
            flex: 1;
        }

        .contact-form h2 {
            color: #00eaff;
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        input:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 10px #00eaff;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: #00eaff;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            box-shadow: 0 0 20px #00eaff;
        }

        /* FOOTER */

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background: #000;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">AAU VMS</div>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="auth/login.php" class="btn btn-login">Login</a>
        </div>
    </div>

    <canvas id="bg"></canvas>

    <div class="wrapper">

        <div class="contact-container">

            <!-- LEFT SIDE CONTACT INFO -->

            <div class="contact-info">

                <h2>AAU VMS</h2>
                <p>Addis Ababa - Ethiopia</p>

                <div class="info-item">
                    <span>📧</span> vmsadmin@vms.com
                </div>

                <div class="info-item">
                    <span>📞</span> Mentesnot Temesgen - 0950171344
                </div>

                <div class="info-item">
                    <span>📞</span> Sosina Kassaye - 0970944881
                </div>

                <div class="info-item">
                    <span>📞</span> Hayat Nuredin - 0925034353
                </div>

            </div>

            <!-- RIGHT SIDE FORM -->

            <div class="contact-form">

                <h2>Send Message</h2>

                <form method="post">

                    <input type="text" name="firstname" placeholder="First Name" required>

                    <input type="text" name="lastname" placeholder="Last Name" required>

                    <textarea name="subject" rows="5" placeholder="Message..." required></textarea>

                    <button name="submit">Send Message</button>

                </form>

            </div>

        </div>
    </div>

    <div class="footer">© 2026 AAU VMS</div>

    <script>

        const canvas = document.getElementById("bg");
        const ctx = canvas.getContext("2d");

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];

        for (let i = 0; i < 80; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5),
                vy: (Math.random() - 0.5)
            });
        }

        function draw() {

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;

                ctx.beginPath();
                ctx.arc(p.x, p.y, 2, 0, Math.PI * 2);
                ctx.fillStyle = "#00eaff";
                ctx.fill();
            });

            for (let i = 0; i < particles.length; i++) {

                for (let j = i + 1; j < particles.length; j++) {

                    let dx = particles[i].x - particles[j].x;
                    let dy = particles[i].y - particles[j].y;

                    let dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 120) {

                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = "rgba(0,234,255," + (1 - dist / 120) + ")";
                        ctx.stroke();

                    }

                }

            }

            requestAnimationFrame(draw);

        }

        draw();

    </script>

</body>

</html>