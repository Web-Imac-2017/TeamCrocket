<template>
	<section id="frame">
		<div id="messenger-index">
			<img src="../assets/Meetic.png" id="logo" alt="Logo"/>
	      	<h1>Friend's Name</h1>					
					
					<previewmessage-component v-for="message in fullConv" :message="message"></previewmessage-component>

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

	export default {

		components: {
			'PreviewmessageComponent' : PreviewmessageComponent
		},

		data() {
			return {

				user: null,

				/*fullConv:[{
					author: 'lol',
					date: 'jklk',
					text: 'klmj'
				},
				{
					author: 'lol',
					date: 'jklk',
					text: 'klmj'
				}]*/
			}
			//contactList: []
			//fullConv = fetch(0)
		},

		/*created: function() {
			var that = this;
			that.loadConv(0);
		 },*/


		methods:{
			loadConv: function(event) {
				var _this = this;
				this.$http.post('https://api.meowtic.com/messenger/fetch')
				.then(function(response){
					let data = response.data;
					console.log(data);
					if(data.success){
						_this.previewList = data;
					}
					else {
					}
				}, handleError)
			},
			},

			addMessage: function(event) {

			},

			updateConv: function(event) {

			},


		},

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


		}



		}*/

	}

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
