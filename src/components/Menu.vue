<template>
  <header>
    <div class="part_left">
      <img src="../assets/logo_simple.png" alt="Logo" class="logo">
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
        <li><router-link :to="{name: 'match'}"><img src="../assets/home.png" alt="home"></router-link></li>
        <li class="mob separate"><img src="../assets/separate.jpg"></li>
        <li class="mob"><img src="../assets/search_mob.png" alt="search"></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li><img src="../assets/message.png" alt="message"></li>
        <li class="separate"><img src="../assets/separate.jpg"></li>
        <li><img src="../assets/profile.png" alt="profile"></li>
      </ul>
    </div>
  </header>
</template>

<script>


</script>

<style lang="less">
 @import "../definitions";

header{
  position:fixed;
  display:inline-block;
  width:90%;
  padding-left:5%;
  padding-right:5%;
  top:0;
  left:0;
  background-color:@darkBlue;
  z-index:99;
}
.part_left{
  float:left;
  width:70%;
}
header .logo{
  float:left;
  vertical-align:middle;
  margin-top:7px;
  width:150px;
  display:block;
}
header .logo_mob{
  display:none;
}
#research{
  float:left;
  margin-top:10px;
  margin-left:20px;
  width:70%;
}
#research input{
  height:25px;
  border-radius:5px;
  width:50%;
  min-width:300px;
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
  width:30%;
  float:right;
}
header ul{
  float:right;
  padding:0;
  margin:10px;
}
header ul li img{
  height:25px;
}
li {
  display: inline-block;
  margin: 0 10px;
}
.separate{
  height:100%
}
li.mob{
  display:none;
}
@media screen and (max-device-width:920px), screen  and (max-width:920px){
    #research{
      width:60%;
    }
    #research input{
      min-width:250px;
    }
}


@media screen and (max-device-width:800px), screen  and (max-width:800px){
  .part_left{
    width:60%;
    }
  .part_right{
    width:40%;
  }
  header .logo{
    display:none;
  }
  #research{
    width:auto;
  }
  header .logo_mob{
    float:left;
    vertical-align:middle;
    margin-top:7px;
    display:block;
    width:35px;
  }
}

@media screen and (max-device-width:640px), screen  and (max-width:640px){
  #research input{
    min-width:200px;
  }
}
@media screen and (max-device-width:610px), screen  and (max-width:610px){
  header ul{
    width:100%;
    margin:0;
    margin-top:10px;
    margin-bottom:10px
  }
  header ul li{
    width:22%;
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
