<template>
  <header>
    <div class="part_left">
      <a href="/"><img src="../assets/logo_simple.png" alt="Logo" class="logo"></a>
      <img src="../assets/patoune.png" alt="Logo" class="logo_mob">
      <div id="research">
        <input type="search" placeholder="Entrez un mot-clef" name="the_search">
        <button id="button_research">
          <img src="../assets/search.png" alt="research">
        </button>
      </div>
    </div>
    <div class="part_right">
      <ul>
        <li><router-link :to="{name: 'root'}"><img src="../assets/home.png" alt="home"></router-link></li>
        <li class="mob separate"><img src="../assets/separate.jpg"></li>
        <li class="mob"><img src="../assets/search_mob.png" alt="search"></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li><router-link :to="{name: 'choicematch'}"><img src="../assets/match.png" alt="message"></router-link></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li><router-link :to="{name: 'messenger'}"><img src="../assets/message.png" alt="message"></router-link></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li v-on:click="popup"><img src="../assets/profile.png" alt="profile"></li>
        <div id="popup_profile">
          <div  v-on:click="popup">
            <router-link :to="{name: 'profileuser'}"><h2>Modifier votre compte  <img src="../assets/edit.png" id="img_user_edit"/></h2></router-link>
            <div class="trait"></div>
          </div>
          <div id="list_pet">
            <h2>Mes animaux</h2>
            <div v-for="a in animals"  v-on:click="popup">
              <router-link  v-bind:to="'/profileanimal/'+ a.id">
                <div class="profile_animal">
                    <img v-if="a.profile_image != null" v-bind:src="a.profile_image.path" v-bind:alt="a.name">
                </div>
                {{a.name}}
              </router-link>
            </div>
          </div>
          <div   v-on:click="popup">
            <div id="deco" v-on:click="logout"><h2>Se deconnecter</h2><img src="../assets/deconnexion.png" alt="deco" id="img_deco"></div>
          </div>
        </div>
      </ul>
    </div>
  </header>
</template>

<script>

import Vue from 'vue'
Vue.use(require('vue-resource'));


export default {
  data(){
    return{
      choice:0,
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
  methods : {
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
    },
    popup : function () {
        if(document.getElementById("popup_profile").style.display == 'block'){
            document.getElementById("popup_profile").style.display = 'none'
        }else{
              document.getElementById("popup_profile").style.display = 'block'
        }
    }

}}


var handleError = function(error){
    console.log('Error! Could not reach the API. ' + error)
}

</script>

<style lang="less">
 @import "../definitions"; /* import common definitions */
/**************************
      MENU
************************/

header{
  position:fixed;
  display:block;
  width:90%;
  height: @headerHeight;
  line-height: @headerHeight;
  padding-left:5%;
  padding-right:5%;
  top:0;
  left:0;
  background-color:@darkBlue;
  z-index:99;
}
.part_left{
  display: block;
  flex-direction: row;
  float:left;
  width:65%;
}
header .logo{
  height: 35px;
  display: inline-block;
  vertical-align: middle;
}
header .logo_mob{
  display:none;
}
#research{
  display: inline-block;
  margin-left: 1em;
}
#research input{
  height:25px;
  border-radius:5px;
  width:50%;
  min-width:275px;
}
#button_research{
  background-color:@darkBlue;
  width:30px;
  border:none;
  vertical-align:middle;
}
#button_research img{
  width: 100%;
}
.part_right{
  width:35%;
  float:right;
}
header ul{
  float:right;
  padding:0;
  margin:0;
}
header ul li img{
  height:25px;
  vertical-align: middle;
}
header ul li {
  display: inline-block;
  margin: 0 10px;
}
.separate{
  height:100%
}
li.mob{
  display:none;
}

/*******************************
      POP UP
*******************************/

#popup_profile {
  background-color: white;
  display: none;
}
#popup_profile #list_pet{
  overflow: auto;
  max-height: 400px;
}
#popup_profile #list_pet div{
  padding: 0.2em;
  padding-left:0.4em
}
#popup_profile h2{
  margin-left: 1em;
}
#popup_profile div h2{
  margin: auto;
}
#deco{
  display: block;
  margin:auto;
  width:70%;
}
#popup_profile #deco h2{
  display: inline-block;
  vertical-align: middle;
}
#popup_profile img#img_deco, img#img_user_edit{
  margin-left: 1em;
  width: 20px;
  vertical-align: middle;
  display: inline-block;
}

@media screen and (max-device-width:930px), screen  and (max-width:930px){
    #research input{
      min-width:250px;
    }
    header .logo_mob{
      float:left;
      vertical-align:middle;
      margin-top:7px;
      display:block;
      width:35px;
    }
    header .logo{
      display:none
    }
    .part_left{
      width:55%;
    }
    .part_right{
      width:45%;
    }
}

div.part_right ul li img{
     cursor:pointer;
}


@media screen and (max-device-width:800px), screen  and (max-width:800px){
  header .logo{
    display:none;
  }
  #research{
    width:auto;
  }
  header .logo_mob{
    display: inline-block;
    vertical-align:middle;
    height: 35px;
  }
}

@media screen and (max-device-width:700px), screen  and (max-width:700px){
  #research input{
    min-width:200px;
  }
  .part_left{
    width:50%;
  }
  .part_right{
    width:50%;
  }
}
@media screen and (max-device-width:650px), screen  and (max-width:650px){
  header ul{
    width:100%;
    margin:0;
  }
  header ul li{
    width:17%;
    text-align:center;
    margin:0;
  }
  header ul li.separate{
    width:1%;
  }
  li.mob{
   display:inline-block;
  }
  .part_left{
    display:none;
  }
  .part_right{
    width:100%;
  }
}

</style>
