<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>About - AAU Vehicle System</title>

<style>

/* ===== GLOBAL 7(MATCH HOME) ===== */
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Segoe UI;
}

body{
background:linear-gradient(120deg,#0f2027,#203a43,#2c5364);
color:white;
overflow-x:hidden;
}

/* ===== NAVBAR ===== */
.navbar{
position:fixed;
top:0;
width:100%;
display:flex;
justify-content:space-between;
align-items:center;
padding:18px 50px;
background:rgba(0,0,0,0.4);
backdrop-filter:blur(10px);
z-index:1000;
}

.logo{
font-size:22px;
font-weight:bold;
letter-spacing:2px;
color:#00eaff;
text-shadow:0 0 10px #00eaff;
}

.nav-links{
display:flex;
gap:30px;
}

.nav-links a{
text-decoration:none;
color:white;
transition:.3s;
}

.nav-links a:hover{
color:#00eaff;
text-shadow:0 0 10px #00eaff;
}

/* ===== HERO ===== */
.hero{
padding-top:140px;
text-align:center;
}

.hero h1{
font-size:32px;
color:#00eaff;
text-shadow:0 0 15px #00eaff;
}

.hero h2{
margin-top:10px;
font-weight:400;
}

.hero p{
margin-top:20px;
color:#cbefff;
}

/* ===== 3D CAROUSEL ===== */
.scene{
margin:180px 0;
display:grid;
place-items:center;
perspective:1000px;
}

.a3d{
position:relative;
width:320px;
height:160px;
transform-style:preserve-3d;
animation:spin 200s linear infinite;
}

@keyframes spin{
to{ transform: rotateY(360deg); }
}

.card3d{
position:absolute;
width:240px;
height:150px;
border-radius:15px;
overflow:hidden;
box-shadow:0 0 20px #00eaff55;
}

.card3d img{
width:100%;
height:100%;
object-fit:cover;
}

/* ===== ABOUT ===== */
.about{
max-width:900px;
margin:auto;
padding:30px 20px;
text-align:center;
font-size:18px;
line-height:1.7;
color:#cbefff;
}

/* ===== TEAM ===== */
.team{
padding:80px 20px;
text-align:center;
}

.team h2{
color:#00eaff;
margin-bottom:40px;
text-shadow:0 0 10px #00eaff;
}

.team-container{
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:30px;
}

.member{
width:260px;
padding:30px;
background:rgba(255,255,255,0.05);
border-radius:15px;
backdrop-filter:blur(10px);
transition:.4s;
}

.member:hover{
transform:translateY(-10px) scale(1.05);
box-shadow:0 0 25px #00eaff55;
}

.member img{
width:100px;
height:100px;
border-radius:50%;
margin-bottom:15px;
border:2px solid #00eaff;
}

.member h3{
margin-bottom:10px;
}

.member p{
color:#cbefff;
}

/* ===== FOOTER ===== */
.footer{
text-align:center;
padding:20px;
background:#000;
margin-top:50px;
}

/* ===== SCROLL ANIMATION ===== */
.fade{
opacity:0;
transform:translateY(40px);
transition:1s;
}

.fade.show{
opacity:1;
transform:translateY(0);
}

</style>
</head>

<body>

<!-- NAV -->
<div class="navbar">
<div class="logo">AAU VMS</div>
<div class="nav-links">
<a href="index.php">Home</a>
<a href="about.php">About</a>
<a href="contact.php">Contact</a>
<a href="auth/login.php" class="btn btn-login">Login</a>
</div>
</div>

<!-- HERO -->
<section class="hero">
<h1>FACULTY OF NATURAL AND COMPUTATIONAL SCIENCE</h1>
<h2>DEPARTMENT OF COMPUTER SCIENCE</h2>
<p><strong>Web & Android-Based Vehicle Management System For AAU</strong><br>
</section>

<!-- 3D VEHICLE GALLERY -->
<div class="scene fade">
<div class="a3d" id="gallery"></div>
</div>

<!-- ABOUT -->
<div class="about fade">
<p>
This system is designed to modernize vehicle operations at Addis Ababa University.
It enables efficient vehicle tracking, scheduling, and management through both
web and mobile platforms.
<br><br>
The platform improves transparency, reduces manual workload, and enhances
transport efficiency across the university system.
</p>
</div>

<!-- TEAM -->
<section class="team fade">
<h2>GROUP MEMBERS</h2>

<div class="team-container">

<div class="member">
    <a>
    <img src="/AAU/assets/image/jemal.jpg">
</a>
<h3>Mentesnot Temesgen</h3>
<p>NSE/5038/14</p>
</div>

<div class="member">
<img src="/AAU/assets/image/a11.png">
<h3>Sosina Kassaye</h3>
<p>NSE/9655/14</p>
</div>

<div class="member">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIAoXpmq4qW6GFqW2E7t2wRoOZMtdP5lFGaNFqL-Bs3A&s">
<h3>Hayat Nuredin</h3>
<p>NSE/9971/14</p>
</div>

</div>
</section>

<!-- FOOTER -->
<div class="footer">
© 2026 AAU Vehicle Management System
</div>

<!-- JS -->
<script>

/* ===== 3D VEHICLES ===== */
const vehicleImages = [
'https://images.unsplash.com/photo-1552519507-da3b142c6e3d',
'https://images.unsplash.com/photo-1503376780353-7e6692767b70',
'https://images.unsplash.com/photo-1493238792000-8113da705763',
'https://images.unsplash.com/photo-1511919884226-fd3cad34687c',
'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf',
'https://images.unsplash.com/photo-1504215680853-026ed2a45def'
];

const container = document.getElementById("gallery");
const n = vehicleImages.length;
const radius = 350;

vehicleImages.forEach((src,i)=>{
let div = document.createElement("div");
div.className="card3d";

let angle = (360/n)*i;
div.style.transform=`rotateY(${angle}deg) translateZ(${radius}px)`;

div.innerHTML=`<img src="${src}?w=400">`;

container.appendChild(div);
});

/* ===== SCROLL ANIMATION ===== */
const faders = document.querySelectorAll('.fade');

window.addEventListener('scroll',()=>{
faders.forEach(el=>{
const top = el.getBoundingClientRect().top;
if(top < window.innerHeight - 100){
el.classList.add('show');
}
});
});

</script>

</body>
</html>