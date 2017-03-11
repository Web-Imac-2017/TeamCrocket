<template>
    <section id="frame">
      <img src="../assets/Meetic.png" width="110ox"/>
      <h1>Match</h1>
      <h2>Trouvez le profil qui fera chavirer votre coeur</h2>

      <div class="profile">
        <img src="../assets/cat.jpg"/>
        <div>
          <span>{{ animal.name }}</span>
          <ul>
            <li>1 an</li>
            <li>Espiègle</li>
            <li>Aime dormir</li>
            <li>N'aime pas l'eau</li>
          </ul>
        </div>
      </div>
      <div id="choice">
        <a class="accept" href="">accept</a>
        <a class="refuse" href="">refuse</a>
      </div>
    </section>
</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      animal : {
        name: '',
        sex: '',
        like: '',
        dislike: ''
      }
    }
  },
  get : function()
  {
    this.$http.get('https://api.meowtic.com/match/get')
    .then(function(response){
        let data = response.data;
        if(data.success){
            console.log(data.success);
            this.animal = data.output;
        }
    }, handleError)

  },
  created : function()
  {
    this.$http.get('https://api.meowtic.com/match/get')
    .then(function(response){
        let data = response.data;
        if(data.success){
            console.log(data.success);
            this.animal = data.output;
        }
    }, handleError)
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
