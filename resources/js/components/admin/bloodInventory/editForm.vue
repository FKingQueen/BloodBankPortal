<template>

    <div class="m-5 bg-white shadow-inner shadow-lg rounded px-10 py-5">
        <div class="flex justify-center text-2xl mb-3">
            Blood Inventory
        </div>
        <a-button @click="this.$router.push('/admin/bloodInventory')" class="mb-2">Back</a-button>
        <div>
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="95" class="px-10" >
                <FormItem label="First Name" prop="firstName">
                    <Input v-model="formValidate.firstName" placeholder="Enter First Name"></Input>
                </FormItem>
                <FormItem label="Last Name" prop="lastName">
                    <Input v-model="formValidate.lastName" placeholder="Enter Last Name"></Input>
                </FormItem>
                <FormItem label="Middle Initial" prop="middleInitial">
                    <Input v-model="formValidate.middleInitial" placeholder="Enter your Middle Initial"></Input>
                </FormItem>
                <FormItem label="Birth Data" prop="birthDate" class="w-full ">
                    <Input type="date" v-model="formValidate.birthDate" class="w-full rounded"></Input>
                </FormItem>
                <FormItem label="Gender" prop="gender">
                    <Select v-model="formValidate.gender" placeholder="Select your Gender">
                        <Option value="Male">Male</Option>
                        <Option value="Female">Female</Option>
                    </Select>
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
                <div class="flex justify-end">
                    <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Update</a-button>
                </div>
            </Form>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, watch } from 'vue';
import { useRoute, useRouter} from 'vue-router';
import { notification } from 'ant-design-vue';

export default defineComponent({
    data(){
        return{
            formValidate: {
                firstName: '',
                lastName: '',
                middleInitial: '',
                address: '',
                birthDate: '',
                gender: '',
                bloodType: '',
            },
            ruleValidate: {
                firstName: [
                    { required: true, message: 'The First Name cannot be empty', trigger: 'blur' }
                ],
                lastName: [
                    { required: true, message: 'The Last Name cannot be empty', trigger: 'blur' }
                ],
                middleInitial: [
                    { required: true, message: 'The Middle Initial cannot be empty', trigger: 'blur' }
                ],
                address: [
                    { required: true, message: 'The Town/City cannot be empty', trigger: 'blur' }
                ],
                birthDate: [
                    { required: true, message: 'The Birth Date cnnot be empty', trigger: 'blur' }
                ],
                gender: [
                    { required: true, message: 'The Gender cannot be empty', trigger: 'blur' }
                ],
                bloodType: [
                    { required: true, message: 'The Blood Type cannot be empty', trigger: 'blur' },
                ]
            },
        }
    },
    methods: {
        async handleSubmit (name) {
            let existingObj = this;
            // console.log(name);
            console.log(this.formValidate);
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.get('/sanctum/csrf-cookie').then(response => {
                        axios.post(`/api/admin/updateBloodInventory`, this.formValidate)
                        .then(function (response) {
                            console.log(response.data);
                            notification.success({
                                message: 'Notification',
                                description: 'New Donated Blood for Inventory is Successfully Created',
                            });
                            existingObj.$router.push('/admin/bloodInventory');
                        })
                        .catch(function (error) {

                        });
                    })

                } else {
                }
            })
            
        },
    },
    async created(){
        let id = this.$route.params.id
        let existingObj = this;
        await axios.get(`/api/admin/getBloodInventoryEdit/${id}`)
        .then(function (response) {
            console.log(response.data);
            existingObj.formValidate.firstName = response.data.firstName
            existingObj.formValidate.lastName = response.data.lastName
            existingObj.formValidate.middleInitial = response.data.middleInitial  
            existingObj.formValidate.address = response.data.address
            existingObj.formValidate.birthDate = response.data.birthDate
            existingObj.formValidate.gender = response.data.gender
            existingObj.formValidate.bloodType = response.data.bloodType
            
        })
        .catch(function (error) {
            console.log(error)
        });
    }
})
</script>
