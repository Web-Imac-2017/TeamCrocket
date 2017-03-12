<template>
  <div id="content_profile">
          <h1>Profil</h1>
          <form  id="profile-form">
          <div id="cover">
            <div id="profile_picture">
              <img v-if="user.image != null" v-bind:src="user.image.path" v-bind:alt="user.nickname">
            </div>
            <img src="../assets/edit.png" id="img_edit"  v-on:click="edit_details"/>
            <div id="info_princ">
              <span class="name" id="name">{{userForm.name}}</span>
              <input id="edit_name" v-model="userFort.name" name="name" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              <div id="icon_contact">
                <input type="file" id="edit_profile_picture" name="image_file">
              </div>
            </div>
          </div>
          <div id="content_info">
            <div class="details">
              <div id="right">
                <h1>Details</h1>
                <ul>
                  <li>
                    <h2>Sexe</h2>
                    <p><span id="sex">{{userForm.sex}}</span>
                      <select name="sex" id="edit_sex">
                          <option value="m">M</option>
                          <option value="f">F</option>
                      </select>
                    </p>
                  </li>
                  <li>
                    <h2>City</h2>
                    <span>{{userForm.city}}</span>
                  </li>
                </ul>
              </div>
              <div id="left">
                <ul>
                  <li>
                    <h2>Age</h2>
                    <span>{{userForm.age}} ans</span>
                  </li>
                  <li>
                    <h2>Naissance</h2>
                    <span>{{userForm.date_birth}}</span>
                  </li>
                </ul>
              </div>


            </div>
            <div class="desc">
              <h1>Description</h1>
              <ul>
                <li>
                  <h2>Ce qu'il Aime</h2>
                  <span id="detail_lastname">{{userForm.like}}</span>
                </li>
                <li>
                  <h2>Ce qu'il Aime</h2>
                  <span id="detail_lastname">{{userForm.dislike}}</span>
                </li>
                <li>
                  <h2>Caracteres</h2>
                  <span>{{caracForm.value}}</span>
                </li>
                <li>
                  <h2>Nourriture preferee</h2>
                  <span>{{caracForm.value}}</span>
                </li>
              </ul>
            </div>
          </div>
        </form>
  </div>
</template>

<script>

import Vue from 'vue'

Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      user : null,
      userForm : {
          name:'',
          sex:'',
          like:'',
          dislike:'',
          city: '',
          date_birth: '',
          age: '',


      },

      caracForm : {
        value:''
      }

    }
  },

    created : function(){
      var get_id = sessionStorage.getItem("id_animal");
      this.$http.get('https://api.meowtic.com/profile/get/'+ get_id )
        .then(function(response){
          let data = response.data;
          this.user = response.data.output;
          if(data.success){
            if(this.$parent.user.id ==this.user.creator_id){

            }

            this.userForm.name = this.user.name;
            this.userForm.sex = this.user.sex;
            this.userForm.like = this.user.like;
            this.userForm.dislike = this.user.dislike;
            this.userForm.city = this.user.city;
            this.userForm.date_birth = this.user.date_birth;

          }
        })
    }

}


</script>

<style lang="less">
@import "../definitions"; /* import common definitions */

#content_info .details h1{
  margin-top:0.2em;
}
#content_info .desc h1{
  margin-top:0.2em;
}
#content_info .details ul li h2{
  margin-top:3em;
}
#content_info .desc ul li h2{
  margin-top:3em;
}

#content_info .desc h3{
  margin-top:2em;
}

#content_info span{

}

#right{
  float:left;
}

#left{
  float:right;
}
</style>
