import {createWebHistory, createRouter} from "vue-router";

// Home
import portal from '../components/portal.vue';

// User
import home from '../components/user/home.vue';
import chatbox from '../components/user/chatbox.vue';

// Admin
import userPlatform from '../components/admin/user/userPlatform.vue';
import editUserForm from '../components/admin/user/editForm.vue';

// User Approval
import userApprovalPlatform from '../components/admin/userApproval/userApprovalPlatform.vue';

// Settings
import setting from '../components/admin/settings/setting.vue';

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
        path: '/portal',
        component: portal,
        children:[
            {
                name: 'home',
                path: '/portal/home',
                component: home,
            },
            {
                name: 'chatbox',
                path: '/portal/chatbox',
                component: chatbox,
            },
        ]
    },

    {
        path: '/admin',
        component: dashboard,
        meta : {requiresAuth: true},
        children:[
            // Admin
            {
                name: 'userApprovalPlatform',
                path: '/admin/userApprovalPlatform',
                component: userApprovalPlatform  
            },

            //User 
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
            // Settings
            {
                name: 'setting',
                path: '/admin/setting',
                component: setting  
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
                name: "login"
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