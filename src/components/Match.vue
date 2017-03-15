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
            <ul>
              <span>{{ animal.name }}</span>
              <li v-if="animal.age == 1">{{ animal.age }} an</li>
              <li v-if="animal.age == 0"></li>
              <li v-else>{{ animal.age }} ans</li>
              <li>
                <img v-if="animal.sex =='m'" src="../assets/man.png" alt="Homme">
                <img v-if="animal.sex =='f'" src="../assets/woman.png" alt="Femme">
                <p v-else></p>
              </li>
            </ul>
            <ul class="text">
              <li v-if="animal.like != ''">Aime {{ animal.like }}</li>
              <li v-if="animal.dislike != ''">N'aime pas {{ animal.dislike }}</li>
              <li v-else></li>

            </ul>
          </div>
        </div>
        <div v-on:click="accept"> Valider <!-- id="choice" -->
          <!-- <button  v-on:click="accept">Valider</button>
          <button v-on:click="refuse">Refuser</button> -->
        </div>
        <span id="popup">Popup text...</span>

      </div>
      <div v-else>
        <img src="../assets/crying_dog.jpg" class="no_match">
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
      var get_id = this.$route.params.id;
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
          var popup = document.getElementById("popup");
          popup.style.display = "block";
          window.setTimeout(function()
          {
            popup.style.display = "none"
            that.get();
          }, 2000);

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
      padding: 2%;
      height: 46%;
      width: 46%;
      text-align: left;
      color: @darkBlue;

      span {
        display: block;
        font-family: @fontTitle;
        font-weight: bold;
        font-size: 1.1em;
        text-align: center;
        margin-bottom: 0.7em;
      }

      ul li {
        display: block;
        font-weight: 100;

        img {
          width: 8%;
        }
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

  .no_match {
    margin-top: 1em;
    width: 60%;
  }
/*
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


*/
#popup {
  display: none;
  position: absolute;
  height: 20%;
  width: 60%;
  top : 40%;
  left: 20%;
  background-color: #0FF;
  -webkit-animation: fade 2s;
  animation: fade 2s
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fade {
    from {opacity: 0;}
    40% {opacity: 1;}
    60% {opacity: 1;}
    to {opacity: 0;}
}

@keyframes fade {
  from {opacity: 0;}
  40% {opacity: 1;}
  60% {opacity: 1;}
  to {opacity: 0;}
}
</style>
