import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(require('vue-resource'));

Vue.http.options.emulateJSON = true;

Vue.http.interceptors.push((request, next) => {
    request.credentials = true;
    next();
});

Vue.use(VueRouter)
const router = new VueRouter({
  mode: 'history',
  routes: [{
    path: '/',
    component: require('./components/Main.vue'),
    name: 'root'
  }, {
    path: '/match',
    component: require('./components/ChoiceMatch.vue'),
    name: 'choicematch'
  }, {
    path: '/match/:id',
    component: require('./components/Match.vue'),
    name: 'match'
  }, {
    path: '/loginuser',
    component: require('./components/LoginUser.vue'),
     name: 'loginuser'
   },{
     path: '/ProfileAnimal/:id',
     component: require('./components/ProfileAnimal.vue'),
     name: 'profileanimal'

   },{
    path: '/profileuser',
    component: require('./components/ProfileUser.vue'),
    name: 'profileuser'
  },{
    path: '/messenger',
    component: require('./components/Messenger.vue'),
    name: 'messenger'
  },{
    path: '/addpet',
    component: require('./components/AddPet.vue'),
    name: 'addpet'
  },{
    path: '/reset',
    component: require('./components/Reset.vue'),
    name: 'reset'
  },{
    path: '/forgottenpassword',
    component: require('./components/ForgottenPassword.vue'),
    name: 'forgottenpassword'
  },
  {
    path: '*',
    redirect: '/'
  }]
})
/*
import App from './App.vue'
*/
new Vue({
  el: '#app',
  router,
  render: h => h(require('./App.vue'))
})
