
<template>
  <div id="main-index">
    <img src="../assets/Meetic.png" id="logo" alt="Logo"/>

    <div id="text-intro">
      Le site de rencontre pour votre animal de compagnie
    </div>

    <p class="p_2">"Ne soyez plus un loup solitaire"</p>

    <div>
      <button v-on:click="login">Se connecter</button>
      <button v-on:click="signup">S'inscrire</button>
      <signupuser-component v-if="choice == 2"></signupuser-component>
      <login-component v-if="choice == 1"></login-component>
      <p v-else>
      </p>
    </div>

  </div>
</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

import SignupuserComponent from "./SignUpUser.vue"
import LoginComponent from "./LogIn.vue"


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
  login: function(){
    this.choice = 1;
  },
signup: function(){
  this.choice = 2;
}
},
}



</script>


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
