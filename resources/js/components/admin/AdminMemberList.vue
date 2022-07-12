<template>
    <div class="container">
        <div class="memberList">
            <h1 v-if="$data.members.length === 0"
                class="mb-5"
                style="text-align: center; margin-top: 3rem;">There's no registered
                members yet!</h1>

            <div class="w-75 justify-content-center align-self-center mx-auto mb-5 " v-for="member in $data.members">
                <table class='member-table align-self-center'>
                    <tr class="img-tr">
                        <td class='descr'>Photo</td>
                        <td class="img-td"><img class="img-thumbnail img-fluid" :src='"../"+member.photo'
                                                alt='user photo'></td>
                    </tr>
                    <tr>
                        <td class='descr'>Full Name</td>
                        <td class="td-content">{{ member.firstName }} {{ member.lastName }}</td>
                    </tr>
                    <tr>
                        <td class='descr'>Country</td>
                        <td class="td-content">{{ member.country }}</td>
                    </tr>
                    <tr>
                        <td class='descr'>Email</td>
                        <td class="td-content"><a class="navbar-brand text-dark email-link" :href="`mailto:${member.email}`">{{
                                member.email
                            }}</a></td>
                    </tr>
                    <tr>
                        <td class='descr'>Visibility</td>
                        <td class="td-content">{{ member.visibility? 'visible' : 'hidden' }}</td>
                    </tr>
                </table>
                <a class="w-100 dropdown-item data-link" :href="'/admin/member-info/'+member.memberId">Show full data</a>
            </div>
        </div>
        <a v-if="this.members.length > 1" style="position: fixed; bottom: 0; left: 0;" class="my-link navbar-brand text-dark back-link" href="#">To the top</a>
    </div>

</template>

<script>
export default {
    name: "AdminMembersList",
    data() {
        return {
            members: {},
            tdNames: {
                memberId: "Member's id in DataBase: ",
                created_at: 'Member created at: ',
                updated_at: 'Member info updated at: ',
                firstName: 'First Name: ',
                lastName: 'Last Name: ',
                birthDate: 'Birth Date: ',
                country: 'Country: ',
                phone: 'Phone: ',
                email: 'Email: ',
                subject: 'Subject: ',
                company: 'Company: ',
                position: 'Position: ',
                about: 'About: ',
            }
        }
    },
    beforeMount() {
        axios.get('/getMembersInfo')
            .then(res => {
                    this.members = res.data;
                }
            );
    }
}
</script>

<style scoped>
html {
    box-sizing: border-box;
}

.memberList {
    margin-top: 2rem;
}

table {
    width: 100%;
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    border-bottom: none;
    letter-spacing: 1px;
    font-size: 0.8rem;
    height: 500px;
    box-sizing: border-box;
}

td, th {
    border: 1px solid rgb(190, 190, 190);
}

td {
    text-align: center;
}

.td-content {
    overflow-x: hidden;
    word-break: break-word;
}

.descr {
    width: 25%;
}

img {
    max-width: 300px;
    height: auto;
    max-height: 300px;
}

.img-tr {
    height: 300px;
}

a{
    text-align: center;
}

.data-link{
    border: 2px solid rgb(200, 200, 200);
    border-top: none;
}

.email-link{
    font-size: 1rem;
}

.email-link:hover {
    background-color: #dee2e6;
}

.back-link {
    padding: 1.1rem 2rem;
}

.back-link:hover {
    background-color: #dee2e6;
    cursor: pointer;
}
</style>
