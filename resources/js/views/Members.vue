<template>
    <div>
        <router-link class="my-link" id="#top" to="/">Back to Register Form</router-link>


        <div class="memberList">
            <h1 v-if="$data.members.length === 0" style="text-align: center; margin-top: 3rem;">There's no registered
                members yet!</h1>
            <table class='member-table' v-for="member in $data.members">
                <tr>
                    <td class='descr'>Photo</td>
                    <td><img :src='member.photo' alt='user photo'></td>
                </tr>
                <tr>
                    <td class='descr'>Full Name</td>
                    <td>{{ member.firstName }} {{ member.lastName }}</td>
                </tr>
                <tr>
                    <td class='descr'>Report Subject</td>
                    <td>{{ member.subject }}</td>
                </tr>
                <tr>
                    <td class='descr'>Email</td>
                    <td><a class="my-link" :href="`mailto:${member.email}`">{{ member.email }}</a></td>
                </tr>
            </table>

        </div>

        <a style="position: fixed; bottom: 0; left: 0;" class="my-link" href="#">To the top
        </a>
    </div>
</template>

<script>
export default {
    name: "Members",
    data() {
        return {
            members: {}
        }
    },
    beforeMount() {
        axios.get('/getMembers')
            .then(res => {
                    this.members = res.data;
                }
            );
    }
}
</script>

<style scoped>

</style>
