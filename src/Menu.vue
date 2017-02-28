<template>
  <header>
    <div class="part_left">
      <img src="./assets/logo_simple.png" alt="Logo" class="logo">
      <div id="research">
        <input type="search" placeholder="Entrez un mot-clef" name="the_search">
        <button id="button_research">
          <img src="./assets/search.png" alt="research">
        </button>
      </div>
    </div>
    <div class="part_right">
      <ul>
        <li><img src="./assets/home.png" alt="home"></li>
        <li><img src="./assets/message.png" alt="message"></li>
        <li><img src="./assets/profile.png" alt="profile"></li>
      </ul>
    </div>
  </header>
</template>

<script>


</script>

<style lang="less">
@blue : #212D48;

header{
  position:fixed;
  display:inline-block;
  width:90%;
  padding-left:5%;
  padding-right:5%;
  top:0;
  left:0;
  background-color:@blue;
}
.part_left{
  float:left;
  width:60%;
}
header .logo{
  float:left;
  vertical-align:middle;
  margin-top:1em;
  width:20%;
}
#research{
  float:left;
  margin-top:1em;
  margin-left:20px;
  width:70%;
}
#research input{
  height:25px;
  width:70%;
}
#button_research{
  background-color:@blue;
  width:30px;
  border:none;
  vertical-align:middle;
}
#button_research img{
  width: 100%;
}
.part_right{
  width:40%;
  float:right;
}
header ul{
  float:right;
  padding:0;
}
header ul li img{
  height:25px;
}
@media screen and (max-device-width:450px), screen  and (max-width:450px){

}
</style>
