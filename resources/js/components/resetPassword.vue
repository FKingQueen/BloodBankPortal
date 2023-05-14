<template>
    <div class="flex justify-center pt-52">
        <div class="bg-white border w-1/4 shadow-lg ">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                    <h1 class="block text-2xl font-bold text-gray-800">Reset Password</h1>
                </div>
                <div class="mt-5">
                    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate">
                        <FormItem label="E-mail" prop="email">
                            <Input v-model="formValidate.email" placeholder="Enter your e-mail"></Input>
                        </FormItem>
                        <FormItem label="Password" prop="passwd">
                            <Input type="password" placeholder="Password" v-model="formValidate.password"></Input>
                        </FormItem>
                        <FormItem label="Confirm" prop="passwdCheck">
                            <Input type="password" placeholder="Confirm-Password" v-model="formValidate.passwdCheck"></Input>
                        </FormItem>
                        <div class="flex justify-end ">
                            <a-button  @click="handleSubmit('formValidate')" key="submit" type="primary" block >Reset Password</a-button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useRoute } from 'vue-router'
import { notification } from 'ant-design-vue';

export default defineComponent({
    setup(){
        const route = useRoute();
        const form = ref({
            email: route.query.email,
            token: route.params.token,
        })
        return{
            form
        }
    },
    data() {
        const validatePass = (rule, value, callback) => {
          if (value === '') {
              callback(new Error('Please enter your password'));
          } else {
              if (this.formValidate.passwdCheck !== '') {
                  this.$refs.formValidate.validateField('passwdCheck');
              }
              callback();
          }
        };
        const validatePassCheck = (rule, value, callback) => {
          if (value === '') {
              callback(new Error('Please enter your password again'));
          } else if (value !== this.formValidate.password) {
              callback(new Error('The two input passwords do not match!'));
          } else {
              callback();
          }
        };
        return{
            formValidate: {
                email: '',
                token: '',
                password: '',
                passwdCheck: ''
            },
            ruleValidate: {
                email: [
                    { required: true, message: 'Mailbox cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ],
                password: [
                    { validator: validatePass, trigger: 'blur' }
                ],
                passwdCheck: [
                    { validator: validatePassCheck, trigger: 'blur' }
                ]
            },
        }
    },
    methods: {
        async handleSubmit (name) {
            let existingObj = this;
            await this.$refs[name].validate((valid) => {
                if (valid) {
                    existingObj.formValidate.token = existingObj.form.token
                    if(existingObj.form.email == existingObj.formValidate.email){
                            axios.post(`/api/reset`, existingObj.formValidate)
                            .then(function (response) {
                                notification.success({
                                    message: 'Notification',
                                    description: 'You Successfully Changed your Password, try logging in',
                                });
                                console.log("response:", response.data);
                                existingObj.$router.push('/');
                            })
                            .catch(function (error) {
                                notification.error({
                                    message: 'Notification',
                                    description: 'This Link is Not Available Anymore',
                                });
                                console.log("response:", response.data);
                            });
                    } else if(existingObj.form.email != existingObj.formValidate.email){
                        notification.error({
                            message: 'Notification',
                            description: 'Your is email is Invalid',
                        });
                    }
                } else{
 
                }
                
            })
            
        },
    },
    created(){
        let existingObj = this;
        console.log("Email:", existingObj.form);
        // console.log("Token:", existingObj.token);
    }

});
</script>
