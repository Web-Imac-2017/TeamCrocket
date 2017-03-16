<template>
	<section id="frame" v-if="user != null">
		<div id="messenger-index">
			<img src="../assets/Meetic.png" id="logo" alt="Logo"/>
	      	<h1>Messagerie</h1>
	      			<!--
	      			<div id="button_form" >
	      				<br>
	      				<button v-on:click="newConv" class="button_form">Nouveau contact</button>
	      				<br><br>
	      			</div>
	      			-->
	      			<sendmessage-component></sendmessage-component>

					<previewmessage-component v-for="message in previewList" :message="message" v-on:click="loadPreview">
					</previewmessage-component>

	      	<!-- ça c'est ta liste, et tu itères dessus avec le v-for, mais maintenant faut pouvoir utiliser cl'info sur laquelle tu iteres, du coup tu pvas passer un prop, je récup la syntaxe j'arrive

	      	maintenant ton component a acces a la variable-->
	    </div>
	</section>
	<div v-else>
		<div class="no">
			<img class="non_connecter" src="../assets/non_connecter.png"/>
    </div>
	</div>
</template>




<script>
	import Vue from 'vue'
	Vue.use(require('vue-resource'));

	import PreviewmessageComponent from "./PreviewMessage.vue"
	import SendmessageComponent from "./SendMessage.vue"

	export default {

		components: {
			PreviewmessageComponent,
			SendmessageComponent
			//'ConversationComponent' : ConversationComponent

		},

		data() {
			return {
			user:null,
			choice: 0,
			previewList: [],
			message: {},

			prev: Object,
			prevId: Object,

			//message:Array

			}
		},

		created: function() {
			//this.loadPreview();
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
		},


		methods:{

			newConv: function(event){
				var that = this;
				var FRIEND_UID = 146;
				that.choice = 1;
				//console.log(that.choice);
				that.$http.post('https://api.meowtic.com/messenger/init/'+FRIEND_UID)
				.then(function(response){
					let data = response.data;
					console.log(data);
					if(data.success){
						console.log(data);
						that.prev=data;
						that.prevId=that.prev.id;
						console.log(that.prevId);

					}
					else {
					}
				}, handleError)
			},

			loadPreview : function() {
				var that = this;
				that.$http.post('https://api.meowtic.com/messenger/list')
				.then(function(response){
					let data = response.data;
					console.log(data);
					if(data.success){
						that.previewList = data['output'];
						//console.log("preview List");
						console.log(that.previewList);
					}
					else {
					}
				}, handleError)
			},

			loadConv: function(event) {

			}

		}

	}

		/*methods:{

			init : function(contactId) {
				this.$http.post('https://api.meowtic.com/messenger/init/'+contactId)
				.then(function(response){
					let data = response.data
					if(data.success){
						//afficher la conv complète
					}
					else {

					}
				},handleError)
			}

			loadListConv : function() {
				this.$http.post('https://api.meowtic.com/messenger/list',contactList)
			},

			loadConv : function(convId) {
				this.$http.post('https://api.meowtic.com/messenger/load')
			},

			sendMessage : function() {

			},

			loadLastMessage : function (contactId) {

			},


		}*/




	var handleError = function(error){
      console.log('Error! Could not reach the API. ' + error)
  	}



</script>


<style lang="less">
	@import "../definitions";

	#messenger-index #logo{
		display: block;
		margin: auto;
	 	width:250px;
	}

	#list-preview{
		width:80%;

	}

	#messenger-index {
	    display: block;
	    width:60%;
	    margin: auto;
	    padding:3.45%;
	    background:white;
	    text-align: center;

	    @media (max-width: 700px)
		{
		  flex-direction: column;
		  width: 100%;
		  img, div {
		  width: 100%;
		  margin:auto;
		  text-align:center;
	  	}
	}
  }



.button_form{
  border-radius: 4px;
  background-color:@lightBlue;
  font-size:0.9em;
  font-family: 'Moon';
  color:white;
  cursor:pointer;
  padding-right: 0.8em;
  padding-left: 0.8em;
  padding-top: 0.2em;
  padding-bottom: 0.2em;
  display: block;
  margin:auto;

}

</style>
