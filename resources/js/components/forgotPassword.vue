<template>
    <div class="flex justify-center pt-52">
        <div class="bg-white border w-1/4 shadow-lg ">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800">Forgot password?</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Remember your password?
                    <router-link to="/" class="">
                        Login here
                    </router-link>
                </p>
                </div>
                <div class="mt-5">
                    <Form  ref="formValidate" :model="formValidate" :rules="ruleValidate">
                        <FormItem label="E-mail" prop="email">
                            <Input v-model="formValidate.email" placeholder="Enter your e-mail"></Input>
                        </FormItem>
                        <div class="flex justify-end ">
                            <a-button  @click="handleSubmit('formValidate')" key="submit" type="primary" block >Reset Password</a-button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
        
        <loading v-model:active="isLoading"
                    :is-full-page="true"/>
    </div>
</template>

<script>
import { defineComponent, reactive, ref, toRefs } from 'vue';
import { notification } from 'ant-design-vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
export default defineComponent({
    components: {
        Loading
    },
    setup() {
        return{
            isLoading: ref(false),
        }
    },
    data() {
        return{
            formValidate: {
                email: ''
            },
            ruleValidate: {
                email: [
                    { required: true, message: 'Mailbox cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ]
            },
        }
    },
    methods: {
        async handleSubmit(name){
            let existingObj = this;
            await this.$refs[name].validate((valid) => {
                if (valid) {
                    existingObj.isLoading = true;
                    axios.post(`/api/forgotPassword`, this.formValidate)
                    .then(function (response) {
                        if(response.status == 200){
                            notification.success({
                                message: 'Notification',
                                description: 'Check Reset Link in your Email Account',
                            });
                        }
                        existingObj.isLoading = false;
                    })
                    .catch(function (error) {
                        console.log(error.response.data.errors.email[0]);
                        existingObj.isLoading = false;
                            notification.error({
                                message: 'Notification',
                                description: error.response.data.errors.email[0] + 'Try Refreshing the Page',
                            });
                    });
                } else {
                }
                
            })
        }
    }

});
</script>
