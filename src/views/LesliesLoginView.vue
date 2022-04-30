<template>
    <div>
        <LesliesLogin legend="Leslies Warehouse">
        </LesliesLogin>
    </div>
</template>


<script>
    import LesliesLogin from "@/components/LesliesLogin.vue";

    import store from "@/store/index.js";
    export default {
        name: 'LesliesLoginView',
        components: {
            LesliesLogin,
        },
        computed: {
            auth: function() {
                return store.state.auth;
            }
        }
    }
</script>

