<template>
  <div id="content_profile" v-on:submit.prevent="edit_profile" v-if="user != null">
    <h1>Profil</h1>
    <form  id="profile-form">
    <input type="hidden" name="id" v-bind:value="user.id">
    <div id="cover">
      <div id="profile_picture">
        <img v-if="user.image != null" v-bind:src="user.image.path" v-bind:alt="user.nickname">
      </div>
      <div id="info_princ">
        <span class="name" id="nickname">{{user.nickname}}</span>
        <input id="edit_nickname" v-model="user.nickname" name="nickname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
        <div id="icon_contact">
          <input type="file" id="edit_profile_picture" name="image_file">
        </div>
      </div>
      <img src="../assets/edit.png" id="img_edit"  v-on:click="edit_details"/>
    </div>

      <div id="content_info">
        <div class="details">
          <h1>Details</h1>
          <ul>
            <li>
                <h2>Prénom</h2>
                <p>
                  <span  id="firstname">{{user.firstname}}</span>
                    <input id="edit_firstname" name="firstname" v-model="user.firstname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
                </p>
            </li>
            <li>
              <h2>Nom</h2>
              <p><span id="lastname">{{user.lastname}}</span>
                <input id="edit_lastname" name="lastname" v-model="user.lastname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              </p>
            </li>
            <li>
              <h2>Sexe</h2>
              <p><span id="sex">{{user.sex}}</span>
                <select name="sex" id="edit_sex">
                    <option value="m">M</option>
                    <option value="f">F</option>
                </select>
              </p>
            </li>

            <li>
              <h2>Date de naissance</h2>
              <p>
                <span id="date_birth">{{user.date_birth}}, {{user.age}} ans</span>
                <div id="edit_date_birth">
                  <select name="date_birth2[day]">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                      <option value="24">24</option>
                      <option value="25">25</option>
                      <option value="26">26</option>
                      <option value="27">27</option>
                      <option value="28">28</option>
                      <option value="29">29</option>
                      <option value="30">30</option>
                      <option value="31">31</option>
                  </select>
                  <select name="date_birth2[month]">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                  </select>
                  <select name="date_birth2[year]">
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                  </select>
                </div>
              </p>
            </li>
            <li>
              <h2>City</h2>
              <p><span id="city">{{user.city}}</span>
                <input id="edit_city" name="city" v-model="user.city" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              </p>
            </li>
        </ul>
        </div>
        <div class="desc">
          <h1>Description</h1>
          <p><span id="desc">{{user.description}}</span>
            <textarea id="edit_desc" name="description" v-model="user.description" ></textarea>
          </p>
        </div>
      </div>
      <button type="submit" class="button_style">VALIDER
        <img src="../assets/search_mob.png" class="img_button"/>
      </button>
    </form>
  </div>
  <div v-else>
    <p>Vous devez vous connecter...</p>
  </div>
</template>

<script>
import Vue from 'vue'

Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      user : null
    }
  },
  created : function(){
    this.$http.get('https://api.meowtic.com/user/whois')
      .then(function(response){
        let data = response.data;
        if(data.success){
          this.user = response.data.output;
        }
    })
  },
  methods : {
    edit_details : function(){
        document.getElementById("nickname").style.display="none";
        document.getElementById("edit_nickname").style.display = 'block';
        document.getElementById("firstname").style.display="none";
        document.getElementById("edit_firstname").style.display = 'block';
        document.getElementById("lastname").style.display="none";
        document.getElementById("edit_lastname").style.display = 'block';
        document.getElementById("date_birth").style.display="none";
        document.getElementById("edit_date_birth").style.display = 'block';
        document.getElementById("city").style.display="none";
        document.getElementById("edit_city").style.display = 'block';
        document.getElementById("sex").style.display="none";
        document.getElementById("edit_sex").style.display = 'block';
        document.getElementById("desc").style.display="none";
        document.getElementById("edit_desc").style.display = 'block';
        document.getElementById("edit_profile_picture").style.display = 'block';
    },
    edit_profile : function(){
      // on sérialise le formulaire (IMPORTANT de bien mettre les champs NAME en correspondance avec le nom des champs ATTENDUS côté serveur)
      let formData = new FormData(document.getElementById('profile-form'));

      this.$http.post('https://api.meowtic.com/user/edit', formData)
        .then(function(response){
          let data = response.data;
          if(data.success){
            console.log('Profile modifié');
            this.user = response.data.output;
            document.getElementById("nickname").style.display='block';
            document.getElementById("edit_nickname").style.display = "none";
            document.getElementById("firstname").style.display='block';
            document.getElementById("edit_firstname").style.display = "none";
            document.getElementById("lastname").style.display='block';
            document.getElementById("edit_lastname").style.display = "none";
            document.getElementById("date_birth").style.display='block';
            document.getElementById("edit_date_birth").style.display = "none";
            document.getElementById("city").style.display='block';
            document.getElementById("edit_city").style.display = "none";
            document.getElementById("sex").style.display='block';
            document.getElementById("edit_sex").style.display = "none";
            document.getElementById("desc").style.display="block";
            document.getElementById("edit_desc").style.display = 'none';
            document.getElementById("edit_profile_picture").style.display = "none";
          }
          else{
            alert(response.data.message);
          }
      })
    }
  }
}



</script>

<style lang="less">

 @import "../definitions";
@blue : #212D48;

#edit_nickname,#edit_firstname,#edit_lastname,#edit_date_birth,#edit_city,#edit_sex,#edit_profile_picture,#edit_desc{
  display: none;
}
img#img_edit{
  right:0;
  bottom:0;
  position: absolute;
  width:3em
}
#content_profile{
  margin:auto;
  margin-top: 100px;
  top:100px;
  width:800px;
  background-color:white;
}
#content_profile  h1{
  z-index:10;
  text-align:center;
  margin:auto;
  margin-top:-20px;
}
#cover{
  position:relative;
  width:100%;
  top:20px;
  height:300px;
  background-color:#9ca7be;
}
#profile_picture{
  background-color:#445680;
  width:170px;
  height:170px;
  position:absolute;
  z-index:2;
  left:20px;
  bottom:-30px;

  img{
    width:100%;
    height:100%;
  }
}
#info_princ{
  background-color:white;
  padding: 5px;
  width : 200px;
  position:absolute;
  z-index:2;
  left:190px;
  bottom: 0px;
}
#icon_contact{
  padding: 5px;
  width : 200px;
  position:absolute;
  z-index:2;
  bottom: -30px;
}
#icon_contact img{
  width:20px
}
#content_info{
  position:relative;
  display: inline-block;
  width:100%;
}
#content_info .details{
  float:left;
  background-color:#f6f6f7;
  width:40%;
  margin:5%;
  margin-top:10%;
  padding:2%;
  margin-right:1%;
}
#content_info .desc{
  float:left;
  background-color:#f6f6f7;
  width:40%;
  margin:5%;
  margin-top:10%;
  padding:2%;
  margin-left:1%;
}

#content_info h2{
    font-size:1.1em;
    text-align: left;
}

#content_info p{
  font-family: @fontText;
  color:gray;
  margin-top: -2%;
  margin-left: 1.5%;

}

.name{
  font-family: @fontTitle;
  text-transform:uppercase;
  font-weight: bold;
  color:@darkBlue;
  font-size:1.2em;
  padding-left: 3%;

}

@media screen and (max-device-width:810px), screen  and (max-width:810px){
  #content_profile{
    width:600px;
  }
}
@media screen and (max-device-width:620px), screen  and (max-width:620px){
  #content_profile{
    width:400px;
  }
}
</style>
