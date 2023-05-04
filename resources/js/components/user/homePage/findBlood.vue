<template>
    <div>
        <div class="flex justify-center my-10">
            <h1 class="text-2xl font-bold">NEGROS ORIENTAL PROVINCIAL HOSPITAL BLOOD BANK PORTAL</h1>
        </div>
        <div class="flex justify-center">
            <h1 class="text-lg font-base">Looking for Blood</h1>
        </div>
        <div class="flex justify-center">
            <div class="w-3/6 border shadow-lg">
                <div class="flex justify-center">    
                    <div class="w-2/4 py-5">
                        <Form ref="formValidate" :model="formValidate" :rules="ruleValidate">
                            <FormItem label="Address" prop="address">
                                <Select v-model="formValidate.address" placeholder="Select your Municipality/City">
                                    <Option value="Amlan (Ayuquitan)">Amlan (Ayuquitan)</Option>
                                    <Option value="Ayungon">Ayungon</Option>
                                    <Option value="Bacong">Bacong</Option>
                                    <Option value="Bais">Bais</Option>
                                    <Option value="Bais">Bais</Option>
                                    <Option value="Bayawan (Tolong)">Bayawan (Tolong)</Option>
                                    <Option value="Bindoy (Payabon)">Bindoy (Payabon)</Option>
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
                                    <Option value="Valencia (Luzurriaga)">Valencia (Luzurriaga)</Option>
                                    <Option value="Vallehermoso">Vallehermoso</Option>
                                    <Option value="Zamboanguita">Zamboanguita</Option>
                                </Select>
                            </FormItem>
                            <FormItem label="Type of Blood" prop="bloodType">
                                <Select v-model="formValidate.bloodType" placeholder="Select Blood Type">
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
                        </Form>
                        <div class="flex justify-center w-full">
                            <a-button key="submit" type="primary" @click="handleSubmit('formValidate')" >Find Match</a-button>
                        </div>
                    </div>
                </div>
                <div class="w-full mb-5 flex justify-center">
                    <div class="w-4/5">
                        <h1 class="text-lg">Result:</h1>
                        <div class="grid grid-cols-2  gap-4">
                            <div v-for='(donatedBlood) in donatedBloods' :key='donatedBlood.id' class="text-end border-2 p-2">
                                <p>Address: <a-tag color="cyan">{{ donatedBlood.address }}</a-tag> </p>
                                <p class="mt-1">Blood Type:  <a-tag color="green">{{ donatedBlood.bloodType }}</a-tag> </p>
                                <Button :size="buttonSize" type="dashed" class="mt-1">Chat Now!</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { UploadOutlined } from '@ant-design/icons-vue';
import { defineComponent, ref, onMounted, h } from 'vue';
import { DownloadOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
import { Modal } from 'ant-design-vue';
import { useRoute, useRouter} from 'vue-router'; 
export default defineComponent({
    components: {
    DownloadOutlined,
  },
  data(){
      return{
        buttonSize: 'small'
        ,
        formValidate: {
            bloodType: '',
            address: '',
        },
        ruleValidate: {
            bloodType: [
                { required: true, message: 'The Blood Type cannot be empty', trigger: 'blur' }
            ],
            address: [
                { required: true, message: 'The Address cannot be empty', trigger: 'blur' }
            ]
        },
        donatedBloods: []
      }
  },
  methods: {
      async handleSubmit (name) {
        let existingObj = this;
        await this.$refs[name].validate((valid) => {
            if (valid) {
                    axios.post(`/api/admin/getDonatedBlood`, this.formValidate)
                    .then(function (response) {
                        console.log(response.data);
                        existingObj.donatedBloods = response.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
            }
            
        })
          
      }
    },
    beforeRouteEnter(to, from, next) {
        if(window.Laravel.userType == 'Admin'){
            next({ path: from.path });
        }
        next();    
    }
})
</script>