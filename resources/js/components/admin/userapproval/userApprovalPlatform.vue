<template>
  <div class="p-2">
    <div class="m-5 bg-white shadow-inner shadow-lg rounded px-10 py-5">
      <div class="flex justify-center text-2xl mb-3">
        User Approval
      </div>

      <a-table :data-source="users" :columns="columns" size="small">
        <template #headerCell="{ column }">
          <template v-if="column.key === 'title'">
            <span style="color: #1890ff">Title</span>
          </template>

        </template>
        <template
          #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }"
        >
          <div style="padding: 8px">
            <a-input
              ref="searchInput"
              :placeholder="`Search ${column.dataIndex}`"
              :value="selectedKeys[0]"
              style="width: 188px; margin-bottom: 8px; display: block"
              @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
              @pressEnter="handleSearch(selectedKeys, confirm, column.dataIndex)"
            />
            <a-button
              type="primary"
              size="small"
              style="width: 90px; margin-right: 8px"
              @click="handleSearch(selectedKeys, confirm, column.dataIndex)"
            >
              <template #icon><SearchOutlined /></template>
              Search
            </a-button>
            <a-button size="small" style="width: 90px" @click="handleReset(clearFilters)">
              Reset
            </a-button>
          </div>
        </template>
        <template #customFilterIcon="{ filtered }">
          <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
        </template>
        <template #bodyCell="{ text, column, record, index}">
          <span v-if="searchText && searchedColumn === column.dataIndex">
            <template
              v-for="(fragment, i) in text
                .toString()
                .split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))"
            >
              <mark
                v-if="fragment.toLowerCase() === searchText.toLowerCase()"
                :key="i"
                class="highlight"
              >
                {{ fragment }}
              </mark>
              <template v-else>{{ fragment }}</template>
            </template>
          </span>
          <template v-else-if="column.key === 'action'">
            <span>
              <a @click="openModal(index)">View</a>
            </span>
            <Modal
                v-model="modal"
                :closable="false"
                :footer-hide="true"
                title="User Identification Picture"
                width="1000">
                <template #header>
                  <div class="text-center">
                    <h2>User Identification Picture</h2>
                  </div>
                </template>
                <div class="flex justify-center h-[20rem]">
                  <Image :src="`/id/${modalData.idPicName}`" class="object-cover border p-2" />
                </div>
                <div class="space-x-2 mt-3 text-right">
                  <a @click="approve(index)">Approve</a>
                  <a-divider type="vertical" />
                  <a @click="disapprove(index)">Disapprove</a>
                </div>
            </Modal> 
          </template>
          <template v-else-if="column.key === 'name'">
              <p>{{record.lastName}}, {{ record.firstName }} {{ record.middleInitial }}</p>
          </template>
        </template>

      </a-table>
    </div>
  </div>
</template>
<script>
import { notification } from 'ant-design-vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { defineComponent, reactive, ref, toRefs } from 'vue';

export default defineComponent({
  components: {
    SearchOutlined,
  },
  setup() {
    const state = reactive({
      searchText: '',
      searchedColumn: '',
    });
    const searchInput = ref();
    const columns = [{
      title: 'Name',
      dataIndex: 'name',
      key: 'name',
      customFilterDropdown: true,
      onFilter: (value, record) => record.name.toString().toLowerCase().includes(value.toLowerCase()),
      onFilterDropdownVisibleChange: visible => {
        if (visible) {
          setTimeout(() => {
            searchInput.value.focus();
          }, 100);
        }
      },
    }, {
      title: 'Email',
      dataIndex: 'email',
      key: 'email',
      customFilterDropdown: true,
      onFilter: (value, record) => record.email.toString().toLowerCase().includes(value.toLowerCase()),
      onFilterDropdownVisibleChange: visible => {
        if (visible) {
          setTimeout(() => {
            searchInput.value.focus();
          }, 100);
        }
      },
    }, {
      title: 'Action',
      key: 'action',
      width: 200,
    }];
    const handleSearch = (selectedKeys, confirm, dataIndex) => {
      confirm();
      state.searchText = selectedKeys[0];
      state.searchedColumn = dataIndex;
    };
    const handleReset = clearFilters => {
      clearFilters({
        confirm: true,
      });
      state.searchText = '';
    };
    return {
      columns,
      handleSearch,
      handleReset,
      searchInput,
      ...toRefs(state)
    }
  },
  methods: {
    remove(key){
      // this.articles.value = this.articles.value.filter(item => item.key !== key);
      let id = this.users[key].id
      this.users.splice(key, 1);
      // let id = this.articles[key]

      axios.post(`/api/admin/deleteArticle/${id}`)
      .then(function (response) {
        notification.success({
            message: 'Notification',
            description: 'The Article is Successfully Deleted',
        });
      })
      .catch(function (error) {
        
        console.log(error);
      });
    },
    approve(key){
      let existingObj = this;
      let id = this.users[key].id
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post(`/api/admin/userApproved/${id}`)
        .then(function (response) {
          existingObj.users.splice(key, 1);
        })
        .catch(function (error) {
          console.log(error);
        });
      });

    },
    disapprove(key){
      let existingObj = this;
      let id = this.users[key].id
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post(`/api/admin/userDisapproved/${id}`)
        .then(function (response) {
          existingObj.users.splice(key, 1);
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
      });
    },
    async openModal(index){
      this.modalData.id = this.users[index].id;
      this.modalData.idPicName = this.users[index].idPicName;
      this.modal = true;
    },
    removeModal(){
      this.modal = false;
    }
  },

  data(){
    return{
      modalData: {
        idPicName: ''
      },
      modal: false,
      users: [],
      token: '',
    }
  },
  async created(){
    let existingObj = this;
    this.token = window.Laravel.csrfToken;
    await axios.get('/api/admin/getUserApproval')
    .then(function (response) {
      existingObj.users = response.data
      console
    })
    .catch(function (error) {

    });
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
    img.ant-image-preview-img { display: inline-block; } 
</style>