
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Posts from '../components/jurnal/Posts';
import EditPost from '../components/jurnal/EditPost';
import AddPost from '../components/jurnal/AddPost';
import LihatPost from '../components/jurnal/LihatPost';
import Uraian from '../components/uraian/Uraian';
import AddUraian from '../components/uraian/AddUraian';
import EditUraian from '../components/uraian/EditUraian';

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
    },
    {
        name: 'uraian',
        path: '/uraian',
        component: Uraian
    },
    {
        name: 'adduraian',
        path: '/uraian/add',
        component: AddUraian
    },
    {
        name: 'edituraian',
        path: '/uraian/edit/:id',
        component: EditUraian
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes: routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'bg-gradient-primary',

});

export default router;
