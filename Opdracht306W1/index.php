
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600&display=swap" rel="stylesheet">
	
	<?php
	$title = "Hello world";
	?>
	<title><?php echo $title; ?></title>

</head>
<body class="main-content">
    <header class="container header active" id="home">
        <div class="header-content">
            <div class="left-header">
                <div class="header-shape"></div>
                <div class="cv-image">
                    <img src="images/logo1.jpg" alt="">
                </div>
            </div>
            <div class="right-header">
                <h1 class="name">
                    Hi, I'm <span>Leroy Riksten.</span> An upcoming developer.
                </h1>
                <h4>Welcome to my portfolio page. Have a look around.</h4>
            </br>
                <h4><span>Bio:</span></h4>
                <p>
                    Started to learn programming a few years ago. 
                    Love the process of puzzeling and the different approaches to figure out a problem. For example an improvement for performance.
                    In my free time I work on my physical and mental health by training for obstacel course, ultra runs and triathlons. 
                    And i love to go for walks in nature around Utrecht or hiking in Switzerland.
                </p>
                
            </div>
        </div>
    </header>

    <main>
		<section class="section sec2 about" id="about">
            <div class="main-title">
                <h2>About <span>me</span><span class="bg-text">my stats</span></h2>
            </div>
            <div class="about-container">
                <div class="left-about">
                    <h4>Information about me</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in 
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit 
                        anim id est laborum. 
                    </p>
                </div>
                <div class="right-about">
                    <div class="about-item">
                        <div class="about-text">
                            <p class="large-text">5+</p>
                            <p class="small-text">Projects<br/>Completed</p>
                        </div>
                    </div>
                    <div class="about-item">
                        <div class="about-text">
                            <p class="large-text">2+</p>
                            <p class="small-text">Years of <br /> experience</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="about-stats">
                <h4 class="stat-title">My Skills</h4>
                <div class="progress-bars">
                    <div class="progress-bar">
                        <p class="prog-title">html5</p>
                        <div class="progress-con">
                            <p class="prog-text">70%</p>
                            <div class="progress">
                                <span class="html"></span>
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <p class="prog-title">css3</p>
                        <div class="progress-con">
                            <p class="prog-text">80%</p>
                            <div class="progress">
                                <span class="css"></span>
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <p class="prog-title">python</p>
                        <div class="progress-con">
                            <p class="prog-text">60%</p>
                            <div class="progress">
                                <span class="python"></span>
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <p class="prog-title">mendix</p>
                        <div class="progress-con">
                            <p class="prog-text">75%</p>
                            <div class="progress">
                                <span class="mendix"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="timeline-title">My Timeline</h4>
            <div class="timeline">
                <div class="timeline-item">
                    <p class="timeline-duration">2022 - present</p>
                    <h5>Developer<span> - Company name</span></h5>
                    <p>
                        Lorem ipsum sit amet bla bla blaipsum sit amet bla bla bla
                        ipsum sit amet bla bla bla

                    </p>
                </div>
            </div>
        </section>
		<section class="section sec3" id="portfolio">
        <div class="main-title">
                <h2>Portfolio<span class="bg-text">my projects</span></h2>
            </div>
            <p class="portfolio-text">
                Some work that I have done in various programming languages.
            </p>
            <div class="portfolios">
                <div class="portfolio-item">
                    <div class="image">
                        <img src="images/portfolio.jpg" alt="">
                    </div>
                    <div class="hover-item">
                        <h4> HTML5 projects</h4>
                        <div class="icons">
                            <a href="https://github.com/" class="icon">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.youtube.com/" class="icon">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="image">
                        <img src="images/portfolio.jpg" alt="">
                    </div>
                    <div class="hover-item">
                        <h4> Python projects</h4>
                        <div class="icons">
                            <a href="https://github.com/" class="icon">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.youtube.com/" class="icon">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="image">
                        <img src="images/portfolio.jpg" alt="">
                    </div>
                    <div class="hover-item">
                        <h4> Mendix projects</h4>
                        <div class="icons">
                            <a href="https://github.com/" class="icon">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.youtube.com/" class="icon">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<section class="section sec4" id="blogs">
        <div class="blogs-content">
            <div class="main-title">
                    <h2>My <span>Blogs</span><span class="bg-text">My Blogs</span></h2>
                </div>
                <div class="blog-container">
                    <div class="blogs">
                        <div class="blog">
                        <a href="https://hellofangaming.github.io/HelloMarioEngine/" target="_blank"><img src="images/portfolio.jpg" alt=""></a>
                            <div class="blog-text">
                                <h4>How To Make Your Own Mario Game </h4>
                                <p>
                                    Lorem Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit 
                                    anim id est laborum.
                                </p>
                            </div>
                        </div>
                        <div class="blog">
                        <a href="https://www.dreamhost.com/blog/learn-react/" target="_blank"><img src="images/blog.jpg" alt=""></a>
                            <div class="blog-text">
                                <h4>How to learn React</h4>
                                <p>
                                    Lorem Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit 
                                    anim id est laborum.
                                </p>
                            </div>
                        </div>
                        <div class="blog">
                            <div class="video-text">
                                <h4>Python tip of the month</h4> 
                                <p>
                                    Lorem Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit 
                                    anim id est laborum.
                                </p>
                            </div>
                            <?php
                                $video = "video1.mp4";
                                $location = "videos/";
                            ?>
                            <video width="650" height="300" controls>
                                <source src="<?php echo $location . $video; ?>" type="video/mp4"
                            </video>
                        </div>
                    </div>
                </div>
        </div>
                    
        </section>
		<section class="section sec5 contact" id="contact">
            <div class="contact-container">
                <div class="main-title">
                    <h2>Contact <span>Me</span><span class="bg-text">Contact</span></h2>
                </div>
                <div class="contact-content-con">
                    <div class="left-contact">
                        
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam quisquam, repellendus omnis veritatis natus culpa nisi harum id provident quasi doloribus accusamus esse cum, molestias aspernatur velit itaque reprehenderit nostrum.
                        </p>
                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Location</span>
                                </div>
                                <p>
                                    <span>: Netherlands</span>
                                </p>
                            </div>
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-user-graduate"></i>
                                    <span>Education</span>
                                </div>
                                <p>
                                    <span>: Hogeschool LOI</span>
                                </p>
                            </div>
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-globe-africa"></i>
                                    <span>Languages</span>
                                </div>
                                <p>
                                    <span>: Dutch, English, Spanish, German</span>
                                </p>
                            </div>
                        </div>
                            
    
                        <div class="contact-icons">
                            <div class="contact-icon">
                                <a href="https://.facebook.com" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://github.com" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://youtube.com" target="_blank">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="right-contact">
                        <h4>Questions for me?</h4>
                        <form action="userinformation.php" method="post">
                            <div class="input-control">
                                <input type="text" name="user" required placeholder="Your full name"/>
                                <input type="email" name="email" required placeholder="Your e-mail"/>
                            </div>
                            <div class="input-control">
                                <textarea name="message"placeholder="Type your message here.."></textarea>
                            </div>
                            <button class="contact-btn" type="submit">Send</button>
                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <div class="controls">
        <div class="control control-1 active-btn" data-id="home" >
            <i class="fas fa-home"></i>
        </div>
        <div class="control control-2" data-id="about">
            <i class="fas fa-user"></i>
        </div>
        <div class="control control-3" data-id="portfolio">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="control control-4" data-id="blogs">
            <i class="far fa-newspaper"></i>
        </div>
        <div class="control control-5" data-id="contact">
            <i class="fas fa-envelope-open"></i>
        </div>
    </div>
    
    <!--<div class="theme-btn">
        <i class="fas fa-adjust"></i>
    </div> -->
	<script src="app.js"></script>
</body>
</html>


