<template>
  <section id="frame">
    <img src="../assets/Meetic.png" width="110ox"/>
    <h1>Match</h1>
    <h2>Choisissez votre animal</h2>
    {{animals.id}}
    <div v-for="a in animals">
          <router-link  v-bind:to="'/match/'+ a.id">
          <div class="match_animal">
            <img v-if="a.profile_image != null" v-bind:src="a.profile_image.path" v-bind:alt="a.name">
          </div>
          {{a.name}}
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

</style>
