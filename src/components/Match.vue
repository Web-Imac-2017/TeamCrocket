<template>
    <section id="frame">
      <img src="../assets/Meetic.png" width="110ox"/>
      <h1>Match</h1>
      <h2>Trouvez le profil qui fera chavirer son coeur</h2>

      <div class="profile">
        <img v-if="animal.image != null" v-bind:src="animal.image.path" v-bind:alt="animal.name">
        <img v-else src="../assets/cat.jpg">
        <div>
          <ul class="title">
            <span>{{ animal.name }}</span>
            <span>
              <img v-if="animal.sex =='m'" src="../assets/man.png" alt="Homme">
              <img v-else src="../assets/woman.png" alt="Femme">
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
        <button>Valider</button>
        <button v-on:click="refuse">Refuser</button>
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
      choice : true
    }
  },

  created : function()
  {
    var that = this;
    var get_id = this.$route.params.id;
    console.log(get_id);
    that.$http.get('https://api.meowtic.com/match/get/' + get_id)
    .then(function(response){
      let data = response.data;

        if(data.success){
            that.animal = data.output;
        }
    }, handleError)
  },
  methods: {
    refuse : function()
    {
      var that = this;
      var get_id = 33;
      that.$http.post('https://api.meowtic.com/match/swipe/' + get_id + animal.id + false)
      .then(function(response){
        let data = response.data;

        if(data.success){
          that.choice = data.output;
        }

      })
    },
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
