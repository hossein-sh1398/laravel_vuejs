<template>
   <div class="card">
     <div class="card-header">
       <div class="card-title">
            <span>فرم ورود به سایت</span>
       </div>
     </div>
       <div class="card-body">
          <form>
            <div class="form-group">
              <input type="text" v-model="form.email" placeholder="ایمیل خود را وارد نمایید" class="form-control">
            </div>
            <div class="form-group">
              <input type="text" v-model="form.password" placeholder="پسورد خود را وارد نمایید" class="form-control">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-block" @click.prevent="submit">ورود</button>
            </div>
          </form>
       </div>
   </div>
</template>
<script>
var app;
export default {
  name: 'Login',

  data: () => ({
    form: {
      email: null,
      password: null
    }
  }),
  mounted() {
    app = this;
  },
  methods: {
     submit() {
        axios.post('http://localhost/test/public/api/v1/login', this.form)
          .then((res) => {
            if (res.data.status == 'success') {
                console.log(res);
                localStorage.setItem('access_token', res.data.access_token);
                localStorage.setItem('expired_at', res.data.expired_at);
                localStorage.setItem('name', res.data.name);
                app.$store.dispatch('set_status_login', true);
                app.$store.dispatch('set_user_name', res.data.name);
                app.$router.push('/user/panel');
            } else { 
              
            }
              
          });
     }
  }
  // metaInfo() {
  //   return {
  //        title:  this.title,
  //         htmlAttrs: {
  //           foo: 'bar',
  //           lang: 'fa'
  //         },
  //          bodyAttrs: {
  //           bar: 'baz'
  //         },
  //         meta: [
  //           { charset: 'utf-8' },
  //           { name: 'viewport', content: 'width=device-width, initial-scale=1' },
  //           { vmid: 'keywords', name: 'keywords', content: this.keywords },
  //           { vmid: 'description', name: 'description', content: this.description }
  //         ]
  //   }
  // }
}
</script>

<style scoped>
  .content{
  }
  
</style>