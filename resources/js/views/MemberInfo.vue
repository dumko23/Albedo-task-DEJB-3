<template>
    <div>

        <div class="border-bottom pb-3">
            <div class="mt-3 d-inline-block">
                <a class="navbar-brand text-dark back-link" @click="$router.go(-1)">Back</a>
            </div>
            <button class="edit-btn">Delete</button>
            <button class="edit-btn" @click="edit = true" >Edit</button>
            <button v-if="$data.memberShow === true" class="edit-btn" @click=" this.toggleShow">Hide Member</button>
            <button v-if="$data.memberShow === false" class="edit-btn" @click="this.toggleShow">Show Member</button>
        </div>


        <edit-member v-if="edit === true" :edit="this.edit" :member="this.member[0]"
                     @hideModal="toggleEditParent"></edit-member>


        <div class="memberList">
            <div class="w-75 justify-content-center align-self-center mx-auto mb-5 ">
                <table v-for="memberInfo in $data.member">
                    <tr class="img-tr">
                        <td class='descr'>Photo</td>
                        <td class="img-td"><img class="img-thumbnail img-fluid" :src='"../../"+memberInfo.photo'
                                                alt='user photo'></td>
                    </tr>
                    <tr v-for="(value, name) in tdNames">
                        <td class='descr'>{{ value }}</td>
                        <td>{{ memberInfo[name] || 'No data' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import EditMember from "../components/admin/EditMember";

export default {
    name: "MemberInfo",
    components: {EditMember},

    data() {
        return {
            memberShow: true,
            member: {},
            edit: false,
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
    methods: {
        toggleShow() {
            this.memberShow = this.memberShow !== true;
        },
        toggleEditParent(data) {
            this.edit = data
        }
    },
    beforeMount() {
        axios.get(`/getMemberFullData/:${this.$route.params.memberId}`)
            .then(res => {
                    this.member = res.data;
                    this.member[0]['created_at'] = new Date(this.member[0]['created_at']);
                    this.member[0]['updated_at'] = new Date(this.member[0]['updated_at']);
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

.descr {
    width: 25%;
}

img {
    max-width: 300px;
    height: auto;
    max-height: 350px;
}

.img-tr {
    height: 300px;
}

a {
    text-align: center;
}

.back-link {
    padding: 1.1rem 2rem 1.2rem;
}

.back-link:hover {
    background-color: #dee2e6;
    cursor: pointer;
}

.edit-btn {
    margin: 0;
    padding: 1.1rem 2rem 1.3rem;
    border: none;
    background-color: #ffffff;
    float: right;
}

.edit-btn:hover {
    background-color: #dee2e6;
}
</style>
