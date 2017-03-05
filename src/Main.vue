
<template>
  
  <div id="main-index">
   
    
      <img src="./assets/Meetic.png" width="250ox" id="logo" />
     
      <div id="text-intro">
        LE SITE DE RENCONTRE POUR VOTRE ANIMAL DE COMPAGNIE
      </div>
     
      <p class="p_2">"NE SOYEZ PLUS UN LOUP SOLITAIRE"</p>

      <button type="button" id="button_connexion" class="button_style">SE CONNECTER</button>
      <button type="button" id="button_inscription" class="button_style">S'INSCRIRE</button>

      <div id="connexion">
       <div id ="form_connexion">
          <form action="http://api.meowtic.com/user/login" method="post" class="form">
              <fieldset>
               <ul>
                <li>
                  <label for="pseudo">MAIL</label>              
                  <input id="pseudo" name="email" type="email">
                </li>
                 <div class="trait">
                 </div>
                <li>  
                  <label for="pseudo">MOT DE PASSE</label>              
                  <input id="pseudo" name="password" type="password">
                </li>
                </ul>
                <div class="trait">
                </div>
                <div id="pw_lost">Mot de passe perdu?</div>
              </fieldset>
                <button type="submit" id="button_validation" class="button_style">VALIDER
                <input type="hidden" name="token" value="temp"> 
              
                </br>
                <img src="./assets/search_mob.png"/>
                </button>
          </form>
       </div>

      
      </div>  

  </div>
</template>

<script>
    
    
   
 var temp = (window.location.pathname).trim();
    if(temp.charAt(0) == '/'){
     temp = temp.substr(1);
    }

    if(temp.charAt(temp.length - 1) == '/'){
    temp = temp.substr(0, temp.length - 1);
    }
    console.log(temp.split('/')); 
    alert(temp[1]);


</script>

<style lang="less">
@val : 15px; /* less example */
@valBleuF : #212D48;
@valBleuC : #49556d;
@valGrisC : #edeef0;


body {

  background-image: url("./assets/texture2.png");
  background-repeat: repeat;
}

#logo{
  display: block;
  margin: auto;
  margin-top:5%;
}

#text-intro{
  text-align:center;
  background-color:white;
  width:500px;
  padding:8px;
  display: block;
  margin: auto;
  font-size:1.3em;
  font-family: 'Moon';
  font-weight : bold;
  color:@valBleuF;
  letter-spacing: 0.2em;

}

.p_2{
  text-align:center;
  font-family: 'Moon';
  font-weight : lighter;
  color:@valBleuF;
  letter-spacing: 0.2em;
}

#button_connexion{
  margin-top:55px;
  width:300px;
  font-size:1.3em;
}


#button_inscription{
    margin-top:45px;
    width:300px;
    font-size:1.3em;
}

#connexion{
 /* display:none;*/
}

#button_validation{
    width:180px;
    height:80px;
    font-size:1.6em;
    background-color:rgba(55, 68, 94, 0.9);
    box-shadow : 2px 2px 2px rgba(0, 0, 0, 0.3);
    margin-bottom: 15px;

}

#button_validation img{
  width:30px;
  padding-top:3px;
}

.button_style{

   border-radius: 6px;
   letter-spacing: 0.2em;
   padding:5px;
   background-color:@valBleuC;
   display: block;
   margin: auto;
   font-family: 'Moon';
   font-weight : bold;
   color:white;
   /*box-shadow: 0 0 5px black;
   text-shadow: 0px -2px @valBleuF;*/
   cursor:pointer;

}

.button_style:hover,
.button_style:active {
  letter-spacing: 5px;
  transition: all 580ms ease-in-out;
  /*border: 1px solid rgba(#fff, 0);*/
  bottom: 0px;
}

#form_connexion{
  margin:auto;
  width:400px;
  margin: auto;
  margin-top:-170px;
  background-color:white;
  border-radius: 6px;
  box-shadow : 7px 7px 4px rgba(0, 0, 0, 0.3);
  
}

#form_connexion label{
  font-size:1.7em;
  font-family: 'Moon';
  font-weight : lighter;
  color:@valBleuC;
  letter-spacing: 0.1em;
  padding-left:20px;

}

.trait{
 
   width:320px;
   background-color:#dbdbdb;
   margin-top:5px;
   margin-left:28px;
   height:2px;
}

 fieldset{
  border:none;
}

 li #pseudo{
 width:330px;
 height:30px;
 display:block;
 border-radius: 10px;
 margin-top:5%;
 margin-left:10px;
 background-color:@valGrisC;
 }

#main-index li {
  padding-top:25px;
}

#pw_lost{
  text-align:right;
  margin-right:25px
}

@media screen and (max-width: 575px ) {
  
  #text-intro{
  width:400px;
  padding:8px;
  display: block;
  margin: auto;
  font-size:1em;
  

  }
}

@media screen and (max-width: 465px ) {
  
  #text-intro{
  width:350px;
  padding:8px;
  display: block;
  margin: auto;
  font-size:1em;
  

  }
}






</style>
