<template>
  <section id="frame">
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
        <ul>
          <span>{{animal.name}}</span>
          <li v-if="animal.age == 1">{{ animal.age }} an</li>
          <li v-if="animal.age == 0"></li>
          <li v-else>{{ animal.age }} ans</li>
          <li>
            <img v-if="animal.sex =='m'" src="../assets/man.png" alt="Homme">
            <img v-if="animal.sex =='f'" src="../assets/woman.png" alt="Femme">
            <p v-else></p>
          </li>
        </ul>
      </div>
      </router-link>
    </div>
  </section>
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
      this.$http.get('https://api.meowtic.com/user/whois')
        .then(function(response){
          let data = response.data;
          if(data.success){
            this.user = response.data.output;
          }
      });
    } else {
      this.user = this.$parent.user;
    }
    this.$http.get('https://api.meowtic.com/user/list_animal')
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
  height: 10rem;
  margin: auto;
  margin-top: 1rem;
  border: 1px solid #DADADA;
  font-size: 0;
  text-align: left;

  .profile-image {
    display: inline-block;
    vertical-align: top;
    width: 10rem;
    height: 100%;
    img {
      width: 100%;
      height: 100%;
    }
  }

  .profile-text {
    display: inline-block;
    vertical-align: top;
    min-width: 10rem;
    padding: 0.5rem;
    font-size: 1.2rem;
    font-family: @fontTitle;
    font-weight : bold;
    text-align: center;
    color:@darkBlue;
    text-align: left;

    li {
      margin-top: 0.2em;
    }

    img {
      width: 1em;
      height: 1em;
    }
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
