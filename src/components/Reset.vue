<template>
  <div id="reset_password">
    <form v-on:submit.prevent="reset" id="reset-form">
        <fieldset>
         <ul>
            <li>
              <label for="pseudo">MOT DE PASSE</label>
              <input  class="forget" v-model="resetPassword.password1" type="password">
            </li>
             <div class="trait">
             </div>
             <li>
               <label for="pseudo">VERIFICATION</label>
               <input  class="forget" v-model="resetPassword.password2" type="password">
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
            mail : data[0],
            token : data[1],
            password1 : '',
            password2 : '',
        }
      }
    },
    methods : {

      reset : function(){
          this.$http.post('https://api.meowtic.com/user/reset', this.resetPassword,{ emulateJSON : true })
          .then(function(response){
          alert('yo');
              let data = response.data;
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

  var data =  getTask();

  function getTask(){
      var search = "https://www.meowtic.com/?task=reset&email=prigent.gwenn@gmail.com&token=qIelRAnygBzyGrTLfPKE0s1CNzjvjlSj";
      var regex_mail = /[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}/;
      var regex_token = search.match(/token=(.+)/);
      var data = {};
      data[0] = search.match(regex_mail);
      data[1] = regex_token.toString().substr(6);
      return data;

    }
</script>
