<template>
    <section id="frame" >
      <img src="../assets/Meetic.png" width="110ox"/>
      <h1>Match</h1>
      <h2>Trouvez le profil qui fera chavirer son coeur</h2>
      <div class="load" v-if="loading">
        <h3>Nous recherchons son âme sœur...</h3>
      </div>
      <div v-else-if="animal != null">
        <div class="profile">
          <img v-if="animal.profile_image != null" v-bind:src="animal.profile_image.path" v-bind:alt="animal.name">
          <img v-else src="../assets/none_profil.png">
          <div>
              <span>{{ animal.name }}</span>

              <ul>
                <li>
                  <img v-if="animal.sex =='m'" src="../assets/man.png" alt="Homme">
                  <img v-if="animal.sex =='f'" src="../assets/woman.png" alt="Femme">
                  <img v-if="animal.sex ==''" src="../assets/unknown.png" alt="Hermaphrodite">
                  <p v-else></p>
                </li>
                <li v-if="animal.age == 1">{{ animal.age }} an</li>
                <li v-if="animal.age > 1">{{ animal.age }} ans</li>
                <li v-else></li>
            </ul>
            <ul class="text">
              <li v-if="animal.description != ''">{{ animal.description }}</li>
              <li v-if="animal.like != ''">Aime {{ animal.like }}</li>
              <li v-if="animal.dislike != ''">N'aime pas {{ animal.dislike }}</li>
              <li v-else></li>
            </ul>
          </div>
        </div>
        <div id="button_choice">
          <button class="button_accept" v-on:click="accept"> Valider </button>
          <button class="button_refuse" v-on:click="refuse"> Refuser </button>
          <span id="popup">Un message a été envoyé à {{ animal.name }}.</span>
      </div>
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
      animal : null,
      choice : false,
      loading : true,
      sex : 0
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
          }, 3000);
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

  .load {
    margin-bottom: 11em;
  }

  h3 {
    color: @darkBlue;
    padding-top: 8em;
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
        font-size: 2em;
        text-align: center;
        margin-bottom: 0.7em;
        padding-top: 0.5em;
      }

      ul {
        text-align: center;
      }

      ul li {
        display : inline;
        font-weight: 100;
        font-size: 1.2em;

        img {
          width: 15%;
        }
      }

      .text {
        display: block;
        text-align: left;

      }
    }

    @media (max-width: 700px)
    {
      flex-direction: column;
      width: 45%;

      img, div {
        width: 100%;
      }
    }
  }

  #button_choice{
    width:100%;
    padding-top: 1em
  }

  .button_match(){
   width:10em;
   border-radius: 6px;
   letter-spacing: 0.2em;
   padding:0.3em;
   background-color:@lightBlue;
   display: block;
   //margin-bottom: 1em;
   font-size:1.3em;
   font-family: @fontTitle;
   font-weight : bold;
   color:white;
   cursor:pointer;
 }

 .button_accept{
   .button_match;
   margin:auto;
   background-color: @pink;
 }

 .button_refuse{
   .button_match;
    margin:auto;
 }


  .no_match {
    margin-top: 1em;
    width: 60%;
  }

#popup {
  display: none;
  position: absolute;
  height: 20%;
  width: 60%;
  top : 40%;
  left: 20%;
  padding-top: 5em;
  background-color: @lightBlue;
  font-size: 1.2em;
  color: white;
  -webkit-animation: fade 2s;
  animation: fade 3s
}

/* Popup animation */
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
