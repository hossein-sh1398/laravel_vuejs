<template>
    <div class="card">
     <div class="card-header">
       <div class="card-title">
            <span>فرم عضویت در سایت</span>
       </div>
     </div>
       <div class="card-body">             
          <form>
            <div class="form-group">
                {{form.name}}
              <input type="text" name="name" v-model="form.name" placeholder="نام خود را وارد نمایید" class="form-control">
                
            </div>
            <div class="form-group">
                {{form.email}}
              <input type="text" name="email" v-model="form.email" placeholder="ایمیل خود را وارد نمایید" class="form-control">
            </div>
            <div class="form-group">
                {{form.password}}
              <input type="text" name="password" v-model="form.password" placeholder="پسورد خود را وارد نمایید" class="form-control">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-block" @click.prevent="submit">عضویت</button>
            </div>
          </form>
       </div>
   </div>
</template>

<script>

var app;
export default {
    name: 'Register',

    data: () => ({
      form: {
        name: '',
        email: '',
        password: ''
      }
    }),
    mounted() {
        app = this;
    },
    methods: {
       submit() {
            var formdata = new FormData();
            formdata.append('name', this.form.name);
            formdata.append('email', this.form.email);
            formdata.append('password', this.form.password);
              axios.post('http://localhost/test/public/api/v1/register', formdata)
                .then((res) => {
                    alert('af');
                  if (res.data.status == 'success') {
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
    // metaInfo: {
    //   title:  'عضویت در سایت',
    //    link: [
    //     { rel: 'stylesheet', href: 'css/index.css'}
    //   ]
    // }
}
</script>

<style scoped>
	
</style>