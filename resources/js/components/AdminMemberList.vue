<template>
    <div class="memberList">
        <h1 v-if="$data.members.length === 0" style="text-align: center; margin-top: 3rem;">There's no registered
            members yet!</h1>
        <table class='member-table' v-for="member in $data.members">
            <tr>
                <td class='descr'>Photo</td>
                <td><img :src='"../"+member.photo' alt='user photo'></td>
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
</template>

<script>
export default {
    name: "AdminMembersList",
    data() {
        return {
            members: {}
        }
    },
    beforeMount() {
        axios.get('/getAllMembersData')
            .then(res => {
                    this.members = res.data;
                }
            );
        console.log(window.location.href)
    }
}
</script>

<style scoped>
.my-link {
    text-decoration: none;
    color: black;
    padding: 0.5rem 1rem;
    background-color: #04AA6D;
    margin-bottom: 2rem;
}

.my-link:hover {
    background-color: darkcyan;
}

.memberList {
    margin-top: 2rem;
}

.member-table {
    border: 1px solid black;
    margin: 5px auto;
    width: 70%;
}
table {
    width: 100%;
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    letter-spacing: 1px;
    font-size: 0.8rem;
}

td, th {
    border: 1px solid rgb(190, 190, 190);
    padding: 10px 20px;
}

th {
    background-color: rgb(235, 235, 235);
}

td {
    text-align: center;
}

.descr {
    width: 25%;
}

img {
    width: 300px;
    height: auto;
}
</style>
