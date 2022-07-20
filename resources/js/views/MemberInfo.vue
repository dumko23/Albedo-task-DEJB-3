<template>
    <div>

        <div class="border-bottom pb-3">
            <div class="mt-3 d-inline-block">
                <a class="navbar-brand text-dark back-link" href="/admin/dashboard">Back</a>
            </div>
            <button class="edit-btn" @click="confirm = true">Delete</button>
            <button class="edit-btn" @click="edit = true">Edit</button>
            <button v-if="$data.memberVisibility === true" class="edit-btn" @click="toggleShow">Hide Member</button>
            <button v-if="$data.memberVisibility === false" class="edit-btn" @click="toggleShow">Show Member</button>
        </div>


        <edit-member v-if="edit === true"
                     :edit="this.edit"
                     :member="this.member"
                     @hideModal="toggleEditParent"></edit-member>


        <confirm-modal v-if="confirm === true"
                       :message="'Delete this Member'"
                       :prop="'deleteMember'"
                       @cancelModal="deleteMember"
                       @confirmModal="deleteMember"></confirm-modal>

        <div class="memberList">
            <div class="w-75 justify-content-center align-self-center mx-auto mb-5 ">
                <table v-if="member.email">
                    <tr class="img-tr">
                        <td class='descr'>Photo</td>
                        <td class="img-td"><img class="img-thumbnail img-fluid" :src="'/images/'+member.photo"
                                                alt='user photo'></td>
                    </tr>
                    <tr v-for="(value, name) in tdNames">
                        <td class='descr'>{{ value }}</td>
                        <td>{{ member[name] || 'No data' }}</td>
                    </tr>
                    <tr>
                        <td class="descr">Visibility</td>
                        <td :key="memberVisibility">{{ !!memberVisibility }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import EditMember from "../components/admin/EditMember";
import ConfirmModal from "../components/admin/ConfirmModal";
import router from "../router";

export default {
    name: "MemberInfo",
    components: {ConfirmModal, EditMember},

    data() {
        return {
            memberVisibility: true,
            member: {},
            confirm: false,
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
            this.memberVisibility = !this.memberVisibility;
            axios.post('/toggleVisibility', {
                show: this.memberVisibility,
                email: this.member.email
            })
                .then(res => {
                        console.log(res);
                    }
                )
                .catch(
                    error => {
                            this.error_exist = false;
                            console.log(error)
                    });
        },
        toggleEditParent(data) {
            this.edit = data
            axios.get(`/getMemberFullData/:${this.$route.params.memberId}`)
                .then(res => {
                        this.member = res.data[0];
                        this.member['created_at'] = new Date(this.member['created_at']);
                        this.member['updated_at'] = new Date(this.member['updated_at']);
                    }
                );
        },
        deleteMember(data) {
            this.confirm = false;
            if (data === true) {
                axios.post('/deleteMember', {
                    email: this.member.email
                })
                    .then(
                        response => console.log(response)
                    ).catch(
                    error => console.log(error)
                ).then(() => {
                    router.push("/admin/dashboard")
                })
            }
        }
    },
    beforeMount() {
        axios.get(`/getMemberFullData/:${this.$route.params.memberId}`)
            .then(res => {
                    this.member = res.data[0];
                    this.member['created_at'] = new Date(this.member['created_at']);
                    this.member['updated_at'] = new Date(this.member['updated_at']);
                    this.memberVisibility = !!this.member['visibility'];
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
