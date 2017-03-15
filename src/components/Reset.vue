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
    </form>

            <div id="button_reset">
              <button type="submit" id="button_validation" class="button_style">VALIDER
              </br>
              <img src="../assets/search_mob.png"/>
              </button>
            </div>
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


<style lang="less">
  @import "../definitions"; /* import common definitions */

#reset_password{
  width:600px;
  margin:auto;
  margin: auto;
  background-color:white;
  border-radius: 6px;
  box-shadow : 7px 7px 4px rgba(0, 0, 0, 0.3);
  padding-top:1em;
  padding-bottom:3em;
  margin-bottom:3em;
  margin-top: 7em;
}
#reset_password label{
  font-size:1.3em;
  font-family: 'Moon';
  font-weight : lighter;
  color:@lightBlue;
  letter-spacing: 0.1em;
  padding-left:20px;

}
#reset_password p{
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


button#button_validation.button_style{
  border-radius: 6px;
  background-color:@lightBlue;
  font-size:1.2em;
  font-family: 'Moon';
  color:white;
  cursor:pointer;
  padding-right: 0.8em;
  padding-left: 0.8em;
  padding-top: 0.2em;
  padding-bottom: 0.2em;
  width:8em;
}

#button_reset{
   margin-left: auto;
   margin-right: auto;
   width: 20%;
   position: absolute;
   margin-left: 14em;
   margin-top: 2em;
}



button#button_validation.button_style img{
width:1em;
}

@media screen and (max-width: 700px ) {
  #reset_password{
    width:90%;
  }
}

@media screen and (max-device-width:440px), screen  and (max-width:440px){
  #button_reset{
     margin-left: 31%;
  }

}
</style>
