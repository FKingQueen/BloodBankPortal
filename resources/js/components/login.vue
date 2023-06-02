<template class="">
  <div class="h-screen bgImage">
    <div class="flex justify-center items-center pt-16">
      <img src="/img/logo1.png" alt="" style="width: 15%; aspect-ratio: 3/2; object-fit: contain;" class="border">
      <img src="/img/logo2.png" alt="" style="width: 15%; aspect-ratio: 3/2; object-fit: contain;" class="border">
      <img src="/img/logo3.png" alt="" style="width: 15%; aspect-ratio: 3/2; object-fit: contain;" class="border">
    </div>
    <div class="text-center">
      <h1 class="text-2xl font-bold text-white ">Welcome to Negros Oriental Provincial Hospital Blood Bank</h1>
    </div>

    <div class="flex justify-center pt-10">
        <div class="w-full flex flex-col items-center ">
            <div class="md:w-1/4 w-11/12 px-2 pt-5 shadow-lg border bg-white">
                <div>
                    <h1 class="text-center text-base text-gray-600 mb-6">Login</h1>
                </div>
                <a-form
                    :model="this.formState"
                    name="normal_login"
                    v-bind="layout"
                    class="login-form "
                    @finish="login"
                    @finishFailed="onFinishFailed"
                    :validate-messages="validateMessages"
                >
                    <a-form-item
                    label="Email"
                    name="email"
                    :rules="[{ type: 'email' }]"
                    >
                    <a-input v-model:value="this.formState.email">
                        <template #prefix>
                        <UserOutlined class="site-form-item-icon" />
                        </template>
                    </a-input>
                    </a-form-item>

                    <a-form-item
                    label="Password"
                    name="password"
                    :rules="[{ type: 'string', min: 8}]"
                    >
                    <a-input-password v-model:value="this.formState.password">
                        <template #prefix>
                        <LockOutlined class="site-form-item-icon" />
                        </template>
                        </a-input-password>
                    </a-form-item>

                      <div class="justify-end flex">
                        <a-button  :disabled="disabled"  type="primary" html-type="submit" class="login-form-button">
                          Login
                        </a-button>
                      </div>

                    <div class="flex justify-center" >
                      <router-link to="/forgotPassword">
                        Forgot Password?
                      </router-link>
                    </div>
                    <div class="flex justify-center space-x-2" >
                        <p>No account?</p>
                        <router-link to="/register">
                          RegisterHere
                        </router-link>
                    </div>
                </a-form>

            </div>
        </div>
    </div>
  </div>
</template>
<script>
import { defineComponent, reactive, computed } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
import { nextTick } from 'process';
export default defineComponent({
  components: {
    UserOutlined,
    LockOutlined,
  },
  data () {
    const layout = {
      labelCol: {
        span: 5,
      }
    };
    const disabled = computed(() => {
      return !(this.formState.email && this.formState.password);
    });
    const validateMessages = {
      required: '${label} is required!',
      types: {
        email: '${label} is not a valid email!',
      },
      string: {
        range: '${label} must be between ${min} characters',
      },
    };
    return {
        isLoggedIn : false,
        formState : {
            email: '',
            password: ''
        },
        validateMessages,
        layout,
        disabled,
        prevRoute: null
    }
  },
  methods : {
    async login(){
        let existingObj = this;
        await axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('api/login', this.formState)
            .then(response => {
                console.log(response.data);
                if(response.data.auth == "success"){
                notification.success({
                    message: 'Notification',
                    description: 'You are Logged In',
                });
                } else if(response.data.auth == "failed") {
                    notification.error({
                        message: 'Notification',
                        description: 'Incorrect Login Details',
                    });
                    return;
                } else if(response.data == "approval"){
                    notification.info({
                        message: 'Notification',
                        description: 'Wait for the approval of the Admin, You can check the approval notice through your email. Thankyou',
                    });
                }
                window.Laravel.isLoggedin = true

                if(response.data.userType == 'Admin'){
                  this.$router.push({path: '/admin/potentialDonors'})
                }else if(response.data.userType == 'User'){
                  this.$router.push({path: '/home'})
                }
                
            })
            .catch(function (error) {
                console.error(error);
            });   
        })
    }
  },
  async created(){
    console.log(window.Laravel);
    if(window.Laravel.isLoggedin){
      this.$router.go(-1)
    }
  }
});
</script>

<style scoped>
.bgImage {
    background-image: url('/img/background.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    color: #FFFFFF;
}
</style>
