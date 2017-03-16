<template>
    <section id="frame">    
      <div v-if="loading">
        <h3>loading ...</h3>
      </div>

      <div v-else-if="animal != null">
      <div v-for="a in animals">
          <router-link  v-bind:to="'/profileanimal/'+ a.id">
        <div class="profile_2">
          <img v-if="a.profile_image!= null" v-bind:src="a.profile_image.path" v-bind:alt="a.name">
          <img v-else src="../assets/cat.jpg">
          <div>
            <ul>
              <span>{{ a.name }}</span>
              <li v-if="a.age == 1">{{ a.age }} an</li>
              <li v-if="a.age == 0"></li>
              <li v-else>{{ a.age }} ans</li>
              <li>
                <img v-if="a.sex =='m'" src="../assets/man.png" alt="Homme">
                <img v-if="a.sex =='f'" src="../assets/woman.png" alt="Femme">
                <p v-else></p>
              </li>
            </ul>
            <ul class="text">
              <li v-if="a.like != ''">Aime {{ a.like }}</li>
              <li v-if="a.dislike != ''">N'aime pas {{ a.dislike }}</li>
              <li v-else></li>

            </ul>
          </div>
        </div>
            </router-link>
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
      loading : true,
      animals :[],
      animals_info: {id:'',name:'', profile_image:''},
      addPet: {
        id: 0,
        name: '',
        species_id: ''
    }
    }
  },

  created : function()
  {
    var that = this;
    this.loading = true;
    that.$http.get('https://api.meowtic.com/profile/list')
    .then(function(response){
      let data = response.data;
      that.loading = false;
        if(data.success){
            that.animal = data.output;
            var total = response.data.output.item_total;
            for(var i = 0 ; i<total ; i++){
            this.animals_info = this.animal.data[i];
            this.animals.push(this.animals_info);
              }

            if(data.ouput == null)
            {
              return
            }
        }
    }, handleError)
  },

  methods : {
  sex : function(){
    var that = this;
    this.loading = true;
    that.$http.get('https://api.meowtic.com/profile/list')
    .then(function(response){
      let data = response.data;
      that.loading = false;
        if(data.success){
            that.animal = data.output;
            var total = response.data.output.item_total;
            for(var i = 0 ; i<total ; i++){
            this.animals_info = this.animal.data[i].sex;
            this.animals.push(this.animals_info);
              }

            if(data.ouput == null)
            {
              return
            }
        }
    }, handleError)
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
    margin-bottom: 2%;
    padding:3%;
    background:white;
    text-align: center;
  }

  .profile_2 {
    display: flex;
    flex-direction: row;
    width: 50%;
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
