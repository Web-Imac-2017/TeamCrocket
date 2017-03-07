
<template>

  <div id="main-index">

      <img src="../assets/Meetic.png" width="250ox" id="logo" />

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
                <button type="submit" id="button_validation" class="button_style" onclick="connection()">
                  VALIDER
                  <input type="hidden" name="token" value="temp">
                  <img src="../assets/search_mob.png"/>
                </button>
          </form>
       </div>

       <div id="login">
         <form v-on:submit.prevent="login" id="login-form">
             <input v-model="loginForm.email" type="email">
             <input v-model="loginForm.password" type="password">
             <input type="submit">
         </form>

         <ul>
             <people-list-item v-bind:item="item" v-for="item in list"></people-list-item>
         </ul>
      </div>
      </div>

  </div>
</template>

<script>

import Vue from 'vue'

Vue.use(require('vue-resource'));

Vue.component('people-list-item', {
    props : ['item'],
    template : '<li><b>{{item.nickname}}</b> - {{item.age}} ans</li>'
})

export default {
  data()  {
    return {
      list : [],
      loginForm : {
          email : '',
          password : ''
      }
    }
  },
  methods : {
     list_users : function(){
        this.$http.get('https://api.meowtic.com/user/list')
        .then(function(response){
            let data = response.data
            if(data.success){
                this.list = data.output
            }
        }, handleError)
    },

    login : function(){
        this.$http.post('https://api.meowtic.com/user/login', this.loginForm, { emulateJSON : true })
        .then(function(response){
            let data = response.data
            if(data.success){
                // connecté
            }
            else{

            }
        }, handleError)
    },

    verify : function(email, token){
        this.$http.post('https://api.meowtic.com/user/verify/'+email+'/'+token)
        .then(function(response){
            let data = response.data
            if(data.success){

            }
            else{
                alert(data.message)
            }
        }, handleError)
    }
  }
}

var handleError = function(error){
    console.log('Error! Could not reach the API. ' + error)
}

var data = getTask();

if(data.task == 'verify'){
    this.verify(data.email, data.token)
}
else if(data.task == 'reset'){
    /*
    * ICI ON AFFICHE LE FORMULAIRE POUR RESET LE MOT DE PASSE
    * LE FORMULAIRE ENVOI LES DONNÉES => http://api.meowtic.com/user/reset
    * ON CONFIGURE LES CHAMPS DU FORMULAIRE AVEC LE TOKEN / EMAIL
    * (le but est d'envoyer en POST, le token, l'email, le nouveau mot de passe et la confirmation)
    */
}

/**
* Retourne une tâche active en parsant l'URL
*/
function getTask(){
    var search = (window.location.search).substr(1);
    var temp = search.split('&');

    var data = {};

    for(var i = 0, n = temp.length; i < n; i++){
        var temp2 = temp[i].split('=');
        var key = temp2[0] || '';
        var value = temp2[1] || '';

        if(key.length > 0){
            data[key] = value;
        }
    }
    return data;
}


</script>

<style lang="less">
 @import "../definitions";

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
  color:@lightBlue;
  letter-spacing: 0.2em;

}

.p_2{
  text-align:center;
  font-family: 'Moon';
  font-weight : lighter;
  color:@darkBlue;
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
   background-color:@lightBlue;
   display: block;
   margin: auto;
   font-family: 'Moon';
   font-weight : bold;
   color:white;
   /*box-shadow: 0 0 5px black;
   text-shadow: 0px -2px @darkBlue;*/
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
  color:@lightBlue;
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
 background-color:@lightGrey;
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
