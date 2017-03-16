<template>
  <section id="frame"   v-if="user != null">
    <img src="../assets/Meetic.png" width="110ox"/>
    <h1>Match</h1>
    <h2>Choisissez votre animal</h2>
    {{animals.id}}
    <div v-for="animal in animals" class="profile-banner">
      <router-link v-bind:to="'/match/'+ animal.id">
        <div class="profile-image">
          <img v-if="animal.profile_image != null" v-bind:src="animal.profile_image.path" v-bind:alt="animal.name">
          <img v-else src="../assets/none_profil.png">
        </div>
        <div class="profile-text">
          <span>{{animal.name}}</span>
        </div>
      </router-link>
    </div>
  </section>

  <div v-else>
    <div class="no">
      <img class="non_connecter" src="../assets/non_connecter.png"/>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {
  data() {
    return{
      choice : 0,
      user : null,
      animals: [],
      animals_info: {id:'',name:'', profile_image:''}
    }
  },

  created(){
    var that = this;
    if(this.$parent.user === ""){
      this.$http.get('user/whois')
        .then(function(response){
          let data = response.data;
          if(data.success){
            this.user = response.data.output;
          }
      });
    } else {
      this.user = this.$parent.user;
    }
    this.$http.get('user/list_animal')
    .then(function(response){
      let data = response.data;
      that.animal = response.data.output;
      if(data.success){
        var total = response.data.output.item_total;
          for(var i = 0 ; i<total ; i++){
            this.animals_info = this.animal.data[i];
            this.animals.push(this.animals_info);
          }

        }
      })
  },

}
</script>
<style lang="less">
@import "../definitions";

#frame {
  display: block;
  width:60%;
  margin: auto;
  margin-top: 2%;
  padding:3%;
  background:white;
  text-align: center;
}

.profile-banner {
  display: block;
  flex-direction: row;
  width: 60%;
  height: 7rem;
  margin: auto;
  margin-top: 1rem;
  border: 1px solid #DADADA;
  font-size: 0;
  text-align: left;
  @media (max-width: 1022px) {
    width: 100%;
    height: 20rem;
  }

  @media (max-width: 930px) {
    height: 17rem;
  }

  @media (max-width: 800px) {
    height: 15rem;
  }

  @media (max-width: 650px) {
    height: 13rem;
  }

  @media (max-width: 650px) {
    height: 11rem;
  }

  @media (max-width: 470px) {
    height: 9rem;
  }

  .profile-image {
    display: inline-block;
    vertical-align: top;
    width: 7rem;
    height: 100%;

    @media (max-width: 1022px) {
      width: 100%;
      height: 80%;
    }

    img {
      width: 100%;
      height: 100%;

    }
  }

  .profile-text {
    display: inline-block;
    vertical-align: top;
    min-width: 12rem;
    padding: 0.5rem;
    font-size: 1.2rem;
    font-family: @fontTitle;
    font-weight : bold;
    text-align: left;
    color:@darkBlue;

    @media (max-width: 1022px) {
      width: 100%;
      height: 80%;
    }

    @media (max-width: 800px) {
      font-size: 1rem;
    }

    @media (max-width: 650px) {
      font-size: 0.7rem;
    }

    @media (max-width: 550px) {
      font-size: 0.6rem;
    }

    img {
      width: 1em;
      height: 1em;
    }
  }

  @media (max-width: 1022px)
  {
    flex-direction: column;
    width: 45%;
  }
}

.profile-banner:hover {
  -moz-box-shadow: 0 0 8px 0px @darkBlue;
  -webkit-box-shadow: 0 0 8px 0px @darkBlue;
  -o-box-shadow: 0 0 8px 0px @darkBlue;
  box-shadow: 0 0 8px 0px @darkBlue;
  filter:progid:DXImageTransform.Microsoft.Shadow(color=@darkBlue, Direction=134, Strength=10);
}
</style>
