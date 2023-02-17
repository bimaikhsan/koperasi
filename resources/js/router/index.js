
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Posts from '../components/Posts';
import EditPost from '../components/EditPost';
import AddPost from '../components/AddPost';
import LihatPost from '../components/LihatPost';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Dashboard
    },
    // {
    //     name: 'register',
    //     path: '/register',
    //     component: Register
    // },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    // {
    //     name: 'dashboard',
    //     path: '/dashboard',
    //     component: Dashboard
    // },
    {
        name: 'posts',
        path: '/posts',
        component: Posts
    },
    {
        name: 'addpost',
        path: '/posts/add',
        component: AddPost
    },
    {
        name: 'editpost',
        path: '/posts/edit/:id',
        component: EditPost
    },
    {
        name: 'lihatpost',
        path: '/posts/lihat/:id',
        component: LihatPost
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes: routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'bg-gradient-primary',

});

export default router;
