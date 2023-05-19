<template>
  <div class="m-5 bg-white shadow-inner shadow-lg rounded px-10 py-5">
        <div class="flex justify-center text-2xl mb-3">
            Blood Inventory
        </div>

        <a-button  type="primary" @click="this.$router.push('/admin/bloodInventory/addForm')" class="mb-2">New</a-button>

        <a-table v-if="this.isLoaded" :columns="columns" :data-source="data" class="components-table-demo-nested">
        <template #bodyCell="{ text, column, record, index}">
          <template v-if="column.key === 'action'">
            <span>
              <a @click="editForm(record.id)">Edit</a>
            
              <a-divider type="vertical" />
              <a-popconfirm
                v-if="data.length"
                title="Sure to delete?"
                @confirm="remove(index)"
              >
                <a class="hover:text-red-500">Remove</a>
              </a-popconfirm>
            </span>
          </template>
        </template>
        <template #expandedRowRender = {index}>
          <table class="table-auto">
            <thead>
              <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Town/City</th>
                <th>Gender</th>
                <th>Barcode</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ data[index].firstName }} {{ data[index].lastName }}</td>
                <td>{{ data[index].age }} </td>
                <td>{{ data[index].address }} </td>
                <td>{{ data[index].gender }} </td>
                <td>{{ data[index].barcode }} </td>
              </tr>
            </tbody>
          </table>
        </template>
      </a-table>
    </div>
  </template>
  <script>
  import { DownOutlined } from '@ant-design/icons-vue';
  import { notification } from 'ant-design-vue';
  import { defineComponent, ref } from 'vue';

  const columns = [{
    title: 'Blood Type',
    dataIndex: 'bloodType',
    key: 'bloodType',
  }, {
    title: 'Date of Donate',
    dataIndex: 'donateDate',
    key: 'donateDate',
  }, {
    title: 'Date of Expiration',
    dataIndex: 'expireDate',
    key: 'expireDate',
  }, {
    title: 'Action',
    key: 'action',
    width: 200,
  }];

  const data = [];


  const innerColumns = [{
    title: 'Name',
    dataIndex: 'name',
    key: 'name',
  }, {
    title: 'Town/City',
    dataIndex: 'address',
    key: 'address',
  }, {
    title: 'Gender',
    dataIndex: 'gender',
    key: 'gender',
  }, {
    title: 'Barcode',
    dataIndex: 'barcode',
    key: 'barcode',
  }];

  const innerData = [];

  export default defineComponent({
    components: {
      DownOutlined,
    },
    setup() {
      return {
        data,
        columns,
        innerColumns,
        innerData,
        isLoaded: ref(false),
      };
    },
    data(){
      return {

      };
    },
    methods: {
      remove(key){
        let id = this.data[key].id;
        this.data.splice(key, 1);
        console.log(id);
        axios.get('/sanctum/csrf-cookie').then(response => {
          axios.post(`/api/admin/deleteBloodInventory/${id}`)
          .then(function (response) {
            console.log(response.data);
            notification.success({
                message: 'Notification',
                description: 'Donated Blood is Successfully Deleted',
            });
          })
          .catch(function (error) {
            
            console.log(error);
          });
        });
      },
      editForm(id){
        // console.log(id);
        this.$router.push({path: '/admin/bloodInventory/editForm/' + id})
      },
    },
    async created(){
      let existingObj = this;
      await axios.get('/api/admin/getBInventory')
      .then(function (response) {
        // console.log(response.data[0].user.lastName);
        const newData = []
        for (let i = 0; i < response.data.length; ++i) {
          newData.push({
            key: i,
            id: response.data[i].id,
            donateDate: response.data[i].donateDate,
            expireDate: response.data[i].expireDate,
            bloodType: response.data[i].bloodType,
            age: response.data[i].age,
            firstName: response.data[i].firstName,
            lastName: response.data[i].lastName,
            gender: response.data[i].gender,
            address: response.data[i].address,
            barcode: '',
          });
        }
        console.log(newData);
        existingObj.data = newData
        existingObj.innerData = newData
        existingObj.isLoaded = true;
      })
      .catch(function (error) {

      });
    }
  });
  </script>