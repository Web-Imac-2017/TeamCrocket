<template>
  <section>
    <h2>Informations du proprietaire</h2>

    <form v-on:submit.prevent="signup" id="signup-form">
      <ul>
        <li>
          <label>Pseudo (entre 4 et 20 caractères - lettres, chiffres - _ ou . acceptés)*</label>
          <input type="text" v-model="signupForm.nickname">
        </li>
        <li>
          <label>Mail*</label>
          <input type="text" v-model="signupForm.email">
        </li>
        <li>
          <label>Mot de passe (les contraintes)*</label>
          <input type="text" v-model="signupForm.password">
        </li>
        <li>
          <label>Date de naissance*</label>
          <input type="date" v-model="signupForm.date_birth">
        </li>
        <li>
          <div class="sex">
            <input type="radio" id="m" value="m" v-model="signupForm.sex">
            <label for="m"><img src="../assets/man.png" alt="Homme"/></label>
            <input type="radio" id="f" value="f" v-model="signupForm.sex">
            <label for="f"><img src="../assets/woman.png" alt="Logo"/></label>
          </div>
        </li>
        <li>
          <div class="g-recaptcha" data-sitekey="6LcIPBUUAAAAAL7aFlWT0BNXe6nNKbRUTvQNrhXg"></div>
        </li>
      </ul>
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
    user: null,
    signupForm: {
      id: 0,
      nickname: '',
      password: '',
      email: '',
      sex: '',
      position : {lat: 0, lng: 0},
      date_birth: '',
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
     this.error = "Complete captcha challenge";
     return
  }
},

methods: {
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

#signup-form {
  text-align: center;
}
</style>
