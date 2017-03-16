<template>
	<section id="frame">
		<div id="messenger-index">
			<img src="../assets/Meetic.png" id="logo" alt="Logo"/>
	      	<h1>Messagerie</h1>

	      			<button v-on:click="newConv">Parle à Mélo !</button>
	      			<sendmessage-component v-if="choice == 1"></sendmessage-component>

					<previewmessage-component v-for="message in previewList" :message="message" v-on:click="loadPreview">
					</previewmessage-component>

	      	<!-- ça c'est ta liste, et tu itères dessus avec le v-for, mais maintenant faut pouvoir utiliser cl'info sur laquelle tu iteres, du coup tu pvas passer un prop, je récup la syntaxe j'arrive

	      	maintenant ton component a acces a la variable-->
	    </div>

		</div>
	</section>
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

				/*contactList:[{
					author: 'lol',
					date: 'jklk',
					text: 'klmj'
				},
				{
					author: 'lol',
					date: 'jklk',
					text: 'klmj'
				}]
			}*/
			//user:null,
			choice: 0,
			//prev: Object,
			//prevId: Object,

			previewList: []
			
			}

		

		},

		created: function() {
			this.loadPreview();
		},


		methods:{

			newConv: function(event){
				var that = this;
				var FRIEND_UID = 146;
				that.choice = 1;
				console.log(that.choice);
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
				console.log("fuck it");
				var that = this;
				that.$http.post('https://api.meowtic.com/messenger/list')
				.then(function(response){
					let data = response.data;
					console.log("blblblbl");
					console.log(data);
					if(data.success){
						that.previewList = data;
						console.log("preview List");
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
	 	width:110px;
	}

	#list-preview{
		width:80%;

	}


</style>
