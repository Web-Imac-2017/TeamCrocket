<template>
  <div id="content_profile">
          <h1>Profil</h1>
          <div id="cover">


          </div>
          <div id="content_info">
            <div class="details">
              <div id="right">
                <h1>Details</h1>
                <ul>
                  <li>
                    <h2>Nom</h2>
                    <span>{{userForm.nickname}}</span>
                  </li>
                  <li>
                    <h2>Sexe</h2>
                    <span>{{userForm.sex}}</span>
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
          nickname:'',
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
      this.$http.get('https://api.meowtic.com/user/list_animal')
        .then(function(response){
          let data = response.data;
          this.user = response.data.output.data;
          if(data.success){
            int i=0;
            when(i<=response.data.output.item_total){
            this.userForm.nickname = this.user[i].name;
            this.userForm.sex = this.user[i].sex;
            this.userForm.like = this.user[i].like;
            this.userForm.dislike = this.user[i].dislike;
            this.userForm.city = this.user[i].city;
            this.userForm.date_birth = this.user[i].date_birth;
            this.userForm.age = this.user[i].age;
            this.caracForm.value = this.user[i].characteristics[i].value;
            i++;
          }
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
