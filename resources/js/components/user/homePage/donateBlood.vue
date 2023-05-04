<template>
    <div>
        <div class="flex justify-center my-10">
            <h1 class="text-2xl font-bold">NEGROS ORIENTAL PROVINCIAL HOSPITAL BLOOD BANK PORTAL</h1>
        </div>
        <div class="flex justify-center">
            <h1 class="text-lg font-base">Donate Blood  </h1>
        </div>
        <div class="flex justify-center">
            <div class="w-2/6 border shadow-lg flex justify-center">
                <div class="w-3/4 py-5">
                    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate">
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
                    <FormItem label="Do you have 8 hours of sleep?" prop="hourSleep">
                        <Select v-model="formValidate.hourSleep" placeholder="Select Option">
                            <Option value="1">Yes</Option>
                            <Option value="0">No</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="Are you an alcoholic person?" prop="alcoholic">
                        <Select v-model="formValidate.alcoholic" placeholder="Select Option">
                            <Option value="1">Yes</Option>
                            <Option value="0">No</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="Are you drug user?" prop="drugUser">
                        <Select v-model="formValidate.drugUser" placeholder="Select Option">
                            <Option value="1">Yes</Option>
                            <Option value="0">No</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="Are you a card holder in Red Cross?" prop="cardHolder">
                        <Select v-model="formValidate.cardHolder" placeholder="Select Option">
                            <Option value="1">Yes</Option>
                            <Option value="0">No</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="Current Weight (kgs)" prop="weight">
                        <Input type="number" v-model="formValidate.weight" placeholder="Enter your Weight (kgs)"></Input>
                    </FormItem>
                </Form>
                <div class="flex justify-center w-full">
                    <a-button key="submit" type="primary" @click="handleSubmit('formValidate')" >Submit</a-button>
                </div>
                
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { UploadOutlined } from '@ant-design/icons-vue';
import { defineComponent, ref, onMounted, h } from 'vue';
import { notification } from 'ant-design-vue';
import { Modal } from 'ant-design-vue';
import { useRoute, useRouter} from 'vue-router'; 
export default defineComponent({
  data(){
      return{
          formValidate: {
              bloodType: '',
              hourSleep: '',
              drugUser: '',
              alcoholic: '',
              cardHolder: '',
              weight: '',
          },
          ruleValidate: {
                bloodType: [
                  { required: true, message: 'The Blood Type cannot be empty', trigger: 'blur' }
                ],
                hourSleep: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                drugUser: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                alcoholic: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                cardHolder: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                weight: [
                    { required: true, message: 'The Weight cannot be empty', trigger: 'blur' }
                ],
          },
      }
  },
  methods: {
      async handleSubmit (name) {

        let existingObj = this;
        await this.$refs[name].validate((valid) => {
            if (valid) {
                    axios.post(`/api/admin/storeDonateBlood`, this.formValidate)
                    .then(function (response) {
                        Modal.success({
                            title: 'Submission is Complete!',
                            content: h('div', {}, [h('p', 'Please contact this Phone Number'),h('a', '09123456789'),h('p', 'for next process. Thank You!')]),
                        });
                        existingObj.$router.push('/home');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                    
            } else {
            }
            
        })
          
      },

    },
    beforeRouteEnter(to, from, next) {
        if(window.Laravel.userType == 'Admin'){
            next({ path: from.path });
        }
        next();    
    }
})
</script>