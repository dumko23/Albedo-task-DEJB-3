<template>
    <div>
        <div class="mt-3">
            <a class="navbar-brand text-dark back-link" @click="$router.go(-1)">Back</a>
        </div>

        <div class="memberList">
            <div class="w-75 justify-content-center align-self-center mx-auto mb-5 ">
                <table v-for="member in $data.members">
                    <tr class="img-tr">
                        <td class='descr'>Photo</td>
                        <td class="img-td"><img class="img-thumbnail img-fluid" :src='"../"+member.photo'
                                                alt='user photo'></td>
                    </tr>
                    <tr v-for="(value, name) in tdNames">
                        <td class='descr'>{{ value }}</td>
                        <td>{{ member[name] || 'No data' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MemberInfo",
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
        axios.get(`/getMemberFullData/:${this.$route.params.memberId}`)
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
    max-width: 100px;
    height: auto;
    max-height: 150px;
}

.img-tr {
    height: 300px;
}

a {
    text-align: center;
}

.data-link {
    border: 2px solid rgb(200, 200, 200);
    border-top: none;
}

.back-link {
    padding: 2px 5px;
}

.back-link:hover {
    background-color: #dee2e6;
    cursor: pointer;
}
</style>
