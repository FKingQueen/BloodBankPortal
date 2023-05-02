<template>
  <div class="h-screen w-screen">
    <div class="text-center mt-40 ">
      <h1 class="text-2xl font-bold">NEGROS ORIENTAL PROVINCIAL HOSPITAL BLOOD BANK</h1>
      <h1 class="text-2xl font-bold">PORTAL</h1>
    </div>
    <div class="flex justify-center  items-center">
        <div class="w-full flex flex-col items-center">
            <div class="md:w-1/4 w-11/12 px-2 pt-5 shadow">
                <div>
                    <h1 class="text-center text-base text-gray-600 mb-6">Login</h1>
                </div>
                <a-form
                    :model="this.formState"
                    name="normal_login"
                    v-bind="layout"
                    class="login-form"
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

                    <a-form-item >
                        <div class="flex justify-between" >
                            <!-- <a class="login-form-forgot" href="">Forgot password</a> -->
                            <router-link to="/register" class="">
                              Register
                            </router-link>
                            <a-button  :disabled="disabled"  type="primary" html-type="submit" class="login-form-button">
                                Login
                            </a-button>
                        </div>
                    </a-form-item>
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
                }
                window.Laravel.isLoggedin = true
                if(response.data.userType == 'Admin'){
                  this.$router.push({path: '/admin/userApprovalPlatform'})
                }else if(response.data.userType == 'User'){
                  this.$router.push({path: '/portal/home'})
                }
                
            })
            .catch(function (error) {
                console.error(error);
            });   
        })
    }
  },
  async created(){
    if(window.Laravel.isLoggedin){
      this.$router.go(-1)
    }
  }
});
</script>
