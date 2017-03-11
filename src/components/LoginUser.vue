<template>
     <div id ="form_connexion">
        <form v-on:submit.prevent="login" id="login-form">
            <fieldset>
             <ul>
                <li>
                  <label for="pseudo">MAIL</label>
                  <input  class="pseudo" v-model="loginForm.email" type="email">
                  <div class="trait"></div>
                </li>

                <li>
                  <label for="pseudo">MOT DE PASSE</label>
                  <input class="pseudo" v-model="loginForm.password" type="password">
                  <div class="trait"></div>
                </li>
              </ul>
              <div id="pw_lost">Mot de passe perdu ?</div>
              <div class="button_validation" >
                <button type="submit" class="button_style">VALIDER
                  <img src="../assets/search_mob.png" class="img_button"/>
                </button>
              </div>
            </fieldset>

        </form>
     </div>

</template>


<script>

  import Vue from 'vue'

  Vue.use(require('vue-resource'));

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

      login : function(){
          this.$http.post('https://api.meowtic.com/user/login', this.loginForm, { emulateJSON : true })
          .then(function(response){
              let data = response.data
              if(data.success){
                  location.href = 'profileuser'
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
  @import "../definitions"; /* import common definitions */


  #form_connexion{
    width:600px;
    margin:auto;
    margin: auto;
    background-color:white;
    border-radius: 6px;
    box-shadow : 7px 7px 4px rgba(0, 0, 0, 0.3);
  }
  #form_connexion label{
    font-size:1.3em;
    font-family: 'Moon';
    font-weight : lighter;
    color:@lightBlue;
    letter-spacing: 0.1em;
    padding-left:11%;


  }
  form#login-form fieldset{
    width:70%;
    padding-bottom:2em;
    margin:auto;
  }
  form#login-form fieldset ul li{
      margin-top:1em;
    }



.pseudo{
   width:80%;
   margin-left: 10%;
   height:2em;
   display:block;
   border-radius: 10px;
   background-color:@lightGrey;
   }


  #main-index li {
    padding-top:25px;
  }

  #pw_lost{
    text-align:right;
    color:@lightBlue;
    font-family:@fontText;
    margin-top:1em;
  }

  @media screen and (max-width: 700px ) {
    #form_connexion{
      width:90%;
    }
  }
  @media screen and (max-width: 500px ) {
    form#login-form fieldset{
        width:90%;
    }
}
</style>
