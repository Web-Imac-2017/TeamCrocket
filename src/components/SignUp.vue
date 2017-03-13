<template>
  <section>
    <h2>Informations du proprietaire</h2>

    <form v-on:submit.prevent="signup" id="signup-form">
      <input type="hidden" name="id" value="0">
      <input type="hidden" name="latitude" :value="lat">
      <input type="hidden" name="longitude" :value="long">
      <ul>
        <li>
          <label>Pseudo*</label>
          <input type="text" name="nickname" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="entre 4 et 20 caractères - lettres, chiffres - _ ou . acceptés">
        </li>
        <li>
          <label>Mail*</label>
          <input type="email" name="email">
        </li>
        <li>
          <label>Mot de passe (minimum 8 caractères avec au moins 1 minuscule, majuscule, chiffre et caractère spécial)*</label>
          <input type="password" name="password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="min 8 caractères, minuscule, majuscule, caractère spécial, chiffres au minimum 1 fois">
        </li>

        <li>
          <label>Date de naissance*</label>
          <date-component></date-component>
        </li>

        <li>
          <div class="sex">
            <input type="radio" id="m" value="m" name="sex">
            <label for="m"><img src="../assets/man.png" alt="Homme"/></label>
            <input type="radio" id="f" value="f" name="sex">
            <label for="f"><img src="../assets/woman.png" alt="Logo"/></label>
          </div>
        </li>
        <li>
          <div class="g-recaptcha" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>
        </li>
      </ul>
      <div>
        <button type="submit">Valider</button>
      </div>
    </form>

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
      alert(that.long);
});
}

  },

  methods: {
    signup : function(){
      let formData = new FormData(document.getElementById('signup-form'));

      var that = this;
      that.$http.post('https://api.meowtic.com/user/edit', formData)
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

#signup-form {
  text-align: center;
}
</style>
