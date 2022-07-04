<template>
    <div>
        <map-content></map-content>

        <registration-form v-on:change="this.fetchMembersCount"></registration-form>

        <div class="members-link">
            <router-link class="my-link " to="/members">All members ({{ $data.members }})</router-link>
        </div>
    </div>
</template>

<script>
import RegistrationForm from "../components/RegistrationForm";

export default {
    name: "Index",
    components: {RegistrationForm},
    data() {
        return {
            step: 1,
            totalStep: 3,
            members: {}
        }
    },
    methods: {
        fetchMembersCount: function () {
            axios.get('/getMembersCount')
                .then(res => {
                        this.members = res.data;
                    }
                );
        }
    },
    beforeMount() {
        this.fetchMembersCount()
    },
    updated() {
        this.fetchMembersCount()
    },
    
}
</script>

<style scoped>

</style>
