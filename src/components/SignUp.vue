<template>
  <section>
    <h2>Informations du proprietaire</h2>

    <form v-on:submit.prevent="signup" id="signup-form">
        <label>Pseudo*</label>
        <input type="text" v-model="signupForm.nickname">
        <label>Mail*</label>
        <input type="text" v-model="signupForm.email">
        <label>Mot de passe (les contraintes)*</label>
        <input type="text" v-model="signupForm.password">
        <!-- Sexe + image + date de naissance -->
        <div class="g-recaptcha" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>
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
    user: null,
    signupForm: {
      id: 0,
      nickname: '',
      password: '',
      email: '',
      sex: 'm',
      position : {lat: 0, lng: 0},
      date_birth: '18/01/1995',
      "g-recaptcha-response": ''
    }
  }
},

mounted: function() {
  if (window.grecaptcha) {
    this.rcapt_id = grecaptcha.render(document.getElementsByClassName('g-recaptcha')[0], { sitekey : this.rcapt_sig_key });
  }
  var g_recaptcha_response = grecaptcha.getResponse(this.rcapt_id);

  if (g_recaptcha_response.length == 0) {
     this.error = "Compleate captcha challenge";
     return
  }
},

methods: {
  add: function(){
    this.choice = 1;
  },

  submit : function(){
    this.signupForm["g-recaptcha-response"] = grecaptcha.getResponse(this.rcapt_id);
    this.$http.post('https://api.meowtic.com/user/edit', this.signupForm, { emulateJSON : true })
      .then(function(response){
        let data = response.data;
        if(data.success){
          console.log('Profile créé');
          this.user = response.data.output;
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
.g-recaptcha form-group
{
  height: 10em;
  width: 10em;

}
</style>
