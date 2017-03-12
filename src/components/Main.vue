
<template>
  <div id="main-index">
    <img src="../assets/Meetic.png" id="logo" alt="Logo"/>

    <div id="text-intro">
      Le site de rencontre pour votre animal de compagnie
    </div>

    <p class="p_2">"Ne soyez plus un loup solitaire"</p>

    <div id="button_main">
      <button  class="button_connexion" v-on:click="login">Se connecter</button>
      <button class="button_inscription" v-on:click="signup">S'inscrire</button>
      <signupuser-component v-if="choice == 2"></signupuser-component>
      <login-component v-if="choice == 1"></login-component>


      <p v-else>
      </p>

      <div id="recommandation">
        <h1>ILS RECOMANDENT CE SITE : </h1>
        <p>JIM : " Ma belle a enfin trouvé son clochard... "</p>
      </div>

    </div>

  </div>
</template>

<script>

import Vue from 'vue'
Vue.use(require('vue-resource'));

import SignupuserComponent from "./SignUp.vue"
import LoginComponent from "./LoginUser.vue"



export default {
components: {
  SignupuserComponent,
  LoginComponent
},

data(){
  return{
    choice: 0
  }
},
methods: {
  signup: function(){
    this.choice = 2;
  },

login: function(){
  this.choice = 1;
}
},
}



</script>


<style lang="less">
 @import "../definitions"; /* import common definitions */

#main-index #logo{
  display: block;
  margin: auto;
  margin-top:4.3em;
  width:250px;
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



#button_main button{
   width:300px;
   border-radius: 6px;
   letter-spacing: 0.2em;
   padding:0.3em;
   background-color:@lightBlue;
   display: block;
   margin: auto;
   margin-top : 1em;
   margin-bottom: 1em;
   font-size:1.3em;
   font-family: 'Moon';
   font-weight : bold;
   color:white;
   /*box-shadow: 0 0 5px black;
   text-shadow: 0px -2px @valBleuF;*/
   cursor:pointer;

}

#button_main{
  margin-top:3.5em;
}

#recommandation h1{
   font-size:1em;
   margin-top:8em;
}

#recommandation p{
  font-family: @fontText;
  text-align: center;
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
