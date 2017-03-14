<template>
    <section id="frame">
      <img src="../assets/Meetic.png" width="110ox"/>
      <h1>Match</h1>
      <h2>Trouvez le profil qui fera chavirer son coeur</h2>
      <div v-if="loading">
        <h3>loading ...</h3>
      </div>
      <div v-else-if="animal != null">
        <div class="profile">
          <img v-if="animal.image != null" v-bind:src="animal.image.path" v-bind:alt="animal.name">
          <img v-else src="../assets/cat.jpg">
          <div>
            <ul class="title">
              <span>{{ animal.name }}</span>
              <span>
                <img v-if="animal.sex =='m'" src="../assets/man.png" alt="Homme">
                <img v-if="animal.sex =='f'" src="../assets/woman.png" alt="Femme">
                <p v-else></p>
              </span>
            </ul>
            <ul>
              <li>1 an</li>
              <li>Espiègle</li>
              <li>Aime {{ animal.like }}</li>
              <li>N'aime pas {{ animal.dislike }}</li>
            </ul>
          </div>
        </div>
        <div id="choice">
          <button v-on:click="accept">Valider</button>
          <button v-on:click="refuse">Refuser</button>
        </div>
      </div>
      <div v-else>
        <img src="../assets/crying_dog.jpg" width="400ox">
        <h3>Aucun match disponible</h3>
      </div>
    </section>
</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      user : null,
      animal : {
        name: '',
        sex: '',
        like: '',
        dislike: ''
      },
      choice : false,
      loading : true
    }
  },

  created : function()
  {
    this.get();
  },

  methods: {
    get : function()
    {
      var that = this;
      var get_id = this.$route.params.id
      this.loading = true;
      that.$http.get('https://api.meowtic.com/match/get/' + get_id)
      .then(function(response){
        let data = response.data;
        that.loading = false;
          if(data.success){
              that.animal = data.output;
              if(data.ouput == null)
              {
                return
              }
          }
      }, handleError)
    },

    refuse : function()
    {
      var that = this;
      var get_id = this.$route.params.id
      var interested = 0;
      that.$http.get('https://api.meowtic.com/match/swipe/' + get_id + '/' + that.animal.id + '/' + interested)
      .then(function(response){
        let data = response.data;
        console.log(data.output.interested);

        if(data.success){
          that.choice = data.output.interested;
          this.get();
        }
      })
    },

    accept : function()
    {
      var that = this;
      var get_id = this.$route.params.id
      var interested = 1;
      that.$http.get('https://api.meowtic.com/match/swipe/' + get_id + '/' + that.animal.id + '/' + interested)
      .then(function(response){
        let data = response.data;

        if(data.success){
          that.choice = data.output.interested;
          alert("un message a été envoyé");
          this.get();
        }
      })
    }
  }
}


var handleError = function(error){
    console.log('Error! Could not reach the API. ' + error)
}

</script>

<style lang="less">

 @import "../definitions"; /* import common definitions */

  #frame {
    display: block;
    width:60%;
    margin: auto;
    margin-top: 2%;
    margin-bottom: 2%;
    padding:3%;
    background:white;
    text-align: center;
  }


  .profile {
    display: flex;
    flex-direction: row;
    width: 80%;
    margin: auto;
    margin-top: 2em;
    border: 1px solid #DADADA;

    img {
      height: 40%;
      width: 40%;
    }

    div {
      padding: 4%;
      height: 46%;
      width: 46%;

      text-align: left;
      color: @darkBlue;

      span {
        display: block;
        text-transform: uppercase;
        font-weight:bolder;
        font-size: 1.1em;
        text-align: center;
        margin-bottom: 0.7em;
      }

      ul li {
        display: block;
        font-weight: 100;
      }
    }

    @media (max-width: 700px)
    {
      flex-direction: column;
      width: 40%;

      img, div {
        width: 100%;
      }
    }
  }

  #choice {
    display: flex;
    width: 60%;
    margin: auto;

    a {
      height: 10em;
      width: 10em;
      line-height: 10em;
      border-radius: 100%;
      color: @lightBlue;
      margin: 1em;
    }

    a.accept {
      background-color: #0F0;
    }

    a.refuse {
      background-color: #F00;
    }
  }
</style>
