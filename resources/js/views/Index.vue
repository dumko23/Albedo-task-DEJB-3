<template>
    <div>
        <map-content></map-content>

        <registration-form @changeStep="fetchMembersCount"></registration-form>

        <div class="members-link">
            <router-link class="my-link " to="/members">All members ({{
                    $data.members
                }})
            </router-link>
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
            members: 0
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
    beforeDestroy() {
        localStorage.clear()
    }

}
</script>

<style scoped>

</style>
