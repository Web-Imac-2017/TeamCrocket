import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(require('vue-resource'));

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
    component: require('./components/Match.vue'),
    name: 'match'
  }, {
    path: '/loginuser',
    component: require('./components/LoginUser.vue'),
     name: 'loginuser'
   },{
    path: '/profileuser',
    component: require('./components/ProfileUser.vue'),
    name: 'profileuser'
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
