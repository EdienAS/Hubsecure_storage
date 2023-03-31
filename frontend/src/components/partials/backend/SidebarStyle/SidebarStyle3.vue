<template>
    <!-- Fixed Side Menu -->
<div class="dashboard3-fixed-menu">
    <div class="dashboard3-info bg-primary p-2 rounded">
        <a href="#"  aria-expanded="true" v-b-toggle.payment  class="payment" data-toggle="collapse" >
            <i class="ri-list-check"></i>
        </a>
         <b-collapse id="payment" :visible="true">
        <ul class="iq-submenu collapse show list-inline m-0 p-0 mt-2">
            <li>
                <router-link :to="{ name: 'gallery.grid',}" data-toggle="tooltip" data-placement="right" title="School"><i
                        class="las la-images iq-arrow-left"></i></router-link>
            </li>
            <li>
                <router-link :to="{ name: 'blog.simple'}" data-toggle="tooltip" data-placement="right" title="Hotel"><i
                        class="las la-blog iq-arrow-left"></i></router-link>
            </li>
            <li>
                <router-link :to="{ name: 'layout.dashboard2',}" data-toggle="tooltip" data-placement="right" title="Restaurant"><i
                        class="las la-share-alt"></i></router-link>
            </li>
            <li>
                <router-link :to="{name: 'table.basic-table'}" data-toggle="tooltip" data-placement="right" title="Hospital"><i
                        class="las la-border-all"></i></router-link>
            </li>
            <li>
                <router-link :to="{ name: 'app.email-listing'}" data-toggle="tooltip" data-placement="right" title="Email"><i
                        class="las la-envelope-square"></i></router-link>
            </li>
            <li>
                <router-link :to="{name: 'app.chat'}" data-toggle="tooltip" data-placement="right" title="Chat"><i
                        class="lab la-rocketchat"></i></router-link>
            </li>
            <li>
                <router-link :to="{name: 'pages.faq',}" data-toggle="tooltip" data-placement="right" title="Faq"><i
                        class="las la-drafting-compass"></i></router-link>
            </li>
            <li>
                <router-link :to="{name: 'auth.login'}" data-toggle="tooltip" data-placement="right" title="Sign in"><i
                        class="las la-sign-in-alt"></i></router-link>
            </li>
            <li>
                <router-link :to="{name: 'auth.register'}" data-toggle="tooltip" data-placement="right" title="Sign Out"><i
                        class="las la-sign-out-alt"></i></router-link>
            </li>
        </ul>
         </b-collapse>
    </div>
</div>
<!-- Fixed Side Menu End -->
</template>
<script lang="js">
export default {
    name:"SidebarStyle5"
}
</script>