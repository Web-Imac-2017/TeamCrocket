<template>
  <body>
   
    
      <img src="./assets/Meetic.png" width="250ox" id="logo" />
     
      <div id="text-intro">
        LE SITE DE RENCONTRE POUR VOTRE ANIMAL DE COMPAGNIE
      </div>
     
      <p class="p_2">"NE SOYEZ PLUS UN LOUP SOLITAIRE"</p>

      <button type="button" id="button_connexion" class="button_style">SE CONNECTER</button>
      <button type="button" id="button_inscription" class="button_style">S'INSCRIRE</button>

  </body>
</template>

<script>


</script>

<style lang="less">
@val : 15px; /* less example */
@valBleuF : #212D48;
@valBleuC : #49556d;


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
}


#button_inscription{
    margin-top:45px;
}

.button_style{
   width:300px;
  /*border-radius: 6px;*/
   letter-spacing: 0.2em;
   padding:5px;
   background-color:@valBleuC;
   display: block;
   margin: auto;
   font-size:1.3em;
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
