<template>
    <div class="p-2">

        <div class="m-5 bg-white shadow-inner shadow-lg rounded px-20 py-5">
            <Breadcrumb separator=">">
                <BreadcrumbItem to="/admin/userPlatform">User Management</BreadcrumbItem>
                <BreadcrumbItem>Edit User Form</BreadcrumbItem>
            </Breadcrumb>
            <a-button @click="this.$router.push('/admin/userPlatform')" class="my-3">Back</a-button>
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="95" class="px-10" >
                <FormItem label="User Type" prop="userType">
                    <Select v-model="formValidate.userType" placeholder="Select your User Type">
                        <Option value="Admin">Admin</Option>
                        <Option value="User">User</Option>
                    </Select>
                </FormItem>
                <FormItem label="First Name" prop="firstName">
                    <Input v-model="formValidate.firstName" placeholder="Enter your firstName"></Input>
                </FormItem>
                <FormItem label="Last Name" prop="lastName">
                    <Input v-model="formValidate.lastName" placeholder="Enter your lastName"></Input>
                </FormItem>
                <FormItem label="Middle Initial" prop="middleInitial">
                    <Input v-model="formValidate.middleInitial" placeholder="Enter your middleInitial"></Input>
                </FormItem>
                <FormItem label="E-mail" prop="email">
                    <Input v-model="formValidate.email" placeholder="Enter your e-mail"></Input>
                </FormItem>
                <FormItem label="Age" prop="age">
                    <Input v-model="formValidate.age" placeholder="Enter your Age"></Input>
                </FormItem>
                <FormItem label="Address" prop="address">
                    <Select v-model="formValidate.address" placeholder="Select your Municipality/City">
                        <Option value="Amlan">Amlan</Option>
                        <Option value="Ayungon">Ayungon</Option>
                        <Option value="Bacong">Bacong</Option>
                        <Option value="Bais">Bais</Option>
                        <Option value="Bais">Bais</Option>
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
                        <Option value="Valencia">Valencia (Luzurriaga)</Option>
                        <Option value="Vallehermoso">Vallehermoso</Option>
                        <Option value="Zamboanguita">Zamboanguita</Option>
                    </Select>
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

                <FormItem >
                    <a-button type="primary" @click="showModal">Change Password</a-button>
                    <a-modal v-model:visible="visible" title="Updating Password" @ok="changePassword('formValidate')">
                        <div class="ivu-form ivu-form-label-right">
                            <FormItem label="Password" prop="passwd">
                                <Input type="password" v-model="formValidate.passwd"></Input>
                            </FormItem>
                            <FormItem label="Confirm" prop="passwdCheck">
                                <Input type="password" v-model="formValidate.passwdCheck"></Input>
                            </FormItem>
                        </div>
                </a-modal>
                </FormItem>

                <div class="flex justify-end">
                    <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Submit</a-button>
                </div>
            </Form>
        </div>
    </div>
  </template>
  
  <script>
  import { UploadOutlined } from '@ant-design/icons-vue';
  import { defineComponent, ref } from 'vue';
  import { notification } from 'ant-design-vue';
  import { useRoute, useRouter} from 'vue-router';
  export default defineComponent({
    data(){
        const visible = ref(false);

        const showModal = () => {
        visible.value = true;
        };
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
            visible,
            showModal,
            formValidate: {
                id: '',
                firstName: '',
                lastName: '',
                middleInitial: '',
                email: '',
                userType: '',
                age: '',
                address: '',
                phoneNumber: '',
                gender: '',
                idPic: '',
                bloodType: '',
                passwd: '',
                passwdCheck: ''
            },
            ruleValidate: {
                userType: [
                    { required: true, message: 'Please select the userType', trigger: 'change' }
                ],
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
            this.$refs[name].validate((valid) => {
                if (valid) {
                    // Post
                    axios.post(`/api/admin/updateUser`, this.formValidate)
                    .then(function (response) {
                        notification.success({
                            message: 'Notification',
                            description: 'Users Info is Successfully Updated',
                        });
                        existingObj.$router.push('/admin/userPlatform');
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
        changePassword(name)
        {
            let existingObj = this;
            this.$refs[name].validate((valid) => {
                if (valid) {
                    // Post
                    axios.post(`/api/admin/updatePassword`, this.formValidate)
                    .then(function (response) {
                        notification.success({
                            message: 'Notification',
                            description: 'Users Password is Successfully Updated',
                        });
                        existingObj.visible = false;
                        existingObj.formValidate.passwd = '';
                        existingObj.formValidate.passwdCheck = '';

                    })
                    .catch(function (error) {
                        if (error.response.data.errors.passwd) {

                            notification.error({
                                message: 'Notification',
                                description: error.response.data.errors.passwd,
                            });
                        }
                    });
                } else {
                }
            })
            

        }
    },
    async created(){
        let id = this.$route.params.id
        let existingObj = this;
        await axios.get(`/api/admin/getUserEdit/${id}`)
        .then(function (response) {
            existingObj.formValidate.userType = response.data.userType
            existingObj.formValidate.id = response.data.id
            existingObj.formValidate.firstName = response.data.firstName  
            existingObj.formValidate.lastName = response.data.lastName  
            existingObj.formValidate.middleInitial = response.data.middleInitial  
            existingObj.formValidate.middleInitial = response.data.middleInitial  
            existingObj.formValidate.email = response.data.email
            existingObj.formValidate.age = response.data.age
            existingObj.formValidate.address = response.data.address
            existingObj.formValidate.phoneNumber = response.data.phoneNumber
            existingObj.formValidate.gender = response.data.gender
            existingObj.formValidate.bloodType = response.data.bloodType
            console.log(response.data.userType);
        })
        .catch(function (error) {
            console.log(error)
        });
    },
    beforeRouteEnter(to, from, next) {
        if(window.Laravel.userType == 'User'){
            next({ path: from.path });
        }
        next();    
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