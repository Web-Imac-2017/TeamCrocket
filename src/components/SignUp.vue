<template>
  <section>
    <h2>Informations du proprietaire</h2>

    <form v-on:submit.prevent="signup" id="signup-form">
        <label>Pseudo*</label>
        <input type="text" v-model="signupForm.nickname">
        <label>Prénom</label>
        <input type="text" v-model="signupForm.firstname">
        <label>Nom</label>
        <input type="text" v-model="signupForm.lastname">
        <label>Mail*</label>
        <input type="text" v-model="signupForm.email">
        <label>Mot de passe (les contraintes)*</label>
        <input type="text" v-model="signupForm.password">
        <!-- Sexe + image + date de naissance -->
        <label>Ville</label>
        <input type="text" v-model="signupForm.city">
        <label>Pays</label>
        <input type="text" v-model="signupForm.country">
        <div class="g-recaptcha" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>

<!--
        <div>
          <span>Description</span>
          <br>
          <textarea type="text" v-model="description"></textarea>
        </div>
      -->
    </form>

  <div>
    <button v-on:click="submit()">Valider</button>
  </div>

  </section>
</template>

<script>
export default {
data(){
  return{
    rcapt_sig_key: "6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg",
    rcapt_id: 0, // will be used later
    choice: 0,
    signupForm: {
      id: 0,
      nickname: '',
      password: '',
      lastname: '',
      firstname: '',
      email: '',
      sex: 'm',
      image_id: 0,
      description: '',
      city: '',
      country_id: 0,
      position : {lat: 0, lng: 0},
      date_birth: '18/01/1995'
    }
  }
},

mounted: function() {
  if (window.grecaptcha) {
    this.rcapt_id = grecaptcha.render( $('g-recaptcha')[0], { sitekey : this.rcapt_sig_key });
  }

  g_recaptcha_response = grecaptcha.getResponse(this.rcapt_id);
  if (g_recaptcha_response.length == 0) {
     this.error = "Compleate captcha challenge";
     return
  }
},



methods: {
  add: function(){
    this.choice = 1;
  },

  submit() {
    /*
    var signupForm = {
      nickname: this.signupForm.nickname,
      password: this.signupForm.password,
      lastname: this.signupForm.lastname,
      firstname: this.signupForm.firstname,
      email: this.signupForm.email,
      description: this.signupForm.description,
      city: this.signupForm.city
    }
    */
    this.$http.post('https://api.meowtic.com/user/edit', this.signupForm)
  }
},
}
</script>

<style lang="less">
@import "../definitions";
.g-recaptcha form-group
{
  height: 10em;
  width: 10em;

}
</style>
