<template>
    <div class="container">
        <div class="memberList">
            <h1 v-if="$data.members.length === 0"
                class="mb-5"
                style="text-align: center; margin-top: 3rem;">There's no registered
                members yet!</h1>
            <h3 v-if="$data.members.length > 0">Total Members: {{ $data.members.length }}</h3>

            <confirm-modal v-if="confirmDelete === true"
                           :message="'Delete this Member'"
                           :prop="'deleteMember'"
                           @cancelModal="deleteMember"
                           @confirmModal="deleteMember"></confirm-modal>


            <edit-member v-if="editMember === true"
                         :edit="this.editMember"
                         :member="this.memberToEdit"
                         @hideModal="toggleEditParent"></edit-member>

            <div class="w-100 justify-content-center align-self-center mx-auto mb-5 ">
                <table class='table member-table align-self-center' ref="table">
                    <thead class="table-secondary">
                    <tr class="trHead">
                        <th class='photoHead text-center'>Photo</th>
                        <th class='text-center'>Full Name</th>
                        <th class='text-center'>Report Subject</th>
                        <th class='text-center'>Email</th>
                        <th class='text-center'>Visibility</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="tr-50" v-for="member in $data.members">
                        <td class="img-td"><img class=" img-fluid" :src='"../images/"+member.photo'
                                                alt='user photo'></td>
                        <td>{{ member.firstName }} {{ member.lastName }}</td>
                        <td>{{ member.subject }}</td>
                        <td>
                            <a class="navbar-brand text-dark email-link"
                               :href="`mailto:${member.email}`">{{ member.email }}</a></td>
                        <td>
                            <span :class="member.visibility ? 'visibility-color-green' : 'visibility-color-red'">
                                {{ member.visibility ? 'visible' : 'hidden' }}</span>
                        </td>
                        <td><a class="w-100 dropdown-item data-link"
                               :href="'/admin/member-info/'+member.memberId">Show full data</a>
                            <div class="flex-row d-flex justify-content-around">
                                <button class="icon-button w-100" @click="editMemberCall(member)">
                                    <font-awesome-icon icon="fa-solid fa-pen"/>
                                </button>
                                <button class="icon-button w-100" v-if="!!member.visibility === false"
                                        @click="toggleShow(member)">
                                    <font-awesome-icon icon="fa-solid fa-eye"/>
                                </button>
                                <button class="icon-button w-100" v-if="!!member.visibility === true"
                                        @click="toggleShow(member)">
                                    <font-awesome-icon icon="fa-solid fa-eye-slash"/>
                                </button>
                                <button class="icon-button w-100" @click="deleteMemberCall(member)">
                                    <font-awesome-icon icon="fa-solid fa-trash"/>
                                </button>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <a v-show="this.members.length > 7" style="position: fixed; bottom: 0; left: 0;"
           class="my-link navbar-brand text-dark back-link" href="#">To the top</a>
    </div>

</template>

<script>
import ConfirmModal from "./ConfirmModal";
import EditMember from "./EditMember";

export default {
    name: "AdminMembersList",
    components: {ConfirmModal, EditMember},
    data() {
        return {
            members: {},
            confirmDelete: false,
            memberToDelete: '',
            editMember: false,
            memberToEdit: '',
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
        toggleShow(member) {
            member.visibility = !member.visibility;
            axios.post('/toggleVisibility', {
                show: member.visibility,
                email: member.email
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
        deleteMember(data) {
            if (data === true) {
                axios.post('/deleteMember', {
                    email: this.memberToDelete
                })
                    .then(
                        response => console.log(response)
                    ).catch(
                    error => console.log(error)
                )
            }
            axios.get('/getMembersInfo')
                .then(res => {
                        this.members = res.data;
                    }
                );
            this.confirmDelete = false;
        },
        deleteMemberCall(member) {
            this.memberToDelete = member.email;
            this.confirmDelete = true;
        },
        editMemberCall(member) {
            axios.get(`/getMemberFullData/:${member.memberId}`)
                .then(res => {
                        this.memberToEdit = res.data[0];
                        this.editMember = true;
                    }
                );

        },
        toggleEditParent(data) {
            this.editMember = data
            axios.get('/getMembersInfo')
                .then(res => {
                        this.members = res.data;
                    }
                );
        },
    },
    beforeMount() {
        axios.get('/getMembersInfo')
            .then(res => {
                    this.members = res.data;
                }
            );
    },
    updated() {
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
    border-bottom: none;
    letter-spacing: 1px;
    font-size: 0.8rem;
    box-sizing: border-box;
}

td {
    text-align: center;
    vertical-align: middle;
}

img {
    object-fit: contain;
}

.img-td {
    height: 40px;
    width: 40px;
}

a {
    text-align: center;
}

.data-link {
    border: none;
    border-bottom: 2px solid #dee2e6;
}

.email-link {
    font-size: 0.8rem;
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

.trHead {
    height: 25px;
}

.photoHead {
    width: 60px;
}

.icon-button {
    border: none;
    background-color: #ffffff;
}

.icon-button:hover {
    background-color: #dee2e6;
}

.tr-50 {
    height: 50px;
}

.visibility-color-green {
    color: green;
}

.visibility-color-red {
    color: red;
}

</style>
