<template>
  <div id="popup_profile">
    <router-link :to="{name: 'profileuser'}"><h2>Mon compte</h2></router-link>
    <div id="list_pet">
      <div v-for="a in animals">
        <div class="profile_animal">
          <img v-if="a.profile_image != null" v-bind:src="a.profile_image.path" v-bind:alt="a.name">
        </div>
        {{a.name}}
      </div>
    </div>
    <div v-on:click="logout"><h2>Se deconnecter</h2><img src="../assets/deconnexion.png" alt="deco" id="img_deco"></div>
  </div>
</template>

<script>
export default {
  components : {

  },
  data(){
    return{
      animals :[],
      animals_info: {id:'',name:'', profile_image:''},
      addPet: {
        id: 0,
        name: '',
        species_id: ''
    }
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
  methods: {
    logout : function(){
        this.$http.post('https://api.meowtic.com/user/logout')
        .then(function(response){
            let data = response.data
            if(data.success){
                location.href = 'root'
            }
            else{

            }
        })
    }

  }

}
</script>

<style lang="less">
@import "../definitions";
#list_pet{
  max-height: 50%;
  overflow: auto;
  max-height: 400px
}
#popup_profile {
  background-color: white;
}

div#popup_profile h2{
  margin-left: 1em;
}


div#popup_profile div h2{
    display: inline-block;
    vertical-align: middle;
}

div#popup_profile div{
  vertical-align: middle;
}

a{
  text-decoration: none;
}

img#img_deco{
  margin-left: 1em;
  width: 20px;
  vertical-align: middle;
  display: inline-block;
}
</style>
