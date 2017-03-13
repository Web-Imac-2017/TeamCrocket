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
        <li><router-link :to="{name: 'match'}"><img src="../assets/match.png" alt="message"></router-link></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li><router-link :to="{name: 'messenger'}"><img src="../assets/message.png" alt="message"></router-link></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li v-on:click="popup"><img src="../assets/profile.png" alt="profile"></li>
        <popup-component v-if="choice == 1"></popup-component>
        <p v-else>
        </p>
      </ul>
    </div>
  </header>
</template>

<script>

import Vue from 'vue'
Vue.use(require('vue-resource'));
import PopupComponent from "./PopUpProfile.vue"


export default {
  components: {
    PopupComponent
  },
  data(){
    return{
      choice: 0
    }
  },
  methods : {
    popup: function(){
      if(this.choice == 0){
        this.choice = 1
      }else {
        this.choice = 0
      }
    }

}}

var handleError = function(error){
    console.log('Error! Could not reach the API. ' + error)
}

</script>

<style lang="less">
 @import "../definitions"; /* import common definitions */

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
