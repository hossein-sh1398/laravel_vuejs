import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

const Store = new Vuex.Store({
	state: {
		is_login: false,
		name: '' 
	},
	getters: {
		get_login(state){
			return state.is_login
		},
		get_name(state){
			return state.name
		}
	},
	mutations: {
		set_login(state, bool) {
			state.is_login = bool
		},
		set_name(state, name) {
			state.name = name
		}
	},
	actions: {
		set_status_login({commit}, bool) {
			commit('set_login', bool);
		},
		set_user_name({commit}, user_name) {
			commit('set_name', user_name);
		}
	}
})

export default Store