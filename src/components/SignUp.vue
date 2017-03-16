<template>
  <section>
    <div id="form-inscription">
    <h1>Informations du proprietaire</h1>

    <form v-on:submit.prevent="signup" id="signup-form">
      <input type="hidden" name="id" value="0">
      <input type="hidden" name="latitude" :value="lat">
      <input type="hidden" name="longitude" :value="long">
      <ul>
        <li>
          <label>Pseudo</label>
          <input type="text" name="nickname" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="entre 4 et 20 caractères - lettres, chiffres - _ ou . acceptés">
          <div class="trait"></div>
        </li>
        <li>
          <label>Mail</label>
          <input type="email" name="email">
          <div class="trait"></div>
        </li>
        <li>
          <label>Mot de passe</label>
          <input type="password" name="password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="min 8 caractères, minuscule, majuscule, caractère spécial, chiffres au minimum 1 fois">
          <div class="trait"></div>
        </li>

        <li class="float_left">
          <label class="date_naissance">Date de naissance</label>
          <date-component></date-component>
        </li>

        <li class="float_right">
          <div class="sex">
            <ul>
              <li  class="float_left">
                  <label for="m"><img src="../assets/man.png" alt="Homme"/></label>
                  <input type="radio" id="m" value="m" name="sex">
              </li>
              <li class="float_left">
                <label for="f"><img src="../assets/woman.png" alt="Logo"/></label>
                <input type="radio" id="f" value="f" name="sex">
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="g-recaptcha" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>
        </li>
      </ul>
      <button type="submit">Valider
       <img src="../assets/search_mob.png" class="img_button"/>
      </button>
    </form>


  </div>
  </section>
</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

import DateComponent from "./Date.vue"

export default {
  components: {
    DateComponent
  },
  data(){
    return{
      user: null,
      lat: 0,
      long: 0
    }
  },

  mounted: function() {
      if(window.grecaptcha) {
        grecaptcha.render(document.getElementsByClassName('g-recaptcha')[0], { sitekey : "6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg" });
      }
},

created: function() {
  if (navigator.geolocation)
  {
    var that = this;
    navigator.geolocation.getCurrentPosition(function(position)
    {
      that.lat = position.coords.latitude;
      that.long = position.coords.longitude;
});
}

  },

  methods: {
    signup : function(){
      let formData = new FormData(document.getElementById('signup-form'));
      var that = this;
      that.$http.post('user/edit', formData)
        .then(function(response){
          let data = response.data;
          if(data.success){
            that.user = response.data.output;
            //location.href = 'profileuser';
          }
          else{
            alert(response.data.message);
          }
      })
    }
  },
}
</script>

<style lang="less">
@import "../definitions";
#signup-form ul li label{
  margin-left: 10%
}

#form-inscription{
  width:600px;
  margin:auto;
  margin: auto;
  background-color:white;
  border-radius: 6px;
  box-shadow : 7px 7px 4px rgba(0, 0, 0, 0.3);
}
#form-inscription label{
  font-size:1.3em;
  font-family: @fontTitle;
  font-weight : lighter;
  color:@lightBlue;
  letter-spacing: 0.1em;
  text-align: left;
}
#form-inscription label img{
  width: 40px
}

#form-inscription h1{
  font-size: 1.5em;
  padding-top:1em
}

#form-inscription input{
  width:80%;
  margin-left: 10%;
  height:2em;
  display:block;
  border-radius: 10px;
  background-color:@lightGrey;
}
#form-inscription input[type="radio"]{
  width:auto;
  margin: auto
}
div.sex{
  display: inline-block;
  padding-right: 50px;
  width: 100%
}
 li.float_left div#date_birth{
  margin-left: 2em;
  margin-top:0.3em;
  padding-bottom: 1em;

 }

 div.sex ul li{
      display: inline-block;
      margin-right: 1em;
      margin-top: -1em;
 }

 .g-recaptcha div{
  height:auto !important;
  width: auto !important;
  margin-bottom: 1em;
  padding-bottom: 0.5em;
     margin: auto;
 }
.g-recaptcha div iframe{
   margin: auto;
    height:auto !important;
    width: auto !important;
  }

 div#form-inscription button{
   z-index: 100;
   margin-top:-1em;
   margin-left: 7em;
   position: absolute;
 }
 .float_left{
   float:left;
 }
 .float_right{
   float:right;
 }

@media screen and (max-device-width:770px), screen  and (max-width:770px){



#form-inscription{
  width:80%;
  height:;
  padding-bottom: 5em;
}

div#form-inscription button{
  z-index: 100;
  margin-top:-1em;
  margin-left: 7em;
  position: absolute;
}



div#form-inscription button{
  z-index: 100;
  margin-top:3em;
  margin-left: 7em;
  position: absolute;
}

 }

 @media screen and (max-device-width:650px), screen  and (max-width:650px){

.float_left,.float_right{
  float: none;
}
}

 @media screen and (max-device-width:600px), screen  and (max-width:600px){

   label.date_naissance{
    text-align: center;
    margin-left: 5em;
   }

   div#date_birth {
     margin-left:15%;
   }

   .sex ul{
     float:left;
     margin-left: 40%;

   }

   div#form-inscription button{
     width:40%;
   }


}


@media screen and (max-device-width:480px), screen  and (max-width:480px){

  div#date_birth{
    margin-left: 10%;
  }

  label.date_naissance{
    margin-left: 10%;
  }



}

@media screen and (max-device-width:405px), screen  and (max-width:405px){

  div#date_birth{
    margin-left: 5%;
  }

  div#form-inscription button{
    width:40%;
    margin-left:20%;
  }
}

@media screen and (max-device-width:395px), screen  and (max-width:395px){

  div#date_birth{
    margin-left: -0.5%;
  }

}

</style>
