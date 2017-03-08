
<template>

  <div id="main-index">


      <img src="../assets/Meetic.png" id="logo" alt="Logo"/>

      <div id="text-intro">
        LE SITE DE RENCONTRE POUR VOTRE ANIMAL DE COMPAGNIE
      </div>

      <p class="p_2">"NE SOYEZ PLUS UN LOUP SOLITAIRE"</p>

  </div>
</template>


<style lang="less">
 @import "../definitions"; /* import common definitions */

#main-index #logo{
  display: block;
  margin: auto;
  margin-top:1em;
  width:200px;
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
  color:@darkBlue;
  letter-spacing: 0.2em;

}

.p_2{
  text-align:center;
  font-family: 'Moon';
  font-weight : lighter;
  color:@darkBlue;
  letter-spacing: 0.2em;
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
