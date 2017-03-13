<template>
  <div id="popup_profile">
    <router-link :to="{name: 'profileuser'}"><h2>Mon compte</h2></router-link>
    <div v-on:click="logout"><h2>Se deconnecter</h2><img src="../assets/deconnexion.png" alt="deco" id="img_deco"></div>
  </div>
</template>

<script>
export default {
  components : {

  },
  data(){
    return{
      addPet: {
        id: 0,
        name: '',
        species_id: ''
    }
  }
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
  display: inline-block;
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
