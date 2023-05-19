<template>
    <div class="w-full h-screen">
        <div class="text-center mt-10 ">
            <h1 class="text-2xl font-bold">NEGROS ORIENTAL PROVINCIAL HOSPITAL BLOOD BANK</h1>
            <h1 class="text-2xl font-bold">PORTAL</h1>
        </div>
        <div class=" w-full flex justify-center">
            <div class="m-5 bg-white shadow-inner shadow-lg rounded px-10 w-2/5 py-5">
                <h1 class="text-xl mb-3">Registration Form</h1>
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate">
                    <FormItem label="First Name" prop="firstName">
                        <Input v-model="formValidate.firstName" placeholder="Enter your First Name"></Input>
                    </FormItem>
                    <FormItem label="Last Name" prop="lastName">
                        <Input v-model="formValidate.lastName" placeholder="Enter your Last Name"></Input>
                    </FormItem>
                    <FormItem label="Middle Initial" prop="middleInitial">
                        <Input v-model="formValidate.middleInitial" placeholder="Enter your Middle Initial"></Input>
                    </FormItem>

                    <FormItem label="Middle Initial" prop="Age">
                        <a-date-picker v-model="formValidate.birthDate"  />
                        <DatePicker type="date" placeholder="Select date" style="width: 200px" />
                    </FormItem>

                    <FormItem label="Town/City" prop="address">
                        <Select v-model="formValidate.address" placeholder="Select your Town/City">
                            <Option value="Amlan">Amlan</Option>
                            <Option value="Ayungon">Ayungon</Option>
                            <Option value="Bacong">Bacong</Option>
                            <Option value="Bais">Bais</Option>
                            <Option value="Basay">Basay</Option>
                            <Option value="Bayawan">Bayawan</Option>
                            <Option value="Bindoy">Bindoy</Option>
                            <Option value="Canlaon">Canlaon</Option>
                            <Option value="Dauin">Dauin</Option>
                            <Option value="Dumaguete">Dumaguete</Option>
                            <Option value="Guihulngan">Guihulngan</Option>
                            <Option value="Jimalalud-">Jimalalud</Option>
                            <Option value="La Libertad">La Libertad</Option>
                            <Option value="Mabinay">Mabinay</Option>
                            <Option value="Manjuyod">Manjuyod</Option>
                            <Option value="Pamplona">Pamplona</Option>
                            <Option value="Santa Catalina">Santa Catalina</Option>
                            <Option value="Siaton">Siaton</Option>
                            <Option value="Sibulan">Sibulan</Option>
                            <Option value="Tanjay">Tanjay</Option>
                            <Option value="Tayasan">Tayasan</Option>
                            <Option value="Valencia">Valencia</Option>
                            <Option value="Vallehermoso">Vallehermoso</Option>
                            <Option value="Zamboanguita">Zamboanguita</Option>
                        </Select>
                    </FormItem>
                    
                    <FormItem label="E-mail" prop="email">
                        <Input v-model="formValidate.email" placeholder="Enter your e-mail"></Input>
                    </FormItem>
                    <FormItem label="Age" prop="age" v-bind="config">
                        <Input v-model="formValidate.age" placeholder="Enter your Age"></Input>
                    </FormItem>
                    <FormItem label="Phone Number" prop="phoneNumber">
                        <Input v-model="formValidate.phoneNumber" placeholder="Enter your Phone Number"></Input>
                    </FormItem>
                    <FormItem label="Gender" prop="gender">
                        <Select v-model="formValidate.gender" placeholder="Select your Gender">
                            <Option value="Male">Male</Option>
                            <Option value="Female">Female</Option>
                        </Select>
                    </FormItem>
                    <Form inline>

                    </Form>
                    <FormItem label="Identifictaion Picture" prop="idPic">
                        <Upload
                            ref="uploads"
                            :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg','jpeg','png']"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            action="/api/uploadid">
                            <Button icon="ios-cloud-upload-outline">Upload files</Button>
                        </Upload>
                        <div v-if="formValidate.idPic" class="demo-upload-list">
                            <Image :src="`/id/${formValidate.idPic}`" fit="cover" width="100%" height="100%" />
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-eye-outline" @click="handleView(item.name)"></Icon>
                                <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                            </div>
                        </div>
                    </FormItem>
                    <FormItem label="Blood Type" prop="bloodType">
                        <Select v-model="formValidate.bloodType" placeholder="Select your Gender">
                            <Option value="A+">A+</Option>
                            <Option value="A-">A-</Option>
                            <Option value="B+">B+</Option>
                            <Option value="B-">B-</Option>
                            <Option value="O+">O+</Option>
                            <Option value="O-">O-</Option>
                            <Option value="AB+">AB+</Option>
                            <Option value="AB-">AB-</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="Password" prop="passwd">
                        <Input type="password" placeholder="Password" v-model="formValidate.passwd"></Input>
                    </FormItem>
                    <FormItem label="Confirm" prop="passwdCheck">
                        <Input type="password" placeholder="Confirm-Password" v-model="formValidate.passwdCheck"></Input>
                    </FormItem>
                    <div class="flex justify-between">
                        <router-link to="/" class="">
                            Login
                        </router-link>
                        <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Register</a-button>
                    </div>
                </Form>
                
            </div>
        </div>
    </div>
  </template>
  
  <script>
  import { UploadOutlined } from '@ant-design/icons-vue';
  import { defineComponent, ref, onMounted } from 'vue';
  import { notification } from 'ant-design-vue';
  import { useRoute, useRouter} from 'vue-router'; 
  export default defineComponent({
    data(){
        
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
          } else if (value !== this.formValidate.passwd) {
              callback(new Error('The two input passwords do not match!'));
          } else {
              callback();
          }
        };

        return{
            formValidate: {
                firstName: '',
                lastName: '',
                middleInitial: '',
                email: '',
                age: '',
                birthDate: '',
                address: '',
                phoneNumber: '',
                gender: '',
                idPic: '',
                bloodType: '',
                passwd: '',
                passwdCheck: ''
            },
            ruleValidate: {
                firstName: [
                    { required: true, message: 'The Full Name cannot be empty', trigger: 'blur' }
                ],
                lastName: [
                    { required: true, message: 'The Last Name cannot be empty', trigger: 'blur' }
                ],
                middleInitial: [
                    { required: true, message: 'The Middle Initial cannot be empty', trigger: 'blur' },
                    { type: 'string', max: 1, message: 'Initial Only', trigger: 'blur' }
                ],
                birthDate: [
                    { required: true, message: 'The Birth Date cannot be empty', trigger: 'blur' }
                ],
                phoneNumber: [
                    { required: true, message: 'The Phone Number cannot be empty', trigger: 'blur' },
                    { type: 'string', max: 11, min: 11, message: '11 digits is required', trigger: 'blur' }
                ],
                age: [
                    { required: true, message: 'The Age cannot be empty', trigger: 'blur' }
                ],
                gender: [
                    { required: true, message: 'The Gender cannot be empty', trigger: 'blur' }
                ],
                bloodType: [
                    { required: true, message: 'The Blood Type cannot be empty', trigger: 'blur' }
                ],
                idPic: [
                    { required: true, message: 'The Identication Picture cannot be empty', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: 'Mailbox cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ],
                passwd: [
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
            console.log(existingObj.formValidate);
            await this.$refs[name].validate((valid) => {
                if (valid) {
                    const res = axios.post(`/api/register`, this.formValidate)
                    .then(function (response) {
                        notification.success({
                            message: 'Notification',
                            description: 'You are Successfully Register, Kindly wait for the approval of the admin, You can check the approval notice through your email. Thankyou',
                        });
                        existingObj.$router.push('/');
                    })
                    .catch(function (error) {
                        if (error.response.data.errors.email) {
                            console.log(error.response.data.errors);
                            notification.error({
                                message: 'Notification',
                                description: error.response.data.errors.email,
                            });
                        }
                    });
                } else {
                }
                
            })
            
        },
        async deleteImage(){
            let idPic = this.formValidate.idPic
            this.formValidate.idPic = ''
            this.$refs.uploads.clearFiles()
            await axios.get('/sanctum/csrf-cookie').then(response => {
                response
                axios.post(`/api/deleteImageReg`, {imageName: idPic})
                    .then(function (response) {
                    

                    })
                    .catch(function (error) {
                    if(error){
                        this.formValidate.idPic = idPic
                    }
                });    
            })   
        },
        handleSuccess (res, file) {
            this.formValidate.idPic = res
        },
        handleError (res, file) {
            console.log('res', res);
        },
        handleFormatError (file) {
            notification.warning({
                message: 'The file format is incorrect',
                description: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            notification.warning({
                message: 'Exceeding file size limit',
                description: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
    },
    async created(){
        this.token = window.Laravel.csrfToken;
        if(window.Laravel.isLoggedin){
            this.$router.go(-1)
        }
    }
  })
  </script>
  
  <style>
      .demo-upload-list{
          display: inline-block;
          width: 60px;
          height: 60px;
          text-align: center;
          line-height: 60px;
          border: 1px solid transparent;
          border-radius: 4px;
          overflow: hidden;
          background: #fff;
          position: relative;
          box-shadow: 0 1px 1px rgba(0,0,0,.2);
          margin-right: 4px;
      }
      .demo-upload-list img{
          width: 100%;
          height: 100%;
      }
      .demo-upload-list-cover{
          display: none;
          position: absolute;
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
          background: rgba(0,0,0,.6);
      }
      .demo-upload-list:hover .demo-upload-list-cover{
          display: block;
      }
      .demo-upload-list-cover i{
          color: #fff;
          font-size: 20px;
          cursor: pointer;
          margin: 0 2px;
      }
  </style>