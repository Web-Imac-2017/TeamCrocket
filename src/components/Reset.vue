<template>
  <div id="reset_password">
    <form v-on:submit.prevent="reset" id="reset-form">
        <fieldset>
         <ul>
           <li>
             <label for="pseudo">MAIL</label>
             <input  class="forget" v-model="resetPassword.email" type="email">
           </li>
            <div class="trait">
            </div>
            <li>
              <label for="pseudo">MOT DE PASSE</label>
              <input  class="forget" v-model="resetPassword.pw1" type="password">
            </li>
             <div class="trait">
             </div>
             <li>
               <label for="pseudo">VERIFICATION</label>
               <input  class="forget" v-model="resetPassword.pw2" type="password">
             </li>
              <div class="trait">
              </div>
          </ul>
        </fieldset>
          <button type="submit" id="button_validation" class="button_style">VALIDER

          </br>
          <img src="../assets/search_mob.png"/>
          </button>
    </form>
  </div>
</template>



<script>

  import Vue from 'vue'

  Vue.use(require('vue-resource'));

  export default {
    data()  {
      return{
        list : [],
        resetPassword : {
            email : '',
            pw1 : '',
            pw2 : '',
        }
      }
    },
    methods : {

      reset : function(){
          this.$http.post('https://api.meowtic.com/user/reset', this.resetPassword, { emulateJSON : true })
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
