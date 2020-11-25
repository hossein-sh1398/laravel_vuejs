import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import UserList from './components/users'
import Home from './components/home'
import AboutMe from './components/about-me'
import Contact from './components/contact'
import Login from './components/auth/login'
import Register from './components/auth/register'
import UserPanel from './components/user-panel/panel'

function check_login(next)
{
    var expired_at = localStorage.getItem('expired_at');
    var current_time = new Date().getTime();
    current_time = Math.round(current_time / 1000);

    if (expired_at > current_time) {
        router.push('/user/panel');
    } else {
        next();
    }
}

function check_user(next)
{
    var expired_at = localStorage.getItem('expired_at');
    var current_time = new Date().getTime();
    current_time = Math.round(current_time / 1000);

    if (expired_at > current_time) {
        next();
    } else {
        router.push('/login');
    }
}
var routes = [
  		{
  			path: '/test/public',
  		 	component: Home
  		},
  		{
  			path: '/about',
  			component: AboutMe
  		},
  		{
  			path: '/contact',
  			component: Contact
  		},
  		{
  			path: '/users',
  			component: UserList
  		},
  		{
  			path: '/login',
  			component: Login,
            beforeEnter: function(to, from, next) {
                check_login(next);
            }
  		},
  		{
  			path: '/register',
  			component: Register
  		},
      {
        path: '/user/panel',
        component: UserPanel,
        beforeEnter: function(to, from, next) {
            check_user(next);
        }
      }

  ]

const router = new VueRouter({
  	mode: 'history',
  	base: process.env.BASE_URL,
  	routes
}) 

export default router