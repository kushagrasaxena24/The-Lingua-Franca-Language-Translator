<?php

?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <!--Meta tag for responsive website -->
    <meta name="description" content="Communication Application for people using different languages for directions">
	  <meta name="keywords" content="directions,UF,application">
  	<meta name="author" content="Kushagra Saxena">
    <title>Lingua Franca| Welcome</title>
    <link rel="stylesheet" href="./style.css">
    <!-- Linking CSS File-->
  </head>
  <body>
      
     <header>
        <!--A class of container-->
      <div class="container">
        <div id="branding">
          <h1><span class="highlight">Lingua Franca</span> </h1>
        </div>
        <nav>
                <!-- nav tag for navgation buttons -->
          <ul>
            <li class="current"><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php">Services</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="showcase">
      <!-- for containing in the middle -->
      <div class="container">
        <!--<h1>Chat in your own Language</h1>
        <p>Supports more than 60 languages  </p>
-->
      </div>
    </section>

    <section id="newsletter">
      <div class="container">
        <h1>Subscribe To Our Newsletter</h1>
        <form>
          <!--  back end  -->
          <input type="email" placeholder="Enter Your Email">
          <button type="submit" class="button_1">Subscribe</button>
        </form>
      </div>
    </section>

    <section id="boxes">
      <div class="container">
        <div class="box">
          <img src="./easy-to-use.png">
          <h3>Easy To Use</h3>
          <p></p>
        </div>
        <div class="box">
          <img src="./language.jpg">
          <h3>Supports Most Commonly Used Languages</h3>
          <p></p>
        </div>
        <div class="box">
          <img src="./Mobile-friendly-sites.jpg">
          <h3>Mobile Friendly </h3>
          <p></p>
        </div>
      </div>
    </section>


    <section id="tool">
      <div class="linktoservices">
        
       
        <form action="services.php">
          <!--

          Bootstrap 
          
          <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button> 

          <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>-->
          <input type="submit" class="button_home" value="Click Here to use Chat Application"/> 
          </form>
        

          </div>
        </section>

    <footer>
      <p>Lingua Franca, Copyright &copy; 2018</p>
    </footer>
  </body>
</html>
