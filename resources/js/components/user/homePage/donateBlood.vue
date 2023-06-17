<template>
    <div class="h-screen bgImage">
        <div class="flex justify-center pt-10">
            <h1 class="text-2xl font-bold text-white uppercase">Web Portal for Blood Bank in Negros Oriental Provincial Hospital</h1>
        </div>
        <div class="flex justify-center">
            <h1 class="text-lg font-base text-white">Donate Blood  </h1>
        </div>
        <div class="flex justify-center h-4/5">
            <div class="w-3/6 border shadow-lg bg-white flex justify-center overflow-auto">
                <div class="w-3/4 py-5 ">
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
                        <FormItem label="Do you currently feel healthy and well?" prop="validation1">
                            <Select v-model="formValidate.validation1" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Are you at least 17 years old (or the age requirement set by your local blood bank)?" prop="validation2">
                            <Select v-model="formValidate.validation2" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Do you weigh at least 110 pounds (50 kilograms)?" prop="validation3">
                            <Select v-model="formValidate.validation3" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you had a fever in the past 48 hours?" prop="validation4">
                            <Select v-model="formValidate.validation4" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you had a major surgery in the past 6 months?" prop="validation5">
                            <Select v-model="formValidate.validation5" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you received a blood transfusion in the past 12 months?" prop="validation6">
                            <Select v-model="formValidate.validation6" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Do you have a history of heart disease, stroke, or heart surgery?" prop="validation7">
                            <Select v-model="formValidate.validation7" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Do you have a bleeding disorder or take blood-thinning medications?" prop="validation8">
                            <Select v-model="formValidate.validation8" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Are you currently pregnant or have you given birth in the past 6 weeks?" prop="validation9">
                            <Select v-model="formValidate.validation9" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you traveled to a malaria-risk country in the past 3 months?" prop="validation10">
                            <Select v-model="formValidate.validation10" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you engaged in risky sexual behaviors or have been diagnosed with a sexually transmitted infection (STI)?" prop="validation11">
                            <Select v-model="formValidate.validation11" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you used intravenous drugs (illegal substances) in the past 12 months?" prop="validation12">
                            <Select v-model="formValidate.validation12" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you tested positive for HIV/AIDS or hepatitis?" prop="validation13">
                            <Select v-model="formValidate.validation13" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                        <FormItem label="Have you had cancer in the past 5 years?" prop="validation14">
                            <Select v-model="formValidate.validation14" placeholder="Select Here">
                                <Option value="1">Yes</Option>
                                <Option value="0">No</Option>
                            </Select>
                        </FormItem>
                    </Form>
                    <div class="flex justify-center w-full pb-5">
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
              validation1: '',
              validation2: '',
              validation3: '',
              validation4: '',
              validation5: '',
              validation6: '',
              validation7: '',
              validation8: '',
              validation9: '',
              validation10: '',
              validation11: '',
              validation12: '',
              validation13: '',
              validation14: '',
          },
          ruleValidate: {
                bloodType: [
                  { required: true, message: 'The Blood Type cannot be empty', trigger: 'blur' }
                ],
                validation1: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation2: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation3: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation4: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation5: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation6: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation7: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation8: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation9: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation10: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation11: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation12: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation13: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
                validation14: [
                    { required: true, message: 'This Section cannot be empty', trigger: 'blur' }
                ],
          },
      }
  },
  methods: {
      async handleSubmit (name) {
        let existingObj = this;
        await this.$refs[name].validate((valid) => {
            if (valid) {
                    if(
                    this.formValidate.validation1 == 0 || this.formValidate.validation2 == 0 ||
                    this.formValidate.validation3 == 0 || this.formValidate.validation4 == 1 ||
                    this.formValidate.validation5 == 1 || this.formValidate.validation6 == 1 ||
                    this.formValidate.validation7 == 1 || this.formValidate.validation8 == 1 ||
                    this.formValidate.validation9 == 1 || this.formValidate.validation10 == 1 || 
                    this.formValidate.validation11 == 1 || this.formValidate.validation12 == 1 || 
                    this.formValidate.validation13 == 1 || this.formValidate.validation14 == 1){
                        notification.error({
                            message: 'Notification',
                            description: 'Based on the data inputs, you are not eligible to donate blood',
                        });
                    } else {
                        axios.post(`/api/admin/storeDonateBlood`, this.formValidate)
                        .then(function (response) {
                            console.log(response.data);
                            Modal.success({
                                title: 'Submission is Complete!',
                                content: h('div', {}, [h('p', 'Please wait for a patient matching your blood type or contact this Phone Number'),h('a', '09123456789'),h('p', 'for next process. Thank You!')]),
                            });
                            existingObj.$router.push('/home');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }  
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


<style scoped>
.bgImage {
    background-image: url('/img/background.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    color: #FFFFFF;
}
</style>

