<template>
    <div class="container">
        <div class="memberList row">
            <h1 v-if="$data.members.length === 0" style="text-align: center; margin-top: 3rem;">There's no registered
                members yet!</h1>

            <div class="col-md-12  justify-content-center  mb-3 " v-for="member in $data.members">
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
                        <td class='descr'>Report Subject</td>
                        <td class="td-content">{{ member.subject }}</td>
                    </tr>
                    <tr>
                        <td class='descr'>Email</td>
                        <td class="td-content"><a class="dropdown-item" :href="`mailto:${member.email}`">{{
                                member.email
                            }}</a></td>
                    </tr>
                </table>
                <button class="w-100">Edit Member Data</button>
            </div>

            <!--        <tr v-for="(value, name) in tdNames">-->
            <!--            <td class='descr'>{{ value }}</td>-->
            <!--            <td>{{ member[name] || 'No data' }}</td>-->
            <!--        </tr>-->
        </div>
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
html {
    box-sizing: border-box;
}

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

/*.member-table {*/
/*    border: 1px solid black;*/
/*    margin-top: 5px;*/
/*    width: 100%;*/

/*}*/

table {
    width: 100%;
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    letter-spacing: 1px;
    font-size: 0.8rem;
    height: 500px;
    box-sizing: border-box;
}

td, th {
    border: 1px solid rgb(190, 190, 190);
    /*padding: 10px 10px;*/
    /*max-height: 50px;*/
}

/*.img-td{*/
/*    height: 300px;*/
/*}*/

/*th {*/
/*    background-color: rgb(235, 235, 235);*/
/*}*/

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
    /*width: auto;*/
    max-width: 300px;
    height: auto;
}

.img-tr {
    height: 300px;
}
</style>
