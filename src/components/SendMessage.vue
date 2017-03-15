<template>

	<div id="message-form">
		<h2>Entamez la discussion !</h2>
    	<form v-on:submit.prevent="sendmessage" id="send-message">
			<span><p style="white-space: pre"></p>
			<br>
			<textarea v-model="txt" placeholder="add multiple lines"></textarea>
			</span>
		</form>
		<button type="submit">Valider</button>
	</div>

</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

//import DateComponent from "./Date.vue"

export default {
  //components: {
    //DateComponent
  //},

  name:"SendmessageComponent",

  data(){
    return{
	    id: 0,
	    txt: '',
		//content: this.txt,
		group_id:1,

		message : {
            txt : '',
            date : ''
        }

    }
  },

created: function() {

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
    this.creator=this.user;
    this.is_author=this.user;

},

methods: {


  	sendmessage: function() {
  		var that = this;
  		var content = this.txt;
				var FRIEND_UID = 146;
				that.choice = 1;
				console.log(that.choice);
				that.$http.post('https://api.meowtic.com/messenger/edit/',0,content,1)
				.then(function(response){
					let data = response.data;
					console.log(data);
					if(data.success){
						console.log(data);
						console.log("success biatche");
						
					}
					else {
					}
				}, handleError)

  	}

  }


   /* created : function(){
      var get_id = this.$route.params.id;
      this.$http.get('https://api.meowtic.com/profile/get/'+ get_id )
        .then(function(response){
          let data = response.data;
          this.user = response.data.output;
          if(data.success){
            if(this.$parent.user.id ==this.user.creator_id){
                document.getElementById("img_edit").style.display="block";
            }
            this.userForm.name = this.user.name;
            this.userForm.sex = this.user.sex;
            this.userForm.like = this.user.like;
            this.userForm.dislike = this.user.dislike;
            this.userForm.city = this.user.city;
            this.userForm.date_birth = this.user.date_birth;

          }
        })
    },



    signup : function(){
      let formData = new FormData(document.getElementById('signup-form'));

      var that = this;
      that.$http.post('https://api.meowtic.com/user/edit', formData)
        .then(function(response){
          let data = response.data;
          if(data.success){
            that.user = response.data.output;
            //location.href = 'profileuser';
          }
          else{
            alert(response.data.message);
          }
      })
    }
  }*/
}



</script>


<style lang="less">
	@import "../definitions";

	#message-form{
		width:100%;
		background-color: white;
		margin-bottom:10px;
		margin-top:10px;
		border: 1px solid #DADADA;
	}


</style>