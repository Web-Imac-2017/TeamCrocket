<template>
  <div id="forgotten_password">
    <h1>Mot de passe oublié ?</h1>
    <p>Saisissez l'adresse e-mail associé à votre compte Meowtic.</p>
    <form v-on:submit.prevent="forgottenpassword" id="forgottenpassword-form">
        <fieldset>
         <ul>
          <li>
            <label for="pseudo">MAIL</label>
            <input  class="forget" v-model="forgottenPassword.email" type="email">
            <div class="trait"> </div>
          </li>
          </ul>
        </fieldset>
        <div class="button_validation" >
          <button type="submit" class="button_style">VALIDER
          <img src="../assets/search_mob.png" class="img_button"/>
          </button>
        </div>
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
        forgottenPassword : {
            email : ''
        }
      }
    },
    methods : {
    forgottenpassword : function(){
          this.$http.post('https://api.meowtic.com/user/forgottenpassword/' + this.forgottenPassword.email , { emulateJSON : true })
          .then(function(response){
              let data = response.data
              if(data.success){
                  // connecté
              }
              else{

              }
          }, handleError)
      }
    }
  }

</script>


<style lang="less">
  @import "../definitions"; /* import common definitions */

#forgotten_password{
  width:600px;
  margin:auto;
  margin: auto;
  background-color:white;
  border-radius: 6px;
  box-shadow : 7px 7px 4px rgba(0, 0, 0, 0.3);
  padding-top:1em;
  padding-bottom:3em;
  margin-bottom:3em;
}
#forgotten_password label{
  font-size:1.3em;
  font-family: 'Moon';
  font-weight : lighter;
  color:@lightBlue;
  letter-spacing: 0.1em;
  padding-left:20px;

}
#forgotten_password p{
  margin:1em;
}

#forgottenpassword-form fieldset ul{
  width:80%;
  margin:auto;
}
input.forget{
   width:100%;
   height:2em;
   display:block;
   border-radius: 10px;
   background-color:@lightGrey;
}

@media screen and (max-width: 700px ) {
  #forgotten_password{
    width:90%;
  }
}
</style>
