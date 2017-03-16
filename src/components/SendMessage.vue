<template>

	<div id="message-form">
		<h2>Entamez la discussion !</h2>    
    <form v-on:submit.prevent="sendmessage" id="message-form">
      <input type="hidden" name="formData.id" value="0">
      <input type="hidden" name="formData.group_id" value="1">
			
      <span><p style="white-space: pre">blbl {{formData.content}}</p>
			<br>
			<textarea v-model="formData.content" placeholder="add multiple lines"></textarea>
      <button type="submit">Valider</button>
			</span>
		</form>
	</div>

</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {
  //components: {
    //DateComponent
  //},

  

  name:"SendmessageComponent",

  data(){
    return{
      formData: {
        id: 0,
        content: '',
        group_id: 1 //remplacer par v-model="group_id" qd y aura le lien avec preview pour le group_id avec props
      }
      //msg: ''
	    /*id: 0,
	    txt: '',
		content: this.txt,
		group_id:1,

		message : {
            txt : '',
            date : ''
        }*/

    }
  },

created: function() {

},

methods: {


  	sendmessage: function(event) {
      //let formData = new FormData(document.getElementById('message-form'));

  		var that = this;
			var FRIEND_UID = 146;
			that.choice = 1;
			console.log(that.choice);
			that.$http.post('https://api.meowtic.com/messenger/edit/'+FRIEND_UID,that.formData)
				.then(function(response){
					let data = response.data;
					if(data.success){
						console.log(data);
						
					}
					else {
            alert(response.data.message);
					}
				}, handleError)

  	}

  }
 
}


 var handleError = function(error){
      console.log('Error! Could not reach the API. ' + error)
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