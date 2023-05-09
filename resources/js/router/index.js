import {createWebHistory, createRouter} from "vue-router";


// User
import home from '../components/user/homePage/home.vue';
import donateBlood from '../components/user/homePage/donateBlood.vue';
import findBlood from '../components/user/homePage/findBlood.vue';

import chatBox from '../components/user/chatbox.vue';

// Admin
import userPlatform from '../components/admin/user/userPlatform.vue';
import editUserForm from '../components/admin/user/editForm.vue';

// User Approval
import userApprovalPlatform from '../components/admin/userApproval/userApprovalPlatform.vue';

// Login
import login from '../components/login.vue';

// Dashboard
import dashboard from '../components/dashboard.vue';

// Register
import register from '../components/register.vue';

export const routes = [
    // Login
    {
        name: 'login',
        path: '/',
        component: login,
    },
    {
        name: 'register',
        path: '/register',
        component: register,
    },
    {
        path: '/',
        component: dashboard,
        meta : {requiresAuth: true},
        children:[
            // User
            {
                name: 'home',
                path: '/home',
                component: home,
            },
            {
                name: 'donateBlood',
                path: '/donateBlood',
                component: donateBlood,
            },
            {
                name: 'findBlood',
                path: '/findBlood',
                component: findBlood,
            },
            {
                name: 'chatBox',
                path: '/chatBox',
                component: chatBox,
  
            },

            // Admin
            // User Approval Management
            {
                name: 'userApprovalPlatform',
                path: '/admin/userApprovalPlatform',
                component: userApprovalPlatform  
            },

            //User Management
            {
                name: 'userPlatform',
                path: '/admin/userPlatform',
                component: userPlatform  
            },
            {
                name: 'editUserForm',
                path: '/admin/userPlatform/editForm/:id',
                component: editUserForm,  
                props:true
            },
        ]
    },

    
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)){
        if(!window.Laravel.isLoggedin){
            next({
                name: "/register"
            })
        }
         else {
            next();
        }
    } else {
        next();
    }

});


export default router;