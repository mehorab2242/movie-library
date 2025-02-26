import {createRouter, createWebHistory} from "vue-router";

import Layout from "../portal/layout/layout.vue";

import Index from "../portal/pages/index.vue";

const company_name = "Movie Library";

const routes = [
    {path: '/', name: 'Layout', component: Layout,
        children: [
            {path: '', name: 'Index', component: Index, meta: {title: company_name + ' Home'}},
        ]
    },
];

const router = createRouter({
    history: createWebHistory(), routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {el: to.hash, behavior: 'smooth'};
        } else {
            return {top: 0, behavior: 'smooth'};
        }
    }
});

export default router;
