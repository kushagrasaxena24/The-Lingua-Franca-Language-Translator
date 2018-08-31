<?php  
session_start();
if(!isset($_SESSION['count']))
{
$_SESSION['count']=0;
}
class AccessTokenAuthentication {
  function getToken($azure_key)
  {
      $url = 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken';
      $ch = curl_init();
      $data_string = json_encode('{body}');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Content-Length: ' . strlen($data_string),
              'Ocp-Apim-Subscription-Key: ' . $azure_key
          )
      );
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $strResponse = curl_exec($ch);
      curl_close($ch);
      return $strResponse;
  }


}

Class HTTPTranslator {
 
  function curlRequest($url, $authHeader) {
      //Initialize the Curl Session.
      $ch = curl_init();
      //Set the Curl url.
      curl_setopt ($ch, CURLOPT_URL, $url);
      //Set the HTTP HEADER Fields.
      curl_setopt ($ch, CURLOPT_HTTPHEADER, array($authHeader,"Content-Type: text/xml"));
      //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
      //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, False);
      //Execute the  cURL session.
      $curlResponse = curl_exec($ch);
      //Get the Error Code returned by Curl.
      $curlErrno = curl_errno($ch);
      if ($curlErrno) {
          $curlError = curl_error($ch);
          throw new Exception($curlError);
      }
      //Close a cURL session.
      curl_close($ch);
      return $curlResponse;
  }
}
function curlRequest($url, $authHeader, $postData=''){
  //Initialize the Curl Session.
  $ch = curl_init();
  //Set the Curl url.
  curl_setopt ($ch, CURLOPT_URL, $url);
  //Set the HTTP HEADER Fields.
  curl_setopt ($ch, CURLOPT_HTTPHEADER, array($authHeader,"Content-Type: text/xml"));
  //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
  curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, False);
  if($postData) {
      //Set HTTP POST Request.
      curl_setopt($ch, CURLOPT_POST, TRUE);
      //Set data to POST in HTTP "POST" Operation.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
  }
  //Execute the  cURL session. 
  $curlResponse = curl_exec($ch);
  //Get the Error Code returned by Curl.
  $curlErrno = curl_errno($ch);
  if ($curlErrno) {
      $curlError = curl_error($ch);
      throw new Exception($curlError);
  }
  //Close a cURL session.
  curl_close($ch);
  return $curlResponse;
}

function translatetext($ulang1,$ulang2,$usertext) {
   try {
    
      //Client Secret key of the application.
      $clientSecret = "234251f92fb742c6b1513c7bd860dcd6";
  
      //Create the AccessTokenAuthentication object.
      $authObj      = new AccessTokenAuthentication();
      //Get the Access token.
      $accessToken  = $authObj->getToken($clientSecret);
      //Create the authorization Header string.
      $authHeader = "Authorization: Bearer ". $accessToken;
  
  
  
      $contentType  = 'text/plain';
      $category     = 'general';
      
      $params = "text=".urlencode($usertext)."&to=".$ulang2."&from=".$ulang1;
      $translateUrl = "https://api.microsofttranslator.com/v2/Http.svc/Translate?$params";
      
      //Create the Translator Object.
      $translatorObj = new HTTPTranslator();
      
      //Get the curlResponse.
      $curlResponse = $translatorObj->curlRequest($translateUrl, $authHeader);
      
      //Interprets a string of XML into an object.
      $xmlObj = simplexml_load_string($curlResponse);
      foreach((array)$xmlObj[0] as $val){
          $translatedStr = $val;
      }

      return array($usertext,$translatedStr);

    }
     catch (Exception $e) {
      echo "Exception: " . $e->getMessage() . PHP_EOL;
  }
  
  }
  
  
  if(isset($_POST[ "user1language"]))
{$_SESSION["ulang1"] = $_POST[ "user1language"];}

if(isset($_POST[ "user2language"]))
{$_SESSION["ulang2"] =$_POST[ "user2language"];}



if(isset($_POST[ "user1chat"]))
{
  $_SESSION["usertext11"] = $_POST[ "user1chat"];
  list($x,$y)=translatetext($_SESSION["ulang1"],$_SESSION["ulang2"],$_SESSION["usertext11"]);
  $_SESSION["c1"]=$x;
  $_SESSION["t1"]  =$y;
}

if(isset($_POST[ "user2chat"]))
{
  $_SESSION["usertext22"] =$_POST["user2chat"];
  list($x,$y)= translatetext($_SESSION["ulang2"],$_SESSION["ulang1"],$_SESSION["usertext22"]);

  $_SESSION["c2"]=$x;
  $_SESSION["t2"]=$y;
      }

     

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Communication Application for people using different languages for directions ">
	  <meta name="keywords" content="directions,UF,application">
  	<meta name="author" content="Kushagra Saxena">
    <title>Lingua Franca| Services</title>
    <link rel="stylesheet" href="./style.css">
  </head>


  <body>
    <header>
      <div class="container">
        <div id="branding">
          <h1><span class="highlight">Lingua Franca</span> </h1>
        </div>
        <nav>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li class="current"><a href="services.php">Services</a></li>
          </ul>
        </nav>
      </div>
    </header>
 
 <section id="newsletter">
      <div class="container">
        <h1>Subscribe To Our Newsletter</h1>
        <form>
          <input type="email" placeholder="Enter Email...">
          <button type="submit" class="button_1">Subscribe</button>
        </form>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <article id="main-col">
          <h1 class="page-title">How to use the application :<br>
          <p>1. First choose and submit user1 and user2 languages in their respective forms.
             <br>
             2. Start chatting using the chat boxes. If the translated text is not understandable click the error button below the translated text.
             <br>
             3. Click the complete interaction button at the bottom of this page to move to the survey page when you are done with chatting.  </p>
</h1>
 <br>
        <br>
        <section id="langselect">
<div class="languagesselect">
  <form action="services.php" method="post" class="user1lang">
User 1: <select name="user1language" class="styled-select blue semi-square">
                <option selected="true" disabled="disabled">Choose User1 Language</option>
                <option  value="af">Afrikaans</option>
                <option  value="ar">Arabic</option>
                <option  value="bn">Bangla</option>
                <option  value="bs">Bosnian (Latin)</option>
                <option  value="bg">Bulgarian</option>
                <option  value="yue">Cantonese (Traditional)</option>
                <option  value="ca">Catalan</option>
                <option  value="zh-Hans">Chinese Simplified</option>
                <option  value="zh-Hant">Chinese Traditional</option>
                <option  value="hr">Croatian</option>
                <option  value="cs">Czech</option>
                <option  value="da">Danish</option>
                <option  value="nl">Dutch</option>
                <option  value="en">English</option>
                <option  value="et">Estonian</option>
                <option  value="fj">Fijian</option>
                <option  value="fil">Filipino</option>
                <option  value="fi">Finnish</option>
                <option  value="fr">French</option>
                <option  value="de">German</option>
                <option  value="el">Greek</option>
                <option  value="he">Hebrew</option>
                <option  value="hi">Hindi</option>
                <option  value="hu">Hungarian</option>
                <option  value="it">Italian</option>
                <option  value="ja">Japanese</option>
                <option  value="tlh">Klingon</option>
                <option  value="ko">Korean</option>
                <option  value="lv">Latvian</option>
                <option  value="lt">Lithuanian</option>
                <option  value="mt">Maltese</option>
                <option  value="nb">Norwegian</option>
                <option  value="fa">Persian</option>
                <option  value="pl">Polish</option>
                <option  value="pt">Portuguese</option>
                <option  value="ro">Romanian</option>
                <option  value="ru">Russian</option>
                <option  value="sm">Samoan</option>
                <option  value="sr-Cyrl">Serbian</option>
                <option  value="sk">Slovak</option>
                <option  value="sl">Slovenian</option>
                <option  value="es">Spanish</option>
                <option  value="sv">Swedish</option>
                <option  value="ty">Tahitian</option>
                <option  value="ta">Tamil</option>
                <option  value="th">Thai</option>
                <option  value="tr">Turkish</option>
                <option  value="uk">Ukrainian</option>
                <option  value="ur">Urdu</option>
                <option  value="vi">Vietnamese</option>
                </select>
                <button type="submit" class="button_1">Submit</button>
        </br>

        </form>
    </div>
     <br> 
<div class="languagesselect">
  <form action="services.php" method="post" class="user2lang">
         
          
          
    


         User 2: <select name="user2language" class="styled-select blue semi-square">
                    <option selected="true" disabled="disabled">Choose User2 Language</option>
                    <option  value="af">Afrikaans</option>
                    <option  value="ar">Arabic</option>
                    <option  value="bn">Bangla</option>
                    <option  value="bs">Bosnian (Latin)</option>
                    <option  value="bg">Bulgarian</option>
                    <option  value="yue">Cantonese (Traditional)</option>
                    <option  value="ca">Catalan</option>
                    <option  value="zh-Hans">Chinese Simplified</option>
                    <option  value="zh-Hant">Chinese Traditional</option>
                    <option  value="hr">Croatian</option>
                    <option  value="cs">Czech</option>
                    <option  value="da">Danish</option>
                    <option  value="nl">Dutch</option>
                    <option  value="en">English</option>
                    <option  value="et">Estonian</option>
                    <option  value="fj">Fijian</option>
                    <option  value="fil">Filipino</option>
                    <option  value="fi">Finnish</option>
                    <option  value="fr">French</option>
                    <option  value="de">German</option>
                    <option  value="el">Greek</option>
                    <option  value="he">Hebrew</option>
                    <option  value="hi">Hindi</option>
                    <option  value="hu">Hungarian</option>
                    <option  value="it">Italian</option>
                    <option  value="ja">Japanese</option>
                    <option  value="tlh">Klingon</option>
                    <option  value="ko">Korean</option>
                    <option  value="lv">Latvian</option>
                    <option  value="lt">Lithuanian</option>
                    <option  value="mt">Maltese</option>
                    <option  value="nb">Norwegian</option>
                    <option  value="fa">Persian</option>
                    <option  value="pl">Polish</option>
                    <option  value="pt">Portuguese</option>
                    <option  value="ro">Romanian</option>
                    <option  value="ru">Russian</option>
                    <option  value="sm">Samoan</option>
                    <option  value="sr-Cyrl">Serbian</option>
                    <option  value="sk">Slovak</option>
                    <option  value="sl">Slovenian</option>
                    <option  value="es">Spanish</option>
                    <option  value="sv">Swedish</option>
                    <option  value="ty">Tahitian</option>
                    <option  value="ta">Tamil</option>
                    <option  value="th">Thai</option>
                    <option  value="tr">Turkish</option>
                    <option  value="uk">Ukrainian</option>
                    <option  value="ur">Urdu</option>
                    <option  value="vi">Vietnamese</option>
                    </select>
                    <button type="submit" class="button_1">Submit</button>
            
    
            </form>
            </br>
         
    
          
        



    </div>
    </section>
       

    <div class="chatbox">

    <div class="chatlogs">

         <div class="chat friend">
          
             <div class="user-photo"><img src="./u1.jpg"></div>
             <p class="chat-message"> <?php  echo $_SESSION["c1"];  ?>
             <br>


             
             
             <?php
 if(isset($_SESSION['t1']))
             { echo '('. $_SESSION["t1"].')';}
     ?>



<form action="services.php" method="post" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button type="submit" name="error2" class="button_1">ERROR</button>
        </form>
             
             
         
               
             
             </p>
          </div>
          <div class="chat self">
              <div class="user-photo"> <img src="./u2.jpg"> </div>
              <p class="chat-message"> <?php   echo $_SESSION["c2"]; ?>
             <br>

             
             <?php
             
        
              
             if(isset($_SESSION['t2']))
             { echo '('. $_SESSION["t2"].')';}

             ?>


             






      

  


<form action="services.php" method="post" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
          <button type="submit" name="error2" class="button_1"> ERROR </button>
        </form>
             
          
               
             



              </p>
          </div>

      </div>

   
 
   

   </div>
   <br>
   <br>
   

   
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
<h1> Chat Boxes</h1>


<form action="services.php" method="post" class="form1class">
         
         User 1: <input type="text" class="u1input" name="user1chat"  placeholder="Enter Text">
          <button type="submit" class="button_1">Submit</button>
        </form>
         <br>


        <form action="services.php" method="post" class="form2class">
          User 2: <input type="text" class="u2input" name="user2chat"placeholder="Enter Text" >
          <button type="submit" class="button_1">Submit</button>
        </form>    
        <br>
   <br>
<br>  
    

<form action="linktosurvey.php"> 
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


    
    
    
      <input type="submit" class="button_compint" value="Click Here to Complete Interaction and Enter the Survey Page"/> 
          </form>



          <?php

if(isset($_POST['error1']))
{
  $_SESSION['count']++;
  unset($_POST['error1']);
}

if(isset($_POST['error2']))
{
  $_SESSION['count']++;
  unset($_POST['error2']);
}
              ?>


          <h1>Error Count : <?php echo $_SESSION["count"];    ?> </h1>
        </article>

      </div>
    </section>



    <footer>
      <p>Lingua Franca, Copyright &copy; 2018</p>
    </footer>
  </body>
</html>